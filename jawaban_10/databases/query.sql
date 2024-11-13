-- EXPLAIN untuk Menganalisis Query÷

EXPLAIN SELECT p.id, p.content, p.created_at, u.username
FROM posts p
JOIN follows f ON p.user_id = f.following_id
JOIN users u ON p.user_id = u.id
WHERE f.follower_id = 1
ORDER BY p.created_at DESC
LIMIT 20 OFFSET 0;


-- Query untuk mengambil data

SELECT p.id, p.content, p.created_at, u.username
FROM posts p
JOIN follows f ON p.user_id = f.following_id
JOIN users u ON p.user_id = u.id
WHERE f.follower_id = 1
ORDER BY p.created_at DESC
LIMIT 20 OFFSET 0;