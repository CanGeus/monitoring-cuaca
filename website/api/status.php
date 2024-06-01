<?php
include("conn.php");

$query = "SELECT suhu_udara,kelembapan_udara,kecepatan_angin,tekanan,altitude,intensitas_cahaya FROM cuaca ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);

$data = array();

if ($result->num_rows > 0) {
    // Mengambil setiap baris hasil query
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

// Mengubah data menjadi format JSON
echo json_encode($data);

// Menutup koneksi
$conn->close();
