$(document).ready(function () {
    // Menambahkan baris baru ke tabel
    $('#addRow').click(function () {
        const newRow = `
            <tr>
                <td>No</td>
                <td>Nama Baru</td>
                <td>email@baru.com</td>
                <td>
                    <button class="edit">Edit</button>
                    <button class="delete">Hapus</button>
                </td>
            </tr>`;
        $('#alumniTable tbody').append(newRow);
    });

    // Mengedit baris yang ada
    $('#alumniTable').on('click', '.edit', function () {
        const baris = $(this).closest('tr'); // Ambil baris yang akan diedit
        const nomor = baris.find('td').eq(0).text(); // Ambil nomor baris
        const nama = baris.find('td').eq(1).text(); // Ambil nama
        const email = baris.find('td').eq(2).text(); // Ambil email

        // Tampilkan prompt untuk mengedit data
        const nomorBaru = prompt('Edit Nomor:', nomor);
        const namaBaru = prompt('Edit Nama:', nama);
        const emailBaru = prompt('Edit Email:', email);

        // Perbarui data jika pengguna mengisi data baru
        if (nomorBaru !== null) baris.find('td').eq(0).text(nomorBaru);
        if (namaBaru !== null) baris.find('td').eq(1).text(namaBaru);
        if (emailBaru !== null) baris.find('td').eq(2).text(emailBaru);
    });

    // Menghapus baris dari tabel
    $('#alumniTable').on('click', '.delete', function () {
        if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
            $(this).closest('tr').remove(); // Hapus baris
            perbaruiNomorBaris(); // Perbarui nomor baris setelah dihapus
        }
    });

    // Menghapus baris dari tabel
    function perbaruiNomorBaris() {
        $('#alumniTable tbody tr').each(function (index) {
            $(this).find('td').eq(0).text(index + 1); // Perbarui nomor urut
        });
    }
});
