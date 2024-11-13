<?php
// Load dependencies
require 'config/database.php';
require 'functions/generate_otp.php';

// Mendapatkan method dan action dari request
$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($requestMethod === 'POST') {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        echo json_encode(['status' => 'error', 'message' => 'Authorization header missing']);
        exit;
    }
    $user_id = $headers['Authorization'];

    if ($action === 'generate') {
        // Generate OTP dan waktu kedaluwarsa
        $otp_code = generateOTP();
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Simpan OTP ke database
        $stmt = $conn->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$user_id, $otp_code, $expires_at]);

        echo json_encode(['status' => 'success', 'otp_code' => $otp_code, 'expires_at' => $expires_at]);
    } elseif ($action === 'validate') {
        $otp_code = $_POST['otp_code'] ?? '';

        // Validasi OTP
        $stmt = $conn->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND otp_code = ? AND expires_at > NOW() LIMIT 1");
        $stmt->execute([$user_id, $otp_code]);
        $otp_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($otp_data) {
            echo json_encode(['status' => 'success', 'message' => 'OTP is valid']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or expired OTP']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>