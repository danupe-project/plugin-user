# Plugin User Tests

Diese Verzeichnis enthält alle Unit-Tests für das plugin-user Package des Danupe Framework.

## Struktur

```
tests/
├── Classes/
│   ├── AdminTest.php           # Tests für Admin Klasse
│   ├── FormTest.php            # Tests für Form Klasse
│   ├── RoleTest.php            # Tests für Role Klasse
│   ├── UserClassTest.php       # Tests für User Klasse (Classes/User.php)
│   └── ValidateTest.php        # Tests für Validate Klasse
├── Controllers/
│   ├── AuthControllerTest.php  # Tests für AuthController
│   ├── HomeControllerTest.php  # Tests für HomeController
│   └── UserControllerTest.php  # Tests für UserController
├── Middlewares/
│   └── AuthMiddlewareTest.php  # Tests für AuthMiddleware
├── Models/
│   └── UserTest.php            # Tests für User Model
└── PluginUserTestSuite.php     # Test-Suite für alle Tests
```

## Getestete Klassen

### Models
- **User**: Testet die User Model Klasse (Tabellename, Attribute)

### Controllers
- **AuthController**: Testet Login/Logout Funktionalität
- **HomeController**: Testet Login-View und Dashboard
- **UserController**: Testet CRUD-Operationen für Benutzer

### Classes
- **Admin**: Testet Admin-Prefix Funktionalität
- **Form**: Testet HTML-Form Generator (Input, Select, Textarea, etc.)
- **Role**: Testet Rollen-Management
- **User**: Testet User Helper Klasse
- **Validate**: Testet Validierungsregeln (required, email, min, max, same, unique)

### Middlewares
- **AuthMiddleware**: Testet Authentifizierung Middleware

## Tests ausführen

### Alle Tests des plugin-user Packages
```bash
phpunit www/danupe/plugin-user/tests/
```

### Spezifische Tests
```bash
# Model Tests
phpunit www/danupe/plugin-user/tests/Models/UserTest.php

# Controller Tests
phpunit www/danupe/plugin-user/tests/Controllers/

# Class Tests
phpunit www/danupe/plugin-user/tests/Classes/

# Middleware Tests
phpunit www/danupe/plugin-user/tests/Middlewares/
```

### Mit Coverage Report
```bash
phpunit --coverage-html coverage www/danupe/plugin-user/tests/
```

## Test-Kategorien

### Unit Tests
Die meisten Tests sind Unit-Tests, die einzelne Methoden und Klassen isoliert testen.

### Integration Tests
Einige Tests benötigen Mocking der Danupe-Framework Funktionen, da sie auf das Framework angewiesen sind.

## Mocking

Da das plugin-user Package stark mit dem Danupe Framework integriert ist, verwenden viele Tests Mock-Funktionen für:
- `danupe()` - Hauptframework-Funktion
- Session Management
- Database Connections
- View Rendering
- Input Handling

## Hinweise

1. **Framework-Abhängigkeiten**: Viele Tests mocken Framework-Funktionen, da das Plugin eng mit Danupe integriert ist.

2. **Exit-Statements**: Einige Controller-Methoden verwenden `exit()`, was das Testen erschwert. Diese Tests prüfen hauptsächlich, ob Methoden ohne Fehler ausgeführt werden.

3. **Output Buffering**: Tests verwenden `ob_start()` und `ob_end_clean()` um View-Output während Tests zu unterdrücken.

4. **Environment Variables**: Einige Tests setzen `$_ENV` Variablen für korrekte Funktionalität.

## Erweiterung

Um neue Tests hinzuzufügen:
1. Erstelle neue Test-Datei im entsprechenden Unterverzeichnis
2. Erweitere die `PluginUserTestSuite.php` um die neue Test-Klasse
3. Folge den bestehenden Naming-Conventions (`*Test.php`)
