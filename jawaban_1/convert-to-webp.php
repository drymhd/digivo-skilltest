<?php

// hmac_hash = "20407de2595f288faf4d284200661e0a6818e4571ee76738231c41a1f4e51e770afb49e0794dd0208112bc82186c9f6119c37c83eb59db472870eca8b734c437"

// Function to generate HMAC SHA-512 hash
function generateHmacHash($data, $secretKey) {
    return hash_hmac('sha512', json_encode($data), $secretKey);
}

// Validate HMAC
function validateHmac($providedHash, $data, $secretKey) {
    $calculatedHash = generateHmacHash($data, $secretKey);
    return hash_equals($calculatedHash, $providedHash);
}

// Function to convert image to WEBP
function convertToWebp($url, $compressionPercentage) {
    // Check if URL is empty
    if (empty($url)) {
        return [
            'status' => 'error',
            'message' => 'URL gambar tidak boleh kosong'
        ];
    }

    // Get image content from the URL
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

    // Load image and convert to WEBP
    try {
        $image = imagecreatefromstring($imageContent);
        if (!$image) {
            throw new Exception("Format gambar tidak didukung");
        }
        // Set path to save the webp image
        $outputPath = 'images/' . uniqid() . '.webp';
        // Convert to WEBP with the specified compression
        imagewebp($image, $outputPath, $compressionPercentage);
        imagedestroy($image);

        // Get size of the WEBP image
        $size = filesize($outputPath) / 1024; // in KB

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

    // Read JSON body
    $inputJSON = file_get_contents('php://input');
    $inputData = json_decode($inputJSON, true);

    // Validate JSON and HMAC
    if (!$inputData || empty($inputData['url_gambar']) || empty($inputData['persentase_kompresi'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
        http_response_code(400);
        exit;
    }

    if (!validateHmac($hmacHash, $inputData, $secretKey)) {
        
        echo json_encode(['status' => 'error', 'message' => 'Invalid HMAC']);
        http_response_code(403);
        exit;
    }

    // Extract parameters
    $urlGambar = $inputData['url_gambar'];
    $persentaseKompresi = (int)$inputData['persentase_kompresi'];

    // Process the image conversion
    $response = convertToWebp($urlGambar, $persentaseKompresi);

    // Return the JSON response
    echo json_encode($response);
    http_response_code($response['status'] === 'success' ? 200 : 500);
}
?>
