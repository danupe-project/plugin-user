<?php
return [
    'up' => '
        INSERT INTO users (email, password, role) VALUES
            ("admin@danupe.com", "' . password_hash('admin', PASSWORD_BCRYPT) . '", "admin");
    ',
    'down' => '
        DELETE FROM users WHERE email = "admin@danupe.com";
    '
];
