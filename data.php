<?php
$file = 'alumni.csv';

// Baca data CSV
function readData()
{
    global $file;
    $data = [];
    if (file_exists($file)) {
        $handle = fopen($file, 'r');
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

// Tulis data ke CSV
function writeData($data)
{
    global $file;
    $handle = fopen($file, 'w');
    foreach ($data as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $data = readData();

    if ($action === 'add') {
        $newEntry = [$_POST['nim'], $_POST['name'], $_POST['major'], $_POST['year']];
        $data[] = $newEntry;
        writeData($data);
        echo json_encode(['success' => true, 'message' => 'Data berhasil ditambahkan!']);
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        unset($data[$id]);
        $data = array_values($data);
        writeData($data);
        echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'read') {
    $data = readData();
    if (empty($data)) {
        echo "<p>Tidak ada data alumni.</p>";
    } else {
        echo "<table class='table table-striped'>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($data as $index => $row) {
            echo "<tr>
                    <td>{$row[0]}</td>
                    <td>{$row[1]}</td>
                    <td>{$row[2]}</td>
                    <td>{$row[3]}</td>
                    <td>
                        <button class='btn btn-danger btn-sm btn-delete' data-id='{$index}'>Hapus</button>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    }
    exit;
}