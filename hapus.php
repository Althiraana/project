<?php
include 'koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus data terkait
    $conn->query("DELETE FROM item_photos WHERE item_id = $id");
    $conn->query("DELETE FROM items WHERE id = $id");

    // Jika permintaan dari JavaScript (AJAX), kembalikan JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['status' => 'success']);
        exit;
    }

    // Kalau bukan AJAX, redirect biasa
    header("Location: index.php");
    exit;
} else {
    echo "ID tidak valid.";
}
?>