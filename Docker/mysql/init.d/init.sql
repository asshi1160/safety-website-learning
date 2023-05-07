DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) DEFAULT('名無し'),
    email VARCHAR(255) UNIQUE KEY,
    password VARCHAR(255) NOT NULL,
    session_id INT DEFAULT(NULL)
);

INSERT INTO users VALUES (NULL, 'USER-1', 'user1@example.com', 'user1', 30001);
INSERT INTO users VALUES (NULL, 'USER-2', 'user2@example.com', 'user2', NULL);
