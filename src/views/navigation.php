<a
    class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
    href="/<?php echo danupe()->plugin('user', 'admin')->getPrefix(); ?>/">
    <?php echo danupe()->config()->get('core.meta.title'); ?>
</a>

<ul class="mt-6">
    <?php
    $navigationItems = danupe()->config()->getAllByKey("navigation", 1);


    if (!function_exists('sortMenuArray')) {

        function sortMenuArray(array $menu): array
        {
            uasort($menu, function ($a, $b) {
                if ($a['sort'] == 1) return -1;
                if ($b['sort'] == 1) return 1;
                return $a['sort'] <=> $b['sort'];
            });
            return $menu;
        }
    }
    $navigationItems = sortMenuArray($navigationItems);

    $allRoutes = danupe()->config()->getAllByKey('routes',1) ?? [];
    $sessionUser = danupe()->session()->get('user');
    $currentRole = $sessionUser['role'] ?? 'guest';

    $isAllowed = function($url, $navItemRoles = null) use ($allRoutes, $currentRole) {
        if (is_array($navItemRoles)) {
            return in_array($currentRole, $navItemRoles, true);
        }
        // Versuche exaktes Matching zuerst
        if (isset($allRoutes[$url])) {
            $roles = $allRoutes[$url]['roles'] ?? null;
            if ($roles === null) return true; // Keine Rollen definiert -> sichtbar
            return in_array($currentRole, $roles, true);
        }
        // Fallback: Pattern Matching (mit {id} oder optionalen Segmenten)
        foreach ($allRoutes as $routePath => $definition) {
            $pattern = $routePath;
            $pattern = preg_replace_callback('#\[([^\[\]]+)\]#', function ($m) {
                $inner = $m[1];
                $inner = preg_replace('#\{[^/]+\}#', '[^/]+', $inner);
                return '(?:' . $inner . ')?';
            }, $pattern);
            $pattern = preg_replace('#\{[^/]+\}#', '[^/]+', $pattern);
            $pattern = '#^' . rtrim($pattern,'/') . '$#';
            if (preg_match($pattern, $url)) {
                $roles = $definition['roles'] ?? null;
                if ($roles === null) return true;
                return in_array($currentRole, $roles, true);
            }
        }
        return true; // Standard: sichtbar
    };

    foreach ($navigationItems as $url => $navigationItem) {
        if (danupe()->data()->get($navigationItem, 'parent', false) == false) {
            $navItemRoles = danupe()->data()->get($navigationItem,'roles');
            if (!$isAllowed($url, $navItemRoles)) continue; ?>
                <li class="relative px-6 py-3">
                    <a href="<?php echo $url; ?>" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        <i class="<?php echo danupe()->data()->get($navigationItem, 'icon'); ?> mr-3"></i>
                        <?php $titleKey = danupe()->data()->get($navigationItem, 'title');
                        $translated = $titleKey;
                        if (danupe()->data()->get($navigationItem,'translate',false)) {
                            $lang = danupe()->language()->get($titleKey);
                            if ($lang) { $translated = $lang; }
                        }
                        ?>
                        <span class="ml-4"><?php echo $translated; ?></span>
                    </a>
                </li>
    <?php
        }
    }
    ?>
</ul>