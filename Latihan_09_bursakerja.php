<?php
include 'Latihan_09_config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add new job posting
        $posisi = $_POST['posisi'];
        $perusahaan = $_POST['perusahaan'];
        $lokasi = $_POST['lokasi'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal_posting = date('Y-m-d');

        $sql = "INSERT INTO lowongan (posisi, perusahaan, lokasi, deskripsi, tanggal_posting) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $posisi, $perusahaan, $lokasi, $deskripsi, $tanggal_posting);
        $stmt->execute();
    } elseif (isset($_POST['edit'])) {
        // Edit job posting
        $id = $_POST['id'];
        $posisi = $_POST['posisi'];
        $perusahaan = $_POST['perusahaan'];
        $lokasi = $_POST['lokasi'];
        $deskripsi = $_POST['deskripsi'];

        $sql = "UPDATE lowongan SET posisi=?, perusahaan=?, lokasi=?, deskripsi=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $posisi, $perusahaan, $lokasi, $deskripsi, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        // Delete job posting
        $id = $_POST['id'];

        $sql = "DELETE FROM lowongan WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

// Query to fetch job postings
$sql = "SELECT * FROM lowongan ORDER BY tanggal_posting DESC";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursa Kerja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h3>Bursa Kerja</h3>

    <!-- Form to Add/Edit Job -->
    <form method="post" class="mb-4">
        <input type="hidden" name="id" id="job-id">
        <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" name="posisi" id="posisi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="perusahaan" class="form-label">Perusahaan</label>
            <input type="text" name="perusahaan" id="perusahaan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="add" class="btn btn-primary">Tambah</button>
        <button type="submit" name="edit" class="btn btn-warning">Edit</button>
    </form>

    <!-- Job Postings Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Posisi</th>
            <th>Perusahaan</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Tanggal Posting</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['posisi']) ?></td>
                    <td><?= htmlspecialchars($row['perusahaan']) ?></td>
                    <td><?= htmlspecialchars($row['lokasi']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><?= (new DateTime($row['tanggal_posting']))->format('d M Y') ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editJob(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Tidak ada lowongan kerja yang tersedia.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function editJob(job) {
        document.getElementById('job-id').value = job.id;
        document.getElementById('posisi').value = job.posisi;
        document.getElementById('perusahaan').value = job.perusahaan;
        document.getElementById('lokasi').value = job.lokasi;
        document.getElementById('deskripsi').value = job.deskripsi;
    }
</script>
</body>
</html>

<?php
$conn->close();
?>