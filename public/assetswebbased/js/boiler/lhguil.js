$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateLHGuiloutineValue() {
        $.ajax({
            url: BASE_URL + "/lhguil",// File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#lhguil').text(response.lhguil); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateLHGuiloutineValue, 5000); // Interval setiap 1 detik (1000 ms)
});