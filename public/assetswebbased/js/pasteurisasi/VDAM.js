$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateHeatingValue() {
        $.ajax({
            url: '../../data/pasteurisasi/VDAM.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                // Memastikan nilai yang diterima adalah angka
                let VDAMValue = parseInt(response.VDAM, 10); // Pastikan ini sesuai dengan nama field yang dikirim dari PHP
                let mode = checkStatus(VDAMValue); // Memeriksa nilai dan mendapatkan status auto/manual
                $('#VDAM').text(mode); // Update elemen dengan ID 'mode' dengan status auto/manual
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Fungsi untuk memeriksa nilai dan mengembalikan status "manual" atau "auto"
    function checkStatus(value) {
        if (value === 0) {
            return "manual";
        } else if (value === 1) {
            return "auto";
        } else {
            return "Invalid input"; // Jika nilai selain 0 atau 1
        }
    }

    // Memanggil fungsi updateHeatingValue setiap 1 detik
    setInterval(updateHeatingValue, 1000); // Interval setiap 1 detik (1000 ms)
});
