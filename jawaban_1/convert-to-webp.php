<?php

// HMAC hash yang diberikan sebagai contoh
$hmac_hash = "2d7da2e3589653e2e6e2b32ced1ed629c38cf56fe6e4ef6cb3846e2ef6bf3b182e4a58e984312841277fc5706606008baddd8012f0a3eb119b59f5b61f0d9feb";

// Fungsi untuk menghasilkan hash HMAC
function generateHmacHash($data, $secretKey) {
    return hash_hmac('sha512', json_encode($data), $secretKey);
}

// Fungsi untuk memvalidasi hash HMAC
function validateHmac($providedHash, $data, $secretKey) {
    $calculatedHash = generateHmacHash($data, $secretKey);
    return hash_equals($calculatedHash, $providedHash);
}

// Fungsi untuk konversi gambar menjadi WEBP
function convertToWebp($url, $compressionPercentage) {
    if (empty($url)) {
        return [
            'status' => 'error',
            'message' => 'URL gambar tidak boleh kosong'
        ];
    }

    try {
        $imageContent = file_get_contents($url);
        if ($imageContent === false) {
            throw new Exception("Gagal mengambil gambar dari URL");
        }
    } catch (Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

    try {
        $image = imagecreatefromstring($imageContent);
        if (!$image) {
            throw new Exception("Format gambar tidak didukung");
        }
        $outputPath = 'images/' . uniqid() . '.webp';
        imagewebp($image, $outputPath, $compressionPercentage);
        imagedestroy($image);

        $size = filesize($outputPath) / 1024;

        return [
            'url_webp' => $outputPath,
            'ukuran_webp' => round($size, 2),
            'status' => 'success',
            'message' => 'Image converted successfully'
        ];
    } catch (Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to convert image to WEBP: ' . $e->getMessage()
        ];
    }
}

// Secret key for HMAC
$secretKey = "y1prdEQixW";

// Main handler for the API request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $headers = getallheaders();
    $hmacHash = $headers['Authorization'] ?? '';

    $inputJSON = file_get_contents('php://input');
    $inputData = json_decode($inputJSON, true);

    if (!$inputData) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
        http_response_code(400);
        exit;
    }

    if (!validateHmac($hmacHash, $inputData, $secretKey)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid HMAC']);
        http_response_code(403);
        exit;
    }

    // Pemrosesan berdasarkan tipe request JSON yang berbeda
    if (isset($inputData['url_gambar']) && isset($inputData['persentase_kompresi'])) {
        // Proses konversi gambar jika parameter tersedia
        $urlGambar = $inputData['url_gambar'];
        $persentaseKompresi = (int)$inputData['persentase_kompresi'];
        $response = convertToWebp($urlGambar, $persentaseKompresi);
    } else {
        // Jika tidak ada parameter yang sesuai, balas dengan data JSON mentah
        $response = [
            'status' => 'success',
            'message' => 'Request processed successfully',
            'data_received' => $inputData
        ];
    }

    echo json_encode($response);
    http_response_code($response['status'] === 'success' ? 200 : 500);
}
?>
