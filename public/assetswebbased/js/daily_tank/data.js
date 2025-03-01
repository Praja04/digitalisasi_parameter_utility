$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/data-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#salt').text(response.salt);
                $('#RO').text(response.RO);
                $('#sauceA').text(response.sauceA);
                $('#sauceB').text(response.sauceB);
                $('#sauceC').text(response.sauceC);
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });

        const now = new Date();

    // Get date components
    const day = now.getDate();
    const month = now.toLocaleString('default', { month: 'long' });
    const year = now.getFullYear();

    // Get time components
    const hour = now.getHours().toString().padStart(2, '0');
    const minute = now.getMinutes().toString().padStart(2, '0');
    const second = now.getSeconds().toString().padStart(2, '0');

    // Update HTML elements
    document.getElementById('day').textContent = day;
    document.getElementById('month').textContent = month;
    document.getElementById('year').textContent = year;
    document.getElementById('hour').textContent = hour;
    document.getElementById('minute').textContent = minute;
    document.getElementById('second').textContent = second;
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
