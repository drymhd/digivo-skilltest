const redis = require('redis');
const mysql = require('mysql2');
const express = require('express');
const app = express();
const port = 3000;

// Create Redis client
const client = redis.createClient({
  host: '127.0.0.1', // Redis server host
  port: 6379, // Redis server port (default is 6379)
});


// Create MySQL connection
const db = mysql.createConnection({
  host: '127.0.0.1',
  user: 'root',
  password: '',
  database: 'digivo_jawaban10',
});



client.on('connect', () => {
  console.log('Connected to Redis');
});
// Utility function to get feed from MySQL
async function getFeedFromMySQL(userId, offset = 0, limit = 20) {
  return new Promise((resolve, reject) => {
    const query = `
      SELECT p.id AS post_id, p.content, p.created_at, u.username
      FROM posts p
      JOIN follows f ON p.user_id = f.following_id
      JOIN users u ON p.user_id = u.id
      WHERE f.follower_id = ?
      ORDER BY p.created_at DESC
      LIMIT ? OFFSET ?;
    `;
    
    db.execute(query, [userId, limit.toString(), offset.toString()], (err, results) => {
      if (err) {
        reject(err);  // Reject the promise if there's an error
      } else {
        resolve(results);  // Resolve with the query results
      }
    });
  });
}

// Route to get user feed
app.get('/feed/:userId', async (req, res) => {
  const userId = req.params.userId;

try{
  const cachedFeed = await client.get('user_feed_' + userId);

    if (cachedFeed) {
      console.log('Feed found in Redis');
      return res.json(JSON.parse(cachedFeed));
    } else {
      console.log('Feed not found in Redis, querying MySQL...');
      // Query MySQL for the feed
      const feed = await getFeedFromMySQL(userId);
      if (feed && feed.length > 0) {
        // Cache the result in Redis with a TTL of 1 hour (3600 seconds)
        await client.set('user_feed_' + userId, JSON.stringify(feed), 'EX', 3600);
        return res.json(feed);
      } else {
        return res.status(404).json({ error: 'Feed not found' });
      }
    }
  } catch (error) {
    console.error('Error fetching feed:', error);
    return res.status(500).json({ error: 'Error fetching feed' });
  }
});

// Handle Redis connection errors
client.on('error', (err) => {
  console.log('Redis error:', err);
});

// Start the Express server
app.listen(port, async () => {
  await client.connect();
  db.connect();

  console.log(`Server running on http://localhost:${port}`);
});