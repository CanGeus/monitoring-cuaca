<?php
// Panggil koneksi ke database
require_once 'conn.php'; // Pastikan file ini mengandung koneksi ke database
header("Access-Control-Allow-Origin: *"); // Memperbolehkan akses dari berbagai sumber
setlocale(LC_TIME, 'id_ID.utf8');
date_default_timezone_set('Asia/Jakarta');

$tanggal = date('d');
$bulan = date('F');
$tahun = date('Y');
$waktu = date('H:i:s');

// Tangkap data yang dikirim melalui parameter GET 
if (isset($_GET['suhu_udara']) && isset($_GET['kelembapan_udara']) && isset($_GET['intensitas_cahaya']) && isset($_GET['kondisi_cuaca']) && isset($_GET['kecepatan_angin']) && isset($_GET['tekanan']) && isset($_GET['altitude']) && isset($_GET['_csrf_token'])) {
    // Verifikasi token CSRF
    if ($_GET['_csrf_token'] !== 'Z038OpTDXX') {
        die(json_encode(array('message' => 'Invalid CSRF token')));
    }

    $suhu_udara = $_GET['suhu_udara'];
    $kelembapan_udara = $_GET['kelembapan_udara'];
    $intensitas_cahaya = $_GET['intensitas_cahaya'];
    $kondisi_cuaca = $_GET['kondisi_cuaca'];
    $kecepatan_angin = $_GET['kecepatan_angin'];
    $tekanan = $_GET['tekanan'];
    $altitude = $_GET['altitude'];

    // Query untuk memasukkan data ke dalam tabel
    $sql = "INSERT INTO cuaca (tanggal,bulan,tahun,waktu,suhu_udara,kelembapan_udara,intensitas_cahaya,kondisi_cuaca,kecepatan_angin,tekanan,altitude) VALUES ('$tanggal','$bulan','$tahun','$waktu','$suhu_udara','$kelembapan_udara','$intensitas_cahaya','$kondisi_cuaca','$kecepatan_angin','$tekanan','$altitude')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(array('message' => 'Data berhasil dimasukkan'));
    } else {
        echo json_encode(array('message' => 'Gagal memasukkan data: ' . mysqli_error($conn)));
    }
} else {
    echo json_encode(array('message' => 'Parameter tidak lengkap'));
}


//localhost/cuaca/api/data.php?suhu_udara=25.5&kelembapan_udara=65&intensitas_cahaya=800&kondisi_cuaca=cerah&kelembapan_tanah=40&_csrf_token=Z038OpTDXX
