const mysql = require('mysql2');

// Membuat koneksi ke database MySQL
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root', // Ganti dengan username MySQL Anda
    password: '', // Ganti dengan password MySQL Anda
    database: 'digivo_jawaban2' // Ganti dengan nama database Anda
});

connection.connect((err) => {
    if (err) {
        console.error('Koneksi gagal: ' + err.stack);
        return;
    }
    console.log('Terhubung ke database dengan ID ' + connection.threadId);
});

module.exports = connection;
