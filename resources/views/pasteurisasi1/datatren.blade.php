@extends('layout')
@section('dynamic_url', 'pasteurisasi1/realtime-pasteurizer')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- 🔹 Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Pasteurisasi 1 Monitoring</h4>
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
                        <h4 class="card-title">Pasteurizer Suhu</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-pasteu-suhu"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pasteurizer Aliran & Kontrol</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-pasteu-aliran"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pasteurizer Tangki & Tekanan</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-pasteu-tangki"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Vacuum Deaerator Pompa & Level Tangki</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-vacum-pompa"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Vacuum Deaerator Tekanan & Kontrol Vacuum</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-vacum-tekanan"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Vacuum Deaerator Arus & Aktivitas Mesin</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-vacum-arus"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Mixing Kecepatan Pompa & Tekanan</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-mixing-kecepatan"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Mixing Arus Listrik & Aktivitas Mesin</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-mixing-arus"></div>
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
        function getData(url, params = {}) {
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
                    console.error("Error fetching pasteurisasi1 data:", error);
                }
            });
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.Waktu);

            // 🔹 Pasteurizer - Suhu
            let suhuPreheating = data.map(item => item.SuhuPreheating);
            let suhuHeating = data.map(item => item.SuhuHeating);
            let suhuHolding = data.map(item => item.SuhuHolding);
            let suhuPrecooling = data.map(item => item.SuhuPrecooling);
            let suhuCooling = data.map(item => item.SuhuCooling);

            new ApexCharts($("#chart-pasteu-suhu")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Preheating (°C)",
                        data: data.map(item => item.SuhuPreheating)
                    },
                    {
                        name: "Heating (°C)",
                        data: data.map(item => item.SuhuHeating)
                    },
                    {
                        name: "Holding (°C)",
                        data: data.map(item => item.SuhuHolding)
                    },
                    {
                        name: "Precooling (°C)",
                        data: data.map(item => item.SuhuPrecooling)
                    },
                    {
                        name: "Cooling (°C)",
                        data: data.map(item => item.SuhuCooling)
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
                        text: "Pasteurizer - Suhu"
                    }
                }
            }).render();

            // 🔹 Pasteurizer - Aliran & Kontrol
            let flowrate = data.map(item => item.Flowrate);
            let pcv1 = data.map(item => item.PCV1);
            let timeDivert = data.map(item => item.TimeDivert);

            new ApexCharts($("#chart-pasteu-aliran")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Flowrate (L/min)",
                        data: data.map(item => item.Flowrate)
                    },
                    {
                        name: "PCV1 (%)",
                        data: data.map(item => item.PCV1)
                    },
                    {
                        name: "Time Divert (s)",
                        data: data.map(item => item.TimeDivert)
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
                        text: "Pasteurizer - Aliran & Kontrol"
                    }
                }
            }).render();

            // 🔹 Pasteurizer - Tangki & Tekanan
            let levelBT2 = data.map(item => item.LevelBT2);
            let speedPumpBT2 = data.map(item => item.SpeedPumpBT2);
            let pressureBT2 = data.map(item => item.PressureBT2);

            new ApexCharts($("#chart-pasteu-tangki")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Level BT2 (cm)",
                        data: data.map(item => item.LevelBT2)
                    },
                    {
                        name: "Speed Pump BT2 (rpm)",
                        data: data.map(item => item.SpeedPumpBT2)
                    },
                    {
                        name: "Pressure BT2 (bar)",
                        data: data.map(item => item.PressureBT2)
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
                        text: "Pasteurizer - Tangki & Tekanan"
                    }
                }
            }).render();

            // 🔹 Vacuum Deaerator - Pompa & Level Tangki
            let speedPumpBT1 = data.map(item => item.SpeedPumpBT1);
            let levelBT1 = data.map(item => item.LevelBT1);
            let speedPumpVD = data.map(item => item.SpeedPumpVD);
            let levelVD = data.map(item => item.LevelVD);

            new ApexCharts($("#chart-vacum-pompa")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Speed Pump BT1 (rpm)",
                        data: data.map(item => item.SpeedPumpBT1)
                    },
                    {
                        name: "Level BT1 (cm)",
                        data: data.map(item => item.LevelBT1)
                    },
                    {
                        name: "Speed Pump VD (rpm)",
                        data: data.map(item => item.SpeedPumpVD)
                    },
                    {
                        name: "Level VD (cm)",
                        data: data.map(item => item.LevelVD)
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
                        text: "Vacuum - Pompa & Level Tangki"
                    }
                }
            }).render();

            // 🔹 Vacuum Deaerator - Tekanan & Kontrol Vacuum
            let pressVDHH = data.map(item => item.PressVDHH);
            let pressVDLL = data.map(item => item.PressVDLL);
            let pressToPasteur = data.map(item => item.PressToPasteur);

            new ApexCharts($("#chart-vacum-tekanan")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Tekanan VDHH (bar)",
                        data: data.map(item => item.PressVDHH)
                    },
                    {
                        name: "Tekanan VDLL (bar)",
                        data: data.map(item => item.PressVDLL)
                    },
                    {
                        name: "Tekanan ke Pasteur (bar)",
                        data: data.map(item => item.PressToPasteur)
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
                        text: "Vacuum - Tekanan & Kontrol"
                    }
                }
            }).render();

            // 🔹 Vacuum Deaerator - Arus & Aktivitas Mesin
            let bt1AM = data.map(item => item.BT1AM);
            let vdam = data.map(item => item.VDAM);

            new ApexCharts($("#chart-vacum-arus")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Arus BT1 (A)",
                        data: data.map(item => item.BT1AM)
                    },
                    {
                        name: "Arus VD (A)",
                        data: data.map(item => item.VDAM)
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
                        text: "Vacuum - Arus & Aktivitas Mesin"
                    }
                }
            }).render();

            // 🔹 Mixing - Kecepatan Pompa & Tekanan
            let speedPompaMixing = data.map(item => item.SpeedPompaMixing);
            let pressureMixing = data.map(item => item.PressureMixing);

            new ApexCharts($("#chart-mixing-kecepatan")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                        name: "Speed Pompa Mixing (rpm)",
                        data: data.map(item => item.SpeedPompaMixing)
                    },
                    {
                        name: "Pressure Mixing (bar)",
                        data: data.map(item => item.PressureMixing)
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
                        text: "Mixing - Tekanan & Kontrol"
                    }
                }
            }).render();

            // 🔹 Mixing - Arus Listrik & Aktivitas Mesin
            let mixingAM = data.map(item => item.MixingAM);

            new ApexCharts($("#chart-mixing-arus")[0], {
                chart: {
                    type: "line",
                    height: 300
                },
                series: [{
                    name: "Arus Mixing (A)",
                    data: data.map(item => item.MixingAM)
                }],
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
                        text: "Mixing - Arus Listrik & Aktivitas Mesin"
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
                getData("{{ url('/pasteurisasi1/data') }}");
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
                getData("{{ url('pasteurisasi1/data-harian') }}", {
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
                getData("{{ url('pasteurisasi1/data-mingguan') }}", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });

        getData("{{ url('/pasteurisasi1/data') }}");
    });
</script> -->
<script>
    $(document).ready(function() {
        function getData(url, params = {}) {
            $.ajax({
                url: url,
                type: "GET",
                data: params,
                dataType: "json",
                beforeSend: function() {
                    // Tampilkan loading atau spinner jika perlu
                },
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
                    console.error("Error fetching pasteurisasi1 data:", error);
                }
            });
        }

        function resetCharts() {
            $(".chart-container").empty(); // Bersihkan grafik sebelum render ulang
        }

        function updateCharts(data) {
            let waktu = data.map(item => item.Waktu);

            let charts = [{
                    id: "#chart-pasteu-suhu",
                    title: "Pasteurizer - Suhu",
                    series: [{
                            name: "Preheating (°C)",
                            data: data.map(item => item.SuhuPreheating)
                        },
                        {
                            name: "Heating (°C)",
                            data: data.map(item => item.SuhuHeating)
                        },
                        {
                            name: "Holding (°C)",
                            data: data.map(item => item.SuhuHolding)
                        },
                        {
                            name: "Precooling (°C)",
                            data: data.map(item => item.SuhuPrecooling)
                        },
                        {
                            name: "Cooling (°C)",
                            data: data.map(item => item.SuhuCooling)
                        }
                    ]
                },
                {
                    id: "#chart-pasteu-aliran",
                    title: "Pasteurizer - Aliran & Kontrol",
                    series: [{
                            name: "Flowrate (L/min)",
                            data: data.map(item => item.Flowrate)
                        },
                        {
                            name: "PCV1 (%)",
                            data: data.map(item => item.PCV1)
                        },
                        {
                            name: "Time Divert (s)",
                            data: data.map(item => item.TimeDivert)
                        }
                    ]
                },
                {
                    id: "#chart-pasteu-tangki",
                    title: "Pasteurizer - Tangki & Tekanan",
                    series: [{
                            name: "Level BT2 (cm)",
                            data: data.map(item => item.LevelBT2)
                        },
                        {
                            name: "Speed Pump BT2 (rpm)",
                            data: data.map(item => item.SpeedPumpBT2)
                        },
                        {
                            name: "Pressure BT2 (bar)",
                            data: data.map(item => item.PressureBT2)
                        }
                    ]
                },
                {
                    id: "#chart-vacum-pompa",
                    title: "Vacuum Deaerator - Pompa & Level Tangki",
                    series: [{
                            name: "Speed Pump BT1 (rpm)",
                            data: data.map(item => item.SpeedPumpBT1)
                        },
                        {
                            name: "Level BT1 (cm)",
                            data: data.map(item => item.LevelBT1)
                        },
                        {
                            name: "Speed Pump VD (rpm)",
                            data: data.map(item => item.SpeedPumpVD)
                        },
                        {
                            name: "Level VD (cm)",
                            data: data.map(item => item.LevelVD)
                        }
                    ]
                },
                {
                    id: "#chart-vacum-tekanan",
                    title: "Vacuum Deaerator - Tekanan & Kontrol Vacuum",
                    series: [{
                            name: "Tekanan VDHH (bar)",
                            data: data.map(item => item.PressVDHH)
                        },
                        {
                            name: "Tekanan VDLL (bar)",
                            data: data.map(item => item.PressVDLL)
                        },
                        {
                            name: "Tekanan ke Pasteur (bar)",
                            data: data.map(item => item.PressToPasteur)
                        }
                    ]
                },
                {
                    id: "#chart-vacum-arus",
                    title: "Vacuum Deaerator - Arus & Aktivitas Mesin",
                    series: [{
                            name: "Arus BT1 (A)",
                            data: data.map(item => item.BT1AM)
                        },
                        {
                            name: "Arus VD (A)",
                            data: data.map(item => item.VDAM)
                        }
                    ]
                },
                {
                    id: "#chart-mixing-kecepatan",
                    title: "Mixing - Kecepatan Pompa & Tekanan",
                    series: [{
                            name: "Speed Pompa Mixing (rpm)",
                            data: data.map(item => item.SpeedPompaMixing)
                        },
                        {
                            name: "Pressure Mixing (bar)",
                            data: data.map(item => item.PressureMixing)
                        }
                    ]
                },
                {
                    id: "#chart-mixing-arus",
                    title: "Mixing - Arus Listrik & Aktivitas Mesin",
                    series: [{
                        name: "Arus Mixing (A)",
                        data: data.map(item => item.MixingAM)
                    }]
                }
            ];

            charts.forEach(chart => {
                let options = {
                    chart: {
                        type: "line",
                        height: 300,
                    },
                    series: chart.series,
                    xaxis: {
                        categories: waktu,
                        labels: {
                            show: false
                        }
                    },
                    markers: {
                        size: 5,
                        shape: "circle"
                    },
                    yaxis: {
                        title: {
                            text: chart.title
                        }
                    }
                };

                new ApexCharts($(chart.id)[0], options).render();
            });
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
                getData("{{ url('/pasteurisasi1/data') }}");
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
                getData("{{ url('pasteurisasi1/data-harian') }}", {
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
                getData("{{ url('pasteurisasi1/data-mingguan') }}", {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                });
            }
        });

        getData("{{ url('/pasteurisasi1/data') }}");
    });
</script>

@endsection