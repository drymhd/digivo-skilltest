const express = require('express');
const axios = require('axios');
const crypto = require('crypto');
const app = express();
const port = 3000;

// Penyimpanan sementara URL Webhook
let webhookUrls = [];

app.use(express.json());

// Kunci untuk signature (harus disimpan secara aman)
const SECRET_KEY = 'o1e4kLqIKn';

function printWebhookUrls() {
    console.log('Daftar URL Webhook:');
    webhookUrls.forEach((url, index) => {
        console.log(`${index + 1}. ${url}`);
    });
}

// Endpoint untuk mendaftarkan URL webhook pihak ketiga
app.post('/register-webhook', (req, res) => {
  const { webhookUrl } = req.body;
  if (!webhookUrl) {
    return res.status(400).json({ message: 'URL webhook tidak boleh kosong' });
  }
  
  // Menyimpan URL webhook
  webhookUrls.push(webhookUrl);
  printWebhookUrls();
  res.status(200).json({ message: 'Webhook berhasil didaftarkan' });
});

// Fungsi untuk menghasilkan signature dari payload
function generateSignature(payload) {
  const hmac = crypto.createHmac('sha256', SECRET_KEY);
  hmac.update(JSON.stringify(payload));
  return hmac.digest('hex');
}

// Fungsi untuk mengirim notifikasi ke URL webhook
async function sendNotification(webhookUrl, data, retries = 3) {
  try {
    const signature = generateSignature(data);
    const response = await axios.post(webhookUrl, data, {
      headers: {
        'X-Signature': signature,
      }
    });

    // Cek jika pengiriman berhasil
    if (response.status === 200) {
      console.log('Notifikasi berhasil dikirim ke', webhookUrl);
    } else {
      throw new Error(`Failed to send notification, status code: ${response.status}`);
    }
  } catch (error) {
    console.error(`Gagal mengirim notifikasi ke ${webhookUrl}: ${error.message}`);
    
    // Jika gagal, coba lagi hingga 3 kali dengan interval 5 menit
    if (retries > 0) {
      console.log(`Retrying in 5 minutes... (${retries} retries left)`);
      setTimeout(() => sendNotification(webhookUrl, data, retries - 1), 5 * 60 * 1000);
    } else {
      console.log(`Gagal mengirim notifikasi setelah 3 kali percobaan.`);
    }
  }
}

// Endpoint untuk mengubah status pemesanan
app.post('/update-status', async (req, res) => {
  const { orderId, status } = req.body;
  
  if (!orderId || !status) {
    return res.status(400).json({ message: 'orderId dan status harus ada' });
  }

  // Data yang akan dikirim ke webhook
  const notificationData = {
    orderId,
    status,
    timestamp: new Date().toISOString(),
  };

  // Kirim notifikasi ke semua URL webhook terdaftar
  for (let webhookUrl of webhookUrls) {
    await sendNotification(webhookUrl, notificationData);
  }

  res.status(200).json({ message: 'Status pemesanan diperbarui dan notifikasi dikirim' });
});

app.listen(port, () => {
  console.log(`Server berjalan di http://localhost:${port}`);
});
