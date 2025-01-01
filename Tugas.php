<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">Tracer Alumni</h1>

        <!-- Form Tambah Alumni -->
        <div class="card mb-4">
            <div class="card-body">
                <h4>Tambah Data Alumni</h4>
                <form id="form-add">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM:</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="major" class="form-label">Prodi:</label>
                        <input type="text" class="form-control" id="major" name="major" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Angkatan:</label>
                        <input type="number" class="form-control" id="year" name="year" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>

        <!-- Daftar Alumni -->
        <div class="card">
            <div class="card-body">
                <h4>Daftar Alumni</h4>
                <input type="text" id="search" class="form-control mb-3" placeholder="Cari alumni...">
                <div id="table-container"></div>
            </div>
        </div>
    </div>

    <script>
    function loadAlumni() {
        $.get('data.php', {
            action: 'read'
        }, function(data) {
            $('#table-container').html(data);
        });
    }

    $(document).ready(function() {
        loadAlumni();

        // Form tambah alumni
        $('#form-add').submit(function(e) {
            e.preventDefault();
            $.post('data.php', $(this).serialize() + '&action=add', function(response) {
                alert(response.message);
                if (response.success) {
                    $('#form-add')[0].reset();
                    loadAlumni();
                }
            }, 'json');
        });

        // Pencarian alumni
        $('#search').keyup(function() {
            let query = $(this).val().toLowerCase();
            $('#table-container table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });

        // Delegasi klik hapus
        $(document).on('click', '.btn-delete', function() {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                let id = $(this).data('id');
                $.post('data.php', {
                    action: 'delete',
                    id: id
                }, function(response) {
                    alert(response.message);
                    if (response.success) {
                        loadAlumni();
                    }
                }, 'json');
            }
        });
    });
    </script>
</body>

</html>