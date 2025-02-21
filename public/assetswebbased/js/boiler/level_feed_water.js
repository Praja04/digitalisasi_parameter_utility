$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateFeedWaterValue() {
        $.ajax({
            url: BASE_URL + "/level_feed_water", // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#value').text(response.level_feed_water); // Update nilai feed water
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateFeedWaterValue, 5000); // Interval setiap 1 detik (1000 ms)
});