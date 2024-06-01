<?php
// Panggil koneksi ke database
require_once 'conn.php'; // Pastikan file ini mengandung koneksi ke database
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber

$sql = "SELECT waktu,suhu_udara,kelembapan_udara,intensitas_cahaya,kondisi_cuaca,tekanan FROM cuaca ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

$data = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    // Mengonversi ke JSON dan menampilkan output
    echo json_encode($data);
} else {
    echo "Tidak ada data yang ditemukan.";
}
