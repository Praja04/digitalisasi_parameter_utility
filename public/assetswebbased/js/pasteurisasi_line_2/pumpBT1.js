$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateRHTEMPValue() {
        $.ajax({
            url: '../../data/pasteurisasi_line_2/pumpBT1.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#pumpBT1').text(response.pumpBT1); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateRHTEMPValue, 1000); // Interval setiap 1 detik (1000 ms)
});