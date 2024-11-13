const connection = require('./database');
const { insertMultipleOrders } = require('./order');

require('./database');

// Memasukkan 50 transaksi ke dalam database
insertMultipleOrders(50, (err, message) => {
    if (err) {
        console.error('Terjadi kesalahan: ', err);
    } else {
        console.log(message);
    }

    connection.end();

});