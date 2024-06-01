<?php
// Panggil koneksi ke database
require_once 'conn.php'; // Pastikan file ini mengandung koneksi ke database

if (!isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk mengambil data pengguna dari database
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Redirect ke halaman selamat datang
            header("Location: ../register.php");
            exit;
        } else {
            // Gunakan prepared statement untuk menghindari SQL injection
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bind parameter ke prepared statement
                $stmt->bind_param("ss", $username, $password);

                // Lakukan eksekusi prepared statement
                $stmt->execute();

                // Periksa apakah data berhasil dimasukkan
                if ($stmt->affected_rows > 0) {
                    // Redirect ke halaman login setelah data berhasil dimasukkan
                    header("Location: ../login.php");
                    exit;
                } else {
                    // Jika gagal memasukkan data (misalnya, ada error SQL)
                    echo "Gagal memasukkan data pengguna.";
                }

                // Tutup statement
                $stmt->close();
            } else {
                // Jika ada error saat mempersiapkan statement
                echo "Error: " . $conn->error;
            }
        }
    }
} else {
    // Redirect ke halaman selamat datang
    header("Location: ../index.php");
    exit;
}

// Tutup koneksi ke database
$conn->close();
