<?php
include 'Latihan_09_config.php';

$sql = "SELECT * FROM buku_tamu ORDER BY tanggal DESC";
$result = $conn->query($sql);

echo "<h3>Daftar Buku Tamu</h3>";
echo "<table class='table table-bordered'><tr><th>Nama</th><th>Email</th><th>Pesan</th><th>Tanggal</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['nama']}</td><td>{$row['email']}</td><td>{$row['pesan']}</td><td>{$row['tanggal']}</td></tr>";
}
echo "</table>";

$conn->close();
