use digivo_jawaban10;

set FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE users;

INSERT INTO users (name, username, email, password) VALUES
('User One', 'user1', 'user1@example.com', '$2b$12$exampleHashedPassword1'),
('User Two', 'user2', 'user2@example.com', '$2b$12$exampleHashedPassword2'),
('User Three', 'user3', 'user3@example.com', '$2b$12$exampleHashedPassword3'),
('User Four', 'user4', 'user4@example.com', '$2b$12$exampleHashedPassword4'),
('User Five', 'user5', 'user5@example.com', '$2b$12$exampleHashedPassword5');


TRUNCATE TABLE posts;

INSERT INTO posts (user_id, content) VALUES
(1, 'Post pertama oleh user1'),
(2, 'Post pertama oleh user2'),
(3, 'Post pertama oleh user3'),
(4, 'Post pertama oleh user4'),
(5, 'Post pertama oleh user5'),
(1, 'Post kedua oleh user1'),
(2, 'Post kedua oleh user2'),
(3, 'Post kedua oleh user3'),
(4, 'Post kedua oleh user4'),
(5, 'Post kedua oleh user5');

TRUNCATE TABLE comments;

INSERT INTO comments (post_id, user_id, comment) VALUES
(1, 2, 'Komentar pertama pada post 1 oleh user2'),
(2, 1, 'Komentar pertama pada post 2 oleh user1'),
(3, 4, 'Komentar pertama pada post 3 oleh user4'),
(4, 3, 'Komentar pertama pada post 4 oleh user3'),
(5, 5, 'Komentar pertama pada post 5 oleh user5'),
(6, 2, 'Komentar kedua pada post 6 oleh user2'),
(7, 1, 'Komentar kedua pada post 7 oleh user1'),
(8, 4, 'Komentar kedua pada post 8 oleh user4'),
(9, 3, 'Komentar kedua pada post 9 oleh user3'),
(10, 5, 'Komentar kedua pada post 10 oleh user5');

TRUNCATE TABLE follows;
INSERT INTO follows (follower_id, following_id) VALUES
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 1),
(4, 3),
(5, 4),
(1, 4),
(2, 3),
(3, 5);

TRUNCATE TABLE likes;

INSERT INTO likes (post_id, user_id) VALUES
(1, 2),
(1, 3),
(2, 1),
(2, 4),
(3, 5),
(4, 3),
(5, 4),
(6, 2),
(7, 1),
(8, 5),
(9, 3),
(10, 4);

set FOREIGN_KEY_CHECKS=1;