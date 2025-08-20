<?php

namespace Danupe\Plugin\User\Middlewares;

use Danupe\Core\Classes\Request;

class AuthMiddleware
{
    /**
     * Auth + Role Middleware
     * 1. Prüft ob ein User eingeloggt ist (ansonsten 403 + Login-Hinweis)
     * 2. Ermittelt anhand der Route-Konfiguration (roles) ob der User zugreifen darf
     *    - Die Route-Konfiguration wird aus allen Plugin-Configs aggregiert (getAllByKey('routes',1))
     *    - Matching der aktuellen URI berücksichtigt {id} Platzhalter und optionale Segmente [/{id}]
     */
    public function __invoke(Request $request, callable $next)
    {
        $sessionUser = danupe()->session()->get('user');
        $currentRole = $sessionUser['role'] ?? null; // null = guest

        // Wenn kein User vorhanden -> redirect zum Login
        if (empty($sessionUser)) {
            $loginRequired = danupe()->language()->get('auth.login_required') ?? 'Please log in first.';
            danupe()->session()->set('errors', [$loginRequired]);
            $requestedWith = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
            if ($requestedWith === 'littlebigtable') {
                // JSON Antwort für AJAX Tabellen Requests
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'unauthenticated', 'message' => $loginRequired]);
            } else {
                // Test-Hook: ermöglicht Tests den Redirect abzufangen
                if (isset($GLOBALS['__test_redirect_capture'])) {
                    $GLOBALS['__test_redirect_capture'] = '/login';
                } else {
                    header('Location: /login');
                }
            }
            exit;
        }

        // Role Check
        $requestPath = rtrim(parse_url($request->getUri(), PHP_URL_PATH), '/') ?: '/';
        $routes = danupe()->config()->getAllByKey('routes', 1) ?? [];
        $allowedRoles = null; // null = keine Definition -> allow

        foreach ($routes as $routePath => $definition) {
            // Nur Routen mit roles betrachten
            if (!isset($definition['roles'])) continue;

            $pattern = $routePath;
            // Optionale Segmente [ ... ] in non-capturing optional Gruppe umwandeln
            $pattern = preg_replace_callback('#\[([^\[\]]+)\]#', function ($m) {
                $inner = $m[1];
                $inner = preg_replace('#\{[^/]+\}#', '[^/]+', $inner); // Platzhalter innerhalb optionaler Segmente
                return '(?:' . $inner . ')?';
            }, $pattern);
            // Pflicht Platzhalter {param}
            $pattern = preg_replace('#\{[^/]+\}#', '[^/]+', $pattern);
            $pattern = '#^' . rtrim($pattern, '/') . '$#';

            if (preg_match($pattern, $requestPath)) {
                $allowedRoles = $definition['roles'];
                break;
            }
        }

        if (is_array($allowedRoles) && !in_array($currentRole, $allowedRoles)) {
            // Unterschiedliche Behandlung: Wenn eingeloggt aber keine Berechtigung
            http_response_code(403);
            danupe()->view()->get('plugin-user', 'frontend/403', ['title' => 'error 403']);
            exit;
        }

        $next($request);
    }
}
