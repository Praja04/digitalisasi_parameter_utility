$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateLHStokerValue() {
        $.ajax({
            url: BASE_URL + "/batubara_fk", // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
               
                $('#batubara_fk').text(response.batubara_fk); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateLHStokerValue, 5000); // Interval setiap 1 detik (1000 ms)
});