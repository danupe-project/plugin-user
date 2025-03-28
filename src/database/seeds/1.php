username VARCHAR(255) NOT NULL,

<?php

return [
    'up' => '
        INSERT INTO roles (name) VALUES
            ("admin"),
            ("user");

        INSERT INTO users (email, password, role_id) VALUES
            ("admin@danupe.com", "' . password_hash('admin', PASSWORD_BCRYPT) . '", 1);
    ',
    'down' => '
        DELETE FROM users WHERE username = "admin";
        DELETE FROM roles WHERE name IN ("admin", "user");
    '
];
