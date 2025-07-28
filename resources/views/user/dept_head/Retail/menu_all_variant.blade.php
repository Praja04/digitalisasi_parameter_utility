@extends('layout')
@section('content')

<!-- Include AOS (Animate On Scroll) -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<style>
    h4.card-title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
    }

    .card:hover {
        transform: scale(1.01);
        transition: 0.3s ease-in-out;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        background: linear-gradient(90deg, #0d6efd, #6fbfff);
        box-shadow: inset 0 -1px 0 #fff;
    }

    .variant-link {
        font-weight: 500;
        transition: color 0.3s;
    }

    .variant-link:hover {
        color: #0a58ca;
        text-decoration: underline;
    }
</style>

<div class="page-content" data-aos="fade-in" data-aos-delay="100">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between" data-aos="fade-down">
                    <h4 class="mb-sm-0">Bas Retail Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0" style="font-weight: 500;">
                            <li class="breadcrumb-item"><i class="ri-settings-2-line"></i> Mesin</li>
                            <li class="breadcrumb-item active"><i class="ri-store-line"></i> Retail</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow-lg border-0" data-aos="zoom-in-up">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">Visualisasi Data Output Produksi</h4>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="date" id="filterTanggal" class="form-control form-control-sm" />
                            <button class="btn btn-soft-secondary btn-sm" data-range="ALL">ALL</button>
                            <button class="btn btn-soft-secondary btn-sm" data-range="1M">1M</button>
                            <button class="btn btn-soft-secondary btn-sm" data-range="6M">6M</button>
                            <button class="btn btn-soft-primary btn-sm" data-range="1Y">1Y</button>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-2">
                        <div class="w-100">
                            <div id="customer_impression_charts" class="apex-charts" dir="ltr" data-aos="fade-up"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow" data-aos="fade-up" data-aos-delay="150">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">Data Box Counter Produksi Retail</h4>
                        <button type="button" id="downloadExcel" class="btn btn-soft-info btn-sm">
                            <i class="ri-file-list-3-line align-middle"></i> Generate Report
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table id="tableReport" class="table table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th>Variant</th>
                                        <th>Target</th>
                                        <th>Shift 1</th>
                                        <th>Shift 2</th>
                                        <th>Shift 3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Tabel dinamis via JS --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Set default tanggal ke hari ini saat load
        const defaultTanggal = new Date().toISOString().slice(0, 10);
        loadRetailData({
            tanggal: defaultTanggal
        });
        $('#filterTanggal').val(defaultTanggal);
        $('#filterTanggal').on('change', function() {
            const selectedDate = $(this).val();

            // Reset style range filter
            $('[data-range]').removeClass('btn-soft-primary').addClass('btn-soft-secondary');

            // Jalankan AJAX pakai tanggal yang dipilih
            loadRetailData({
                tanggal: selectedDate
            });
        });

        // Event tombol filter range (1M, 6M, 1Y, ALL)
        $('[data-range]').on('click', function() {
            const range = $(this).data('range');

            $('[data-range]').removeClass('btn-soft-primary').addClass('btn-soft-secondary');
            $(this).removeClass('btn-soft-secondary').addClass('btn-soft-primary');

            loadRetailData({
                range: range
            });
        });

        function loadRetailData(params = {}) {
            $.ajax({
                url: "{{ url('retail/data/all/retail') }}",
                method: 'GET',
                data: params,
                dataType: 'json',
                success: function(data) {
                    updateTable(data);
                    updateChart(data);
                },
                error: function(err) {
                    console.error("Gagal ambil data:", err.responseText);
                }
            });
        }

        function updateTable(data) {
            const tbody = $('table tbody');
            tbody.empty();

            data.forEach(item => {
                const {
                    variant,
                    target = 0,
                    shift_1,
                    shift_2,
                    shift_3
                } = item;

                const shifts = [shift_1, shift_2, shift_3];

                const row = $('<tr></tr>');

                // Kolom variant (dengan event klik)
                const variantCell = $(`<td style="cursor: pointer; "><span class="variant-link">Variant ${variant.toUpperCase()}</span></td>`);
                variantCell.find('.variant-link').on('click', function(e) {
                    e.stopPropagation(); // supaya klik tidak bubble ke row kalau ada handler lain
                    window.location.href = "{{ url('prd/dept_head/menu_retail') }}?variant=" + encodeURIComponent(variant);
                });

                row.append(variantCell);
                row.append(`<td>${target}</td>`);

                shifts.forEach(shift => {
                    const percentage = target > 0 ? Math.round((shift / target) * 100) : 0;
                    row.append(`
                <td>
                    ${shift}
                    <div class="progress">
                        <div class="progress-bar" style="width:${percentage}%">
                            ${percentage}%
                        </div>
                    </div>
                </td>
            `);
                });

                tbody.append(row);
            });
        }

        function updateChart(data) {
            const categories = data.map(item => `Varian ${item.variant.toUpperCase()}`);
            const series = [{
                    name: 'Shift 1',
                    data: data.map(item => item.shift_1)
                },
                {
                    name: 'Shift 2',
                    data: data.map(item => item.shift_2)
                },
                {
                    name: 'Shift 3',
                    data: data.map(item => item.shift_3)
                }
            ];

            const options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: false,
                    toolbar: {
                        show: false
                    }
                },
                series: series,
                xaxis: {
                    categories: categories
                },
                colors: ['#28a745', '#007bff', '#dc3545'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%'
                    }
                }
            };

            const chartEl = document.querySelector("#customer_impression_charts");
            chartEl.innerHTML = ""; // Clear previous chart
            new ApexCharts(chartEl, options).render();
        }

        $("#downloadExcel").on("click", function() {
            var table = document.getElementById("tableReport");
            var workbook = XLSX.utils.table_to_book(table, {
                sheet: "Laporan Produksi"
            });
            XLSX.writeFile(workbook, "Laporan_Produksi_Retail.xlsx");
        });
    });
</script>
@endsection