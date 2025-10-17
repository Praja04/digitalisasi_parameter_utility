@extends('layout')


@section('style')
<style>
    .machine-card {
        transition: all 0.3s ease;
        border-left: 4px solid #405189;
    }

    .machine-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .machine-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 8px;
    }

    .shift-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.2);
    }

    .shift-active {
        background: #10b981;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }

    .shift-box {
        background: white;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-left: 3px solid #e5e7eb;
    }

    .shift-box.active {
        border-left-color: #10b981;
        background: #f0fdf4;
    }

    .shift-box.high-downtime {
        border-left-color: #ef4444;
        background: #fef2f2;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .score-excellent {
        background: #10b981;
        color: white;
    }

    .score-good {
        background: #3b82f6;
        color: white;
    }

    .score-fair {
        background: #f59e0b;
        color: white;
    }

    .score-poor {
        background: #ef4444;
        color: white;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .spinner-border-custom {
        width: 3rem;
        height: 3rem;
    }

    .summary-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .machine-code {
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }

    .metric-label {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .downtime-percent {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ef4444;
    }

    .downtime-minutes {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .scoring-section {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .no-data-card {
        opacity: 0.6;
        background: #f9fafb;
    }

    .priority-high {
        border-left-color: #dc2626 !important;
        border-left-width: 6px !important;
    }

    .priority-medium {
        border-left-color: #f59e0b !important;
        border-left-width: 5px !important;
    }

    .priority-low {
        border-left-color: #10b981 !important;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="loading-overlay" style="display: none;">
            <div class="text-center">
                <div class="spinner-border spinner-border-custom text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-light mt-3">Memuat data mesin...</p>
            </div>
        </div>

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        <i class="ri-dashboard-line align-middle me-2"></i>
                        Machine Monitoring Dashboard
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Machine Monitoring</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section" data-aos="fade-up">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal (Downtime)</label>
                    <input type="date" id="selectedDate" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Minggu (Scoring)</label>
                    <input type="week" id="selectedWeek" class="form-control" />
                </div>
                <div class="col-md-2">
                    <button id="btnRefresh" class="btn btn-primary w-100">
                        <i class="ri-refresh-line me-1"></i> Refresh
                    </button>
                </div>
                <div class="col-md-2">
                    <button id="btnAutoRefresh" class="btn btn-outline-primary w-100">
                        <i class="ri-time-line me-1"></i> Auto: OFF
                    </button>
                </div>
                <div class="col-md-2">
                    <select id="sortOption" class="form-select">
                        <option value="worst">Terparah Dulu</option>
                        <option value="best">Terbaik Dulu</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card summary-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted fs-12 mb-1">Total Mesin</p>
                                <h4 class="mb-0" id="totalMachines">20</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-soft-primary rounded fs-3">
                                        <i class="bx bx-cog text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card summary-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted fs-12 mb-1">Rata-rata Scoring</p>
                                <h4 class="mb-0 text-success" id="avgScoring">0%</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-soft-success rounded fs-3">
                                        <i class="bx bx-trophy text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card summary-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted fs-12 mb-1">Avg Downtime</p>
                                <h4 class="mb-0 text-warning" id="avgDowntime">0%</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-soft-warning rounded fs-3">
                                        <i class="bx bx-time text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card summary-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-semibold text-muted fs-12 mb-1">Mesin Bermasalah</p>
                                <h4 class="mb-0 text-danger" id="problematicMachines">0</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-soft-danger rounded fs-3">
                                        <i class="bx bx-error text-danger"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Machines List -->
        <div id="machinesGrid">
            <!-- Machines will be loaded here via AJAX -->
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        const machineList = [
            ...Array.from({
                length: 17
            }, (_, i) => `d${i + 1}`),
            ...Array.from({
                length: 3
            }, (_, i) => `f${i + 1}`)
        ];

        let autoRefreshInterval = null;
        let autoRefreshEnabled = false;
        let currentSortOption = 'worst';

        // Set default dates
        const today = new Date().toISOString().split('T')[0];
        $('#selectedDate').val(today);
        $('#selectedWeek').val(getCurrentWeek());

        function getCurrentWeek() {
            const now = new Date();
            const year = now.getFullYear();
            const oneJan = new Date(year, 0, 1);
            const numberOfDays = Math.floor((now - oneJan) / (24 * 60 * 60 * 1000));
            const weekNumber = Math.ceil((numberOfDays + oneJan.getDay() + 1) / 7);
            return `${year}-W${String(weekNumber).padStart(2, '0')}`;
        }

        function getScoreBadgeClass(score) {
            if (score >= 95) return 'score-excellent';
            if (score >= 85) return 'score-good';
            if (score >= 75) return 'score-fair';
            return 'score-poor';
        }

        function getScoreLabel(score) {
            if (score >= 95) return 'Excellent';
            if (score >= 85) return 'Good';
            if (score >= 75) return 'Fair';
            return 'Poor';
        }

        async function fetchAllMachinesData() {
            $('#loadingOverlay').show();
            const selectedDate = $('#selectedDate').val();
            const selectedWeek = $('#selectedWeek').val();

            try {
                const scoringResponse = await $.ajax({
                    url: `http://10.11.10.130:8090/engineering/public/api/scoring/mesin`,
                    method: 'GET',
                    data: {
                        week: selectedWeek
                    }

                });

                const downtimePromises = machineList.map(machine =>
                    $.ajax({
                        url: `http://10.11.11.200:8080/api/retail/${machine}/durasi/stop`,
                        method: 'GET',
                        data: {
                            date: selectedDate
                        }
                    }).catch(() => null)
                );

                const downtimeResults = await Promise.all(downtimePromises);

                const combinedData = machineList.map((machine, index) => {
                    const machineCode = machine.toUpperCase();
                    const scoring = scoringResponse.machines?.find(m => m.machine_code === machineCode) || null;
                    const downtime = downtimeResults[index];

                    // Calculate priority score (higher = worse)
                    let priorityScore = 0;
                    let totalDowntimePercent = 0;

                    if (downtime && downtime.shifts) {
                        downtime.shifts.forEach(shift => {
                            totalDowntimePercent += shift.downtime || 0;
                        });
                        totalDowntimePercent = totalDowntimePercent / 3; // Average
                    }

                    const scorePercent = scoring ? scoring.weekly_percentage : 100;

                    // Priority: High downtime (weight 60%) + Low score (weight 40%)
                    priorityScore = (totalDowntimePercent * 0.6) + ((100 - scorePercent) * 0.4);

                    return {
                        code: machineCode,
                        scoring: scoring,
                        downtime: downtime,
                        hasData: scoring !== null || downtime !== null,
                        priorityScore: priorityScore,
                        avgDowntimePercent: totalDowntimePercent
                    };
                });

                // Sort data
                const sortedData = sortMachines(combinedData);
                renderMachines(sortedData);
                updateSummary(sortedData, scoringResponse.summary);

            } catch (error) {
                console.error('Error fetching data:', error);
                showError('Gagal memuat data. Pastikan kedua API berjalan.');
            } finally {
                $('#loadingOverlay').hide();
            }
        }

        function sortMachines(data) {
            // Separate machines with data and without data
            const withData = data.filter(m => m.hasData);
            const withoutData = data.filter(m => !m.hasData);

            // Sort machines with data by priority
            withData.sort((a, b) => {
                if (currentSortOption === 'worst') {
                    return b.priorityScore - a.priorityScore; // Descending
                } else {
                    return a.priorityScore - b.priorityScore; // Ascending
                }
            });

            // Combine: machines with data first, then without data
            return [...withData, ...withoutData];
        }

        function renderMachines(machinesData) {
            const grid = $('#machinesGrid');
            grid.empty();

            machinesData.forEach((machine, index) => {
                const card = createMachineCard(machine, index);
                grid.append(card);
            });
        }

        function createMachineCard(machine, index) {
            const scoring = machine.scoring;
            const downtime = machine.downtime;
            const hasData = machine.hasData;

            if (!hasData) {
                return createNoDataCard(machine, index);
            }

            const scorePercentage = scoring ? scoring.weekly_percentage : 0;
            const scoreBadgeClass = getScoreBadgeClass(scorePercentage);
            const scoreLabel = getScoreLabel(scorePercentage);

            // Determine card priority
            let cardPriorityClass = 'priority-low';
            if (machine.priorityScore > 50) cardPriorityClass = 'priority-high';
            else if (machine.priorityScore > 25) cardPriorityClass = 'priority-medium';

            let shiftsHtml = '';
            if (downtime && downtime.shifts) {
                downtime.shifts.forEach(shift => {
                    const isActive = shift.shift === downtime.current_shift;
                    const isHighDowntime = shift.downtime > 50;
                    const shiftClass = isActive ? 'active' : (isHighDowntime ? 'high-downtime' : '');

                    shiftsHtml += `
                    <div class="shift-box ${shiftClass}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="shift-badge ${isActive ? 'shift-active' : ''}">
                                    Shift ${shift.shift} ${isActive ? '(Aktif)' : ''}
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="downtime-percent">${shift.downtime.toFixed(1)}%</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-sm">
                            <span class="downtime-minutes">
                                <i class="ri-time-line me-1"></i>${shift.downtime_total_minutes} / ${shift.actual_shift_minutes} menit
                            </span>
                            <span class="text-muted" style="font-size: 0.75rem;">
                                ${new Date(shift.start_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})} - 
                                ${new Date(shift.end_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}
                            </span>
                        </div>
                    </div>
                `;
                });
            }

            return `
            <div class="row mb-3" data-aos="fade-up" data-aos-delay="${Math.min(index * 50, 500)}">
                <div class="col-12">
                    <div class="card machine-card ${cardPriorityClass}">
                        <div class="card-body">
                            <div class="row">
                                <!-- Machine Info -->
                                <div class="col-md-3">
                                    <div class="machine-header">
                                        <div class="machine-code">${machine.code}</div>
                                        <div style="font-size: 0.9rem; opacity: 0.9;">
                                            ${scoring ? scoring.machine_name : 'Machine ' + machine.code}
                                        </div>
                                        <div class="mt-2">
                                            <small style="opacity: 0.8;">
                                                <i class="ri-alert-line me-1"></i>Priority Score: ${machine.priorityScore.toFixed(1)}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Downtime Details -->
                                <div class="col-md-6">
                                    <div class="metric-label">
                                        <i class="ri-time-line me-1"></i>Downtime per Shift - ${downtime ? downtime.date : selectedDate}
                                    </div>
                                    ${shiftsHtml || '<p class="text-muted">No downtime data</p>'}
                                </div>

                                <!-- Scoring Info -->
                                <div class="col-md-3">
                                    ${scoring ? `
                                        <div class="scoring-section">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span style="font-size: 0.85rem; opacity: 0.9;">Weekly Scoring</span>
                                                <span class="status-badge ${scoreBadgeClass}">${scoreLabel}</span>
                                            </div>
                                            <div style="font-size: 2rem; font-weight: 700;">
                                                ${scorePercentage}%
                                            </div>
                                            <div style="font-size: 0.8rem; opacity: 0.9; margin-top: 0.5rem;">
                                                ${scoring.completed_processes}/${scoring.total_processes} processes completed
                                            </div>
                                            <div class="mt-3 pt-3 border-top border-white border-opacity-25">
                                                <div class="row g-2 text-center" style="font-size: 0.75rem;">
                                                    <div class="col-4">
                                                        <div style="opacity: 0.8;">Deduction</div>
                                                        <div style="font-size: 1.1rem; font-weight: 600;">${scoring.total_deduction_points}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div style="opacity: 0.8;">Critical</div>
                                                        <div style="font-size: 1.1rem; font-weight: 600;">${scoring.critical_not_ok_count}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div style="opacity: 0.8;">Rate</div>
                                                        <div style="font-size: 1.1rem; font-weight: 600;">${scoring.completion_rate}%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ` : `
                                        <div class="alert alert-warning mb-0">
                                            <i class="ri-alert-line me-2"></i>
                                            <strong>No Scoring Data</strong>
                                            <p class="mb-0 mt-2 small">Belum ada data scoring untuk minggu ini</p>
                                        </div>
                                    `}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        function createNoDataCard(machine, index) {
            return `
            <div class="row mb-3" data-aos="fade-up" data-aos-delay="${Math.min(index * 50, 500)}">
                <div class="col-12">
                    <div class="card machine-card no-data-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="machine-header" style="background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);">
                                        <div class="machine-code">${machine.code}</div>
                                        <div style="font-size: 0.9rem; opacity: 0.9;">Machine ${machine.code}</div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="alert alert-secondary mb-0">
                                        <i class="ri-information-line me-2"></i>
                                        <strong>No Data Available</strong>
                                        <p class="mb-0 mt-2">Tidak ada data downtime dan scoring untuk mesin ini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        function updateSummary(machinesData, scoringSummary) {
            $('#totalMachines').text(machinesData.length);

            const withData = machinesData.filter(m => m.hasData);

            // Average scoring
            if (scoringSummary) {
                $('#avgScoring').text(scoringSummary.overall_average + '%');
            }

            // Average downtime (only from machines with data)
            let totalDowntime = 0;
            let count = 0;
            withData.forEach(machine => {
                if (machine.avgDowntimePercent > 0) {
                    totalDowntime += machine.avgDowntimePercent;
                    count++;
                }
            });
            const avgDowntime = count > 0 ? (totalDowntime / count).toFixed(1) : 0;
            $('#avgDowntime').text(avgDowntime + '%');

            // Problematic machines (downtime > 50% OR score < 85)
            const problematic = withData.filter(m => m.avgDowntimePercent > 50 || (m.scoring && m.scoring.weekly_percentage < 85)).length;
            $('#problematicMachines').text(problematic);
        }

        function showError(message) {
            const grid = $('#machinesGrid');
            grid.html(`
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <i class="ri-error-warning-line me-2"></i>${message}
                    </div>
                </div>
            </div>
        `);
        }

        // Event handlers
        $('#btnRefresh').click(fetchAllMachinesData);

        $('#btnAutoRefresh').click(function() {
            autoRefreshEnabled = !autoRefreshEnabled;
            const btn = $(this);

            if (autoRefreshEnabled) {
                btn.removeClass('btn-outline-primary').addClass('btn-success');
                btn.html('<i class="ri-time-line me-1"></i> Auto: ON');
                autoRefreshInterval = setInterval(fetchAllMachinesData, 60000);
            } else {
                btn.removeClass('btn-success').addClass('btn-outline-primary');
                btn.html('<i class="ri-time-line me-1"></i> Auto: OFF');
                if (autoRefreshInterval) clearInterval(autoRefreshInterval);
            }
        });

        $('#sortOption').change(function() {
            currentSortOption = $(this).val();
            fetchAllMachinesData();
        });

        $('#selectedDate, #selectedWeek').change(fetchAllMachinesData);

        // Initial load
        fetchAllMachinesData();

        $(window).on('beforeunload', function() {
            if (autoRefreshInterval) clearInterval(autoRefreshInterval);
        });
    });
</script>
@endsection