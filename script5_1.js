$(document).ready(function () {
    // 1. Dasar Selektor
    $('#header').css('text-align', 'center'); // Mengubah align text pada header
    $('li').css('margin', '5px'); // Memberi margin pada semua <li>

    // 2. Selektor Atribut
    $('img[alt="Alumni Photo 1"]').css('border', '2px solid red'); // Mengubah border pada gambar dengan alt="Alumni Photo 1"

    // 3. Selektor Hirarki
    $('#alumniList li').css('font-size', '18px'); // Mengubah font size pada semua <li> di dalam #alumniList

    // 4. Selektor Filter
    $('li:even').css('color', 'blue'); // Mengubah warna teks pada elemen <li> genap
    $('.featured').addClass('highlight'); // Menambahkan class highlight pada elemen dengan class featured

    // Event Handling untuk Galeri Foto
    $('.gallery img').on('click', function () {
        var src = $(this).attr('src'); // Mendapatkan sumber gambar yang diklik
        $('#modalImage').attr('src', src); // Mengatur gambar modal ke sumber gambar yang diklik
        $('#myModal').fadeIn(); // Menampilkan modal dengan efek fade
    });

    // Menutup modal ketika tombol close diklik
    $('.close').on('click', function () {
        $('#myModal').fadeOut(); // Menyembunyikan modal dengan efek fade
    });

    // Menutup modal ketika klik di luar modal
    $(window).on('click', function (event) {
        if ($(event.target).is('#myModal')) {
            $('#myModal').fadeOut(); // Menyembunyikan modal dengan efek fade
        }
    });
});