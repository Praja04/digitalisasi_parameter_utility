$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updatePVSteamValue() {
        $.ajax({
            url: BASE_URL + "/pvsteam1", // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#pvsteam1').text(response.pvsteam1); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updatePVSteamValue, 5000); // Interval setiap 1 detik (1000 ms)
});