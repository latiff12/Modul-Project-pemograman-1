$(document).ready(function () {
    // Fade-in efek untuk semua gambar di galeri
    $(".gallery img").hide().fadeIn(1000);

    // Klik gambar untuk menampilkan modal
    $(".gallery img").on("click", function () {
        const imgSrc = $(this).attr("src");
        $("#modalImage").attr("src", imgSrc);
        $("#imageModal").fadeIn();
    });

    // Klik tombol "Close" untuk menutup modal
    $(".close").on("click", function () {
        $("#imageModal").fadeOut();
    });

    // Klik di luar modal-content untuk menutup modal
    $("#imageModal").on("click", function (e) {
        if ($(e.target).is("#imageModal")) {
            $("#imageModal").fadeOut();
        }
    });
});
