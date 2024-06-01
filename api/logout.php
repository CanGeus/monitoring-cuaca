<?php
// Mulai session
session_start();

// Hapus semua data session
session_destroy();

// Redirect kembali ke halaman login
header("Location: ../login.php");
exit;
