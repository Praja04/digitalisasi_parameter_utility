@extends('layout')
@section('dynamic_url', 'olahsari/realtime')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Olah Sari Monitoring</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item active">Analytics Data Trend</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <label for="filter-mode">Filter Data:</label>
                <select id="filter-mode" class="form-control">
                    <option value="normal">Terbaru</option>
                    <option value="harian">Per Hari</option>
                    <option value="mingguan">Per Minggu</option>
                </select>
            </div>
            <div class="col-md-4" id="filter-tanggal-container" style="display: none;">
                <label for="filter-tanggal">Pilih Tanggal:</label>
                <input type="date" id="filter-tanggal" class="form-control">
            </div>
            <div class="col-md-4" id="filter-mingguan-container" style="display: none;">
                <label>Pilih Rentang Tanggal:</label>
                <div class="d-flex">
                    <input type="date" id="tanggal-mulai" class="form-control">
                    <span class="mx-2">sampai</span>
                    <input type="date" id="tanggal-selesai" class="form-control">
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <button class="btn btn-primary" id="apply-filter">search</button>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Temprature Mixer</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-temp-mixer"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">LC Mixer</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-lc-mixer"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- 🔹 Include ApexCharts & jQuery -->
<script src="{{ asset('material/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- <script>
    $(document).ready(function() {
        function getolahsaridata(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                success: function(response) {
                    resetChart();
                    if (response.success && response.data.length > 0) {
                        updateChart(response.data.reverse());
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Tidak Ditemukan',
                            text: 'Tidak ada data untuk tanggal yang dipilih.',
                        });
                        updateChart([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching glucose data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.waktu);

            //  Temperature
            let Temp1 = data.map(item => item.TempMixer1);
            let Temp2 = data.map(item => item.TempMixer2);
            //LC mixer
            let Lc1 = data.map(item => item.LC_Mixer1);
            let Lc2 = data.map(item => item.LC_Mixer2);


            // 🔹 Grafik Level & Tekanan Air
            new ApexCharts($("#chart-temp-mixer")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [{
                        name: "Temprature Mixer 1 (°C)",
                        data: Temp1
                    },
                    {
                        name: "Temperature Mixer 2 (°C)",
                        data: Temp2
                    }
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                },
                markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "Temperature Mixer"
                    }
                }
            }).render();


            new ApexCharts($("#chart-lc-mixer")[0], {
                chart: {
                    type: "area",
                    height: 300
                },
                series: [{
                        name: "LC Mixer 1 (Liter)",
                        data: Lc1
                    },
                    {
                        name: "LC Mixer 2 (Liter)",
                        data: Lc2
                    }
                ],
                xaxis: {
                    categories: waktu,
                    labels: {
                        show: false
                    }, // 🔹 Menghilangkan label di sumbu X

                },
                markers: {
                    size: 5, // Ukuran titik
                    shape: "circle" // Bentuk titik
                },
                yaxis: {
                    title: {
                        text: "LC Mixer"
                    }
                }
            }).render();

        }

        $("#filter-mode").change(function() {
            let mode = $(this).val();
            $("#filter-tanggal-container, #filter-mingguan-container").hide();
            if (mode === "harian") $("#filter-tanggal-container").show();
            if (mode === "mingguan") $("#filter-mingguan-container").show();
        });

        $("#apply-filter").click(function() {
            let mode = $("#filter-mode").val();
            if (mode === "normal") {
                getGlucoseData("{{ url('olahsari/data') }}");
            } else if (mode === "harian") {
                let tanggal = $("#filter-tanggal").val();
                if (!tanggal) {
                    Swal.fire({
                        icon: "warning",
                        title: "Pilih Tanggal",
                        text: "Silakan pilih tanggal terlebih dahulu."
                    });
                    return;
                }
                getGlucoseData("{{ url('olahsari/data-harian') }}", {
                    tanggal: tanggal
                });
            } else if (mode === "mingguan") {
                let tanggalMulai = $("#tanggal-mulai").val();
                let tanggalSelesai = $("#tanggal-selesai").val();
                if (!tanggalMulai || !tanggalSelesai) {
                    Swal.fire({
                        icon: "warning",
                        title: "Pilih Rentang Tanggal",
                        text: "Silakan pilih tanggal mulai dan selesai."
                    });
                    return;
                }
                getGlucoseData("{{ url('olahsari/data-mingguan') }}", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });

        getolahsaridata("{{ url('/olahsari/data') }}");
    });
</script> -->

<script>
    $(document).ready(function() {
    function getOlahSariData(url, params = {}) {
        $.ajax({
            url: url,
            type: "GET",
            data: params,
            dataType: "json",
            success: function(response) {
                resetCharts();
                if (response.success && response.data.length > 0) {
                    let data = response.data.reverse();
                    updateCharts(data);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Tidak Ditemukan',
                        text: 'Tidak ada data untuk tanggal yang dipilih.',
                    });
                    updateCharts([]);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching olahsari data:", error);
            }
        });
    }

    function updateCharts(data) {
        let waktu = data.map(item => item.waktu);

        //  Temperature Mixer Data
        let Temp1 = data.map(item => item.TempMixer1);
        let Temp2 = data.map(item => item.TempMixer2);

        // LC Mixer Data
        let Lc1 = data.map(item => item.LC_Mixer1);
        let Lc2 = data.map(item => item.LC_Mixer2);

        // Grafik Temperature Mixer
        new ApexCharts($("#chart-temp-mixer")[0], {
            chart: {
                type: "area",
                height: 300
            },
            series: [
                { name: "Temperature Mixer 1 (°C)", data: Temp1 },
                { name: "Temperature Mixer 2 (°C)", data: Temp2 }
            ],
            xaxis: {
                categories: waktu,
                labels: { show: false } // Menghilangkan label di sumbu X
            },
            markers: { size: 5, shape: "circle" },
            yaxis: { title: { text: "Temperature Mixer (°C)" } }
        }).render();

        // Grafik LC Mixer
        new ApexCharts($("#chart-lc-mixer")[0], {
            chart: {
                type: "area",
                height: 300
            },
            series: [
                { name: "LC Mixer 1 (Liter)", data: Lc1 },
                { name: "LC Mixer 2 (Liter)", data: Lc2 }
            ],
            xaxis: {
                categories: waktu,
                labels: { show: false } // Menghilangkan label di sumbu X
            },
            markers: { size: 5, shape: "circle" },
            yaxis: { title: { text: "LC Mixer (Liter)" } }
        }).render();
    }

    function resetCharts() {
        $("#chart-temp-mixer").html("");
        $("#chart-lc-mixer").html("");
    }

    $("#filter-mode").change(function() {
        let mode = $(this).val();
        $("#filter-tanggal-container, #filter-mingguan-container").hide();
        if (mode === "harian") $("#filter-tanggal-container").show();
        if (mode === "mingguan") $("#filter-mingguan-container").show();
    });

    $("#apply-filter").click(function() {
        let mode = $("#filter-mode").val();

        if (mode === "normal") {
            getOlahSariData("{{ url('olahsari/data') }}");
        } else if (mode === "harian") {
            let tanggal = $("#filter-tanggal").val();
            if (!tanggal) {
                Swal.fire({
                    icon: "warning",
                    title: "Pilih Tanggal",
                    text: "Silakan pilih tanggal terlebih dahulu."
                });
                return;
            }
            getOlahSariData("{{ url('olahsari/data-harian') }}", { tanggal: tanggal });
        } else if (mode === "mingguan") {
            let tanggalMulai = $("#tanggal-mulai").val();
            let tanggalSelesai = $("#tanggal-selesai").val();
            if (!tanggalMulai || !tanggalSelesai) {
                Swal.fire({
                    icon: "warning",
                    title: "Pilih Rentang Tanggal",
                    text: "Silakan pilih tanggal mulai dan selesai."
                });
                return;
            }
            getOlahSariData("{{ url('olahsari/data-mingguan') }}", {
                tanggal_mulai: tanggalMulai,
                tanggal_selesai: tanggalSelesai
            });
        }
    });

    getOlahSariData("{{ url('/olahsari/data') }}");
});

</script>

@endsection