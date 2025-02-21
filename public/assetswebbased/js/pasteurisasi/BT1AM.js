$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateHeatingValue() {
        $.ajax({
            url: '../../data/pasteurisasi/BT1AM.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                // Memastikan nilai yang diterima adalah angka
                let BT1AMValue = parseInt(response.BT1AM, 10); // Pastikan ini sesuai dengan nama field yang dikirim dari PHP
                let mode = checkStatus(BT1AMValue); // Memeriksa nilai dan mendapatkan status auto/manual
                $('#BT1AM').text(mode); // Update elemen dengan ID 'mode' dengan status auto/manual
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
