$(document).ready(function() {
    function updateSensorValues() {
        $.ajax({
            url: BASE_URL + "/boiler-realtime", // Satu endpoint untuk semua sensor
            dataType: 'json',
            success: function(response) {
                $('#batubara_fk').text(response.Batubara_FK);
                $('#bbsteam').text(response.Steam_FK);
                $('#batubara').text(response.Batubara);
                $('#steam').text(response.Steam);
                $('#co2').text(response.CO2);
                $('#value').text(response.LevelFeedWater);
                $('#idfan').text(response.IDFan);
                $('#steam_fk').text(response.Steam_FK);
                $('#rhstoker').text(response.RHStoker);
                $('#rhguil').text(response.RHGuiloutine);
                $('#rhfd').text(response.RHFDFan);
                $('#temp2').text(response.RHTemp);
                $('#pvsteam1').text(response.PVSteam);
                $('#pvsteam').text(response.PVSteam);
                $('#pump2').text(response.WaterPump2);
                $('#pump1').text(response.WaterPump1);
                $('#o2').text(response.O2);
                $('#lhstoker').text(response.LHStoker);
                $('#lhguil').text(response.LHGuiloutine);
                $('#lhfd').text(response.LHFDFan);
                $('#temp1').text(response.LHTemp);
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi update setiap 5 detik
    setInterval(updateSensorValues, 5000);
});
