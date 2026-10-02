<?php
header('Content-Type: application/json; charset=utf-8');

require_once 'koneksi.php';

try {
    $stmt = $pdo->query("SELECT id, nama_alat, jumlah, kondisi FROM alat_lab");
    $data = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'code' => 200,
        'message' => 'Data alat lab berhasil diambil',
        'data' => $data
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'code' => 500,
        'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}