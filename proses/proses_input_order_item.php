<?php
include "connect.php";
session_start();


// Ambil data dari form
$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : ""; 
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : ""; 
$menu = isset($_POST['menu']) ? htmlentities($_POST['menu']) : ""; 
$jumlah = isset($_POST['jumlah']) ? htmlentities($_POST['jumlah']) : ""; 

// Ambil ID user dari session (pelayan)
$id_pelayan = $_SESSION['id']; // pastikan id sudah disimpan saat login

$message = "";

if (isset($_POST['input_order_item_validate'])) {

    // Cek apakah kode_order sudah dipakai
    $cek = mysqli_query($conn, "SELECT * FROM tabel_list_order WHERE menu = '$menu' && kode_order='$kode_order'");
    if (mysqli_num_rows($cek) > 0) {
        $message = '<script>
            alert("Gagal: Kode Order sudah digunakan.");
            window.history.back();
        </script>';
    } else {
        // INSERT ke database
        $query = mysqli_query($conn, "INSERT INTO tabel_list_order (menu,kode_order,jumlah,catatan) 
                                      VALUES ('$menu', '$kode_order', '$jumlah', '$catatan')");

        if ($query) {
            $message = '<script>
                alert("Data berhasil dimasukkan.");
                window.location.href = "../order_item.php?id_order=' . $kode_order . '";
            </script>';
        } else {
            $message = '<script>
                alert("Terjadi kesalahan: ' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
    }
}

echo $message;
?>
