$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#gst1').text(response.GST1);
                $('#gst2').text(response.GST2);
                $('#gst3').text(response.GST3);
                $('#gst4').text(response.GST4);
                $('#gst5').text(response.GST5);
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
