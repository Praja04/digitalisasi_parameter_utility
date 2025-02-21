$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateRHFDValue() {
        $.ajax({
            url: BASE_URL + "/rhfd_fan", // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#rhfd').text(response.rhfd); // Update nilai feed water
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateRHFDValue, 5000); // Interval setiap 1 detik (1000 ms)
});