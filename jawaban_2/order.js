const connection = require('./database');


function truncateTable(callback) {
    connection.query('TRUNCATE TABLE orders', (err, results) => {
        if (err) {
            callback(err, null);
        } else {
            callback(null, 'Tabel orders berhasil dihapus');
        }
    });
}
// Fungsi untuk generate kode unik
function generateSku(callback) {
    const length = Math.floor(Math.random() * (10 - 1 + 1)) + 1; // Random panjang kode antara 1 sampai 10
    let code = '';
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Karakter untuk kode unik

    // Membuat kode unik
    for (let i = 0; i < length; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    // Memeriksa apakah kode unik sudah ada di database
    connection.query('SELECT * FROM orders WHERE sku = ?', [code], (err, results) => {
        if (err) {
            callback(err, null);
        } else if (results.length > 0) {
            // Jika kode unik sudah ada, coba generate ulang
            generateSku(callback);
        } else {
            // Kode unik belum ada, bisa digunakan
            callback(null, code);
        }
    });
}

// Fungsi untuk memasukkan transaksi ke dalam database
function insertOrder(product_id, product_name, status, callback) {
    generateSku((err, sku) => {
        if (err) {
            return callback(err);
        }

        // Menyimpan transaksi baru
        const price = 299000; // Harga produk tetap
        const query = 'INSERT INTO orders (product_id, product_name, price, sku, status) VALUES (?, ?, ?, ?, ?)';

        connection.query(query, [product_id, product_name, price, sku, status], (err, results) => {
            if (err) {
                return callback(err);
            }
            callback(null, results);
        });
    });
}

// Fungsi untuk memasukkan beberapa transaksi
function insertMultipleOrders(count, callback) {
    let ordersInserted = 0;

    truncateTable((err, message) => {
        if (err) {
            console.error('Terjadi kesalahan: ', err);
        } else {
            console.log(message);
        }
    });

    for (let i = 1; i <= count; i++) {
        // Asumsi product_id dan product_name adalah data statis untuk tes
        const product_id = i;
        const product_name = 'Produk ' + i;
        const status = 'pending';

        insertOrder(product_id, product_name, status, (err, result) => {
            if (err) {
                console.error('Gagal memasukkan transaksi: ' + err.message);
            } else {
                ordersInserted++;
                console.log(`Transaksi ${ordersInserted} berhasil dimasukkan`);
            }

            // Jika sudah memasukkan semua transaksi
            if (ordersInserted === count) {
                callback(null, 'Semua transaksi berhasil dimasukkan');
            }
        });
    }

   

}

module.exports = { insertMultipleOrders };
