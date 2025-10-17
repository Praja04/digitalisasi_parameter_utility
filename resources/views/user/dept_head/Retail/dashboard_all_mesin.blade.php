@extends('layout')


@section('style')
<style>
    .card-stats {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-stats:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }

    .status-running {
        background-color: #28a745;
        color: white;
    }

    .status-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .status-danger {
        background-color: #dc3545;
        color: white;
    }

    .machine-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #495057;
    }

    .downtime-percent {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .table-responsive {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .shift-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.25rem;
        margin: 2px;
    }

    .shift-1 {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .shift-2 {
        background-color: #fff3e0;
        color: #f57c00;
    }

    .shift-3 {
        background-color: #f3e5f5;
        color: #7b1fa2;
    }

    /* Highlight untuk shift yang sedang aktif */
    .active-shift-badge {
        position: relative;
        border: 2px solid #28a745;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
        }

        50% {
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.8);
        }
    }

    .active-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #28a745;
        border-radius: 50%;
        margin-right: 5px;
        animation: blink 1.5s infinite;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    .loading-spinner {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        border: 0.25rem solid #f3f3f3;
        border-top: 0.25rem solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .progress {
        height: 1rem;
        margin: 2px 0;
    }

    .progress-bar {
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Group styling untuk setiap mesin */
    .machine-row {
        border-bottom: 2px solid #e9ecef;
    }

    .machine-row:last-child {
        border-bottom: none;
    }

    .shift-details {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .shift-item {
        display: flex;
        align-items: center;
        padding: 5px;
        border-radius: 4px;
        background-color: #f8f9fa;
    }

    .shift-item.active {
        background-color: #fff3cd;
        border-left: 3px solid #ffc107;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">Machine Monitoring Dashboard</h4>
                        <p class="text-muted mb-0">Real-time downtime monitoring untuk semua mesin (3 shift)</p>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="date" id="filterDate" class="form-control" value="{{ date('Y-m-d') }}">
                        <button class="btn btn-primary" onclick="loadDashboard()">
                            <i class="fas fa-sync-alt me-1"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Total Mesin</p>
                                <h3 class="mb-0" id="totalMachines">11</h3>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-industry fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Shift Aktif</p>
                                <h3 class="mb-0" id="currentShift">-</h3>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Avg Downtime (Shift Aktif)</p>
                                <h3 class="mb-0" id="avgDowntime">0%</h3>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Mesin Bermasalah</p>
                                <h3 class="mb-0 text-danger" id="problematicMachines">0</h3>
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="text-center py-5" style="display: none;">
            <div class="loading-spinner mx-auto mb-3"></div>
            <p class="text-muted">Memuat data mesin...</p>
        </div>

        <!-- Main Table -->
        <div class="row" id="mainContent">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Downtime Ranking - Per Mesin (3 Shift)</h5>
                        <small class="text-muted">Diurutkan berdasarkan rata-rata downtime tertinggi |
                            <span class="active-indicator"></span> <strong>Shift sedang berjalan</strong>
                        </small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="60">Rank</th>
                                        <th width="120">Mesin</th>
                                        <th width="200">Shift 1</th>
                                        <th width="200">Shift 2</th>
                                        <th width="200">Shift 3</th>
                                        <th class="text-center" width="120">Avg Downtime</th>
                                        <th class="text-center" width="100">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="machineTableBody">
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <p class="text-muted mb-0">Klik tombol Refresh untuk memuat data</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const machines = ['d1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd14'];
    const API_BASE_URL = 'http://10.11.11.200:8080/api/retail';

    // Load dashboard on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboard();
        // Auto refresh setiap 5 menit
        setInterval(loadDashboard, 300000);
    });

    async function loadDashboard() {
        const date = document.getElementById('filterDate').value;
        const loadingState = document.getElementById('loadingState');
        const mainContent = document.getElementById('mainContent');

        loadingState.style.display = 'block';
        mainContent.style.opacity = '0.5';

        try {
            const allData = await fetchAllMachinesData(date);
            processAndDisplayData(allData);
        } catch (error) {
            console.error('Error loading dashboard:', error);
            alert('Gagal memuat data. Silakan coba lagi.');
        } finally {
            loadingState.style.display = 'none';
            mainContent.style.opacity = '1';
        }
    }

    async function fetchAllMachinesData(date) {
        const promises = machines.map(machine =>
            fetch(`${API_BASE_URL}/${machine}/durasi/stop?date=${date}`)
            .then(res => res.json())
            .then(data => ({
                machine: machine.toUpperCase(),
                ...data
            }))
            .catch(err => {
                console.error(`Error fetching ${machine}:`, err);
                return null;
            })
        );

        const results = await Promise.all(promises);
        return results.filter(data => data !== null);
    }

    function processAndDisplayData(allData) {
        if (allData.length === 0) {
            document.getElementById('machineTableBody').innerHTML =
                '<tr><td colspan="7" class="text-center py-4 text-danger">Tidak ada data tersedia</td></tr>';
            return;
        }

        // Ambil current shift dari data pertama
        const currentShift = allData[0].current_shift || 1;
        document.getElementById('currentShift').textContent = `Shift ${currentShift}`;

        // Proses data per mesin
        const machineData = allData.map(machine => {
            const shifts = {};
            let totalDowntime = 0;
            let shiftCount = 0;

            // Ambil data untuk setiap shift
            for (let i = 1; i <= 3; i++) {
                const shiftData = machine.shifts.find(s => s.shift === i);
                if (shiftData) {
                    shifts[`shift${i}`] = {
                        downtime: shiftData.downtime || 0,
                        downtime_total_minutes: shiftData.downtime_total_minutes || 0,
                        actual_shift_minutes: shiftData.actual_shift_minutes || 0,
                        is_active: i === currentShift
                    };
                    totalDowntime += (shiftData.downtime || 0);
                    shiftCount++;
                }
            }

            return {
                machine: machine.machine,
                shifts: shifts,
                avgDowntime: shiftCount > 0 ? totalDowntime / shiftCount : 0,
                currentShiftDowntime: shifts[`shift${currentShift}`]?.downtime || 0
            };
        });

        // Sort berdasarkan avgDowntime descending
        machineData.sort((a, b) => b.avgDowntime - a.avgDowntime);

        // Update summary statistics
        updateSummaryStats(machineData, currentShift);

        // Render table
        renderTable(machineData);
    }

    function updateSummaryStats(data, currentShift) {
        const currentShiftKey = `shift${currentShift}`;
        const activeDowntimes = data
            .map(m => m.shifts[currentShiftKey]?.downtime || 0)
            .filter(d => d > 0);

        const avgDowntime = activeDowntimes.length > 0 ?
            (activeDowntimes.reduce((sum, d) => sum + d, 0) / activeDowntimes.length).toFixed(2) :
            0;

        const problematic = activeDowntimes.filter(d => d > 10).length;

        document.getElementById('avgDowntime').textContent = `${avgDowntime}%`;
        document.getElementById('problematicMachines').textContent = problematic;
    }

    function renderTable(data) {
        const tbody = document.getElementById('machineTableBody');
        tbody.innerHTML = '';

        data.forEach((machine, index) => {
            const rank = index + 1;
            const avgStatusClass = getStatusClass(machine.avgDowntime);
            const avgStatusText = getStatusText(machine.avgDowntime);

            const row = `
                <tr class="machine-row">
                    <td class="text-center">
                        <span class="badge bg-secondary">${rank}</span>
                    </td>
                    <td>
                        <strong class="machine-name">${machine.machine}</strong>
                    </td>
                    ${renderShiftCell(machine.shifts.shift1, 1)}
                    ${renderShiftCell(machine.shifts.shift2, 2)}
                    ${renderShiftCell(machine.shifts.shift3, 3)}
                    <td class="text-center">
                        <div class="downtime-percent text-${getProgressClass(machine.avgDowntime)}">
                            ${machine.avgDowntime.toFixed(2)}%
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="status-badge status-${avgStatusClass}">${avgStatusText}</span>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    function renderShiftCell(shiftData, shiftNum) {
        if (!shiftData) {
            return '<td class="text-center"><small class="text-muted">-</small></td>';
        }

        const progressClass = getProgressClass(shiftData.downtime);
        const activeClass = shiftData.is_active ? 'active-shift-badge' : '';
        const activeIndicator = shiftData.is_active ? '<span class="active-indicator"></span>' : '';

        return `
            <td>
                <div class="shift-item ${shiftData.is_active ? 'active' : ''}">
                    <div style="width: 100%;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="shift-badge shift-${shiftNum} ${activeClass}">
                                ${activeIndicator}${shiftData.downtime.toFixed(1)}%
                            </span>
                            <small class="text-muted">${shiftData.downtime_total_minutes}m / ${shiftData.actual_shift_minutes}m</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-${progressClass}" 
                                 style="width: ${Math.min(shiftData.downtime, 100)}%">
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        `;
    }

    function getStatusClass(downtime) {
        if (downtime < 5) return 'running';
        if (downtime < 10) return 'warning';
        return 'danger';
    }

    function getStatusText(downtime) {
        if (downtime < 5) return 'Normal';
        if (downtime < 10) return 'Warning';
        return 'Critical';
    }

    function getProgressClass(downtime) {
        if (downtime < 5) return 'success';
        if (downtime < 10) return 'warning';
        return 'danger';
    }
</script>
@endsection