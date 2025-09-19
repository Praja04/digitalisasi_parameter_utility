<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Harian Pasteurisasi - {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding: 15px 0;
            border-bottom: 3px solid #2563eb;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .header h1 {
            font-size: 22px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 16px;
            color: #475569;
            font-weight: normal;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 12px;
            background: #f1f5f9;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }

        .info-item {
            display: inline-block;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
        }

        .info-value {
            color: #6b7280;
            margin-left: 8px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #ffffff !important;
            margin-bottom: 12px;
            padding: 10px 15px;
            background: #3b82f6 !important;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse !important;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .table thead {
            display: table-header-group !important;
        }

        .table tbody {
            display: table-row-group !important;
        }

        .table th {
            background: #3b82f6 !important;
            color: #ffffff !important;
            padding: 12px 8px !important;
            text-align: center !important;
            font-weight: bold !important;
            font-size: 11px !important;
            border: 1px solid #2563eb !important;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            vertical-align: middle !important;
        }

        .table td {
            padding: 0;
            text-align: center;
            border: 1px solid #d1d5db;
            font-size: 14px;
            background: #fff;
        }

        .table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .table tbody tr:hover {
            background: #eff6ff;
        }

        /* Status colors untuk suhu */
        .temp-normal {
            color: #065f46;
            background: #d1fae5;
            padding: 2px 6px;
            border-radius: 12px;
            font-weight: bold;
        }

        .temp-warning {
            color: #92400e;
            background: #fef3c7;
            padding: 2px 6px;
            border-radius: 12px;
            font-weight: bold;
        }

        .temp-danger {
            color: #dc2626;
            background: #fecaca;
            padding: 2px 6px;
            border-radius: 12px;
            font-weight: bold;
        }

        /* Alert styles */
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 4px solid;
        }

        .alert-info {
            background: #eff6ff;
            border-left-color: #3b82f6;
            color: #1e40af;
        }

        .alert-warning {
            background: #fffbeb;
            border-left-color: #f59e0b;
            color: #92400e;
        }

        .alert-danger {
            background: #fef2f2;
            border-left-color: #ef4444;
            color: #dc2626;
        }

        .summary-stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
            display: block;
        }

        .stat-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }

        /* Page break */
        .page-break {
            page-break-before: always;
        }

        /* Column width optimizations */
        .col-time {
            width: 8%;
        }

        .col-temp {
            width: 7%;
        }

        .col-level {
            width: 6%;
        }

        .col-pressure {
            width: 6%;
        }

        .col-flow {
            width: 6%;
        }

        .col-speed {
            width: 6%;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
            background: #f9fafb;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Laporan Harian Pasteurisasi</h1>
        <h2>{{ \Carbon\Carbon::parse($tanggal)->format('l, d F Y') }}</h2>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-item">
            <span class="info-label">Tanggal:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Total Data Hourly:</span>
            <span class="info-value">{{ count($hourlyData) }} record</span>
        </div>
        <div class="info-item">
            <span class="info-label">Periode Abnormal:</span>
            <span class="info-value">{{ count($abnormalData) }} periode</span>
        </div>
        <div class="info-item">
            <span class="info-label">Digenerate:</span>
            <span class="info-value">{{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>

    <!-- Summary Statistics -->
    @if(count($hourlyData) > 0)
    <div class="summary-stats">
        <div class="stat-item">
            <span class="stat-number">{{ number_format(collect($hourlyData)->avg('suhu_heating'), 1) }}°C</span>
            <span class="stat-label">Avg Heating</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format(collect($hourlyData)->avg('suhu_holding'), 1) }}°C</span>
            <span class="stat-label">Avg Holding</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format(collect($hourlyData)->avg('flowrate'), 1) }}</span>
            <span class="stat-label">Avg Flowrate</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format(collect($hourlyData)->avg('level_bt1'), 0) }}</span>
            <span class="stat-label">Avg Level BT1</span>
        </div>
    </div>
    @endif

    <!-- Abnormal Periods Alert -->
    @if(count($abnormalData) > 0)
    <div class="alert alert-danger">
        <strong>⚠️ PERINGATAN:</strong> Ditemukan {{ count($abnormalData) }} periode suhu abnormal (di luar range 105-120°C)
    </div>
    @else
    <div class="alert alert-info">
        <strong>✅ STATUS NORMAL:</strong> Tidak ada periode suhu abnormal pada tanggal ini
    </div>
    @endif

    <!-- Data Hourly Section -->
    <div class="section">
        <div class="section-title">📊 Data Monitoring Per Jam</div>

        @if(count($hourlyData) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th class="col-time">Waktu</th>
                    <th class="col-temp">Suhu Heating (°C)</th>
                    <th class="col-temp">Suhu Holding (°C)</th>
                    <th class="col-temp">Suhu Precooling (°C)</th>
                    <th class="col-temp">Suhu Cooling (°C)</th>
                    <th class="col-flow">Flow Rate</th>
                    <th class="col-level">Level BT1</th>
                    <th class="col-level">Level BT2</th>
                    <th class="col-level">Level VD</th>
                    <th class="col-pressure">Press Mixing</th>
                    <th class="col-pressure">Press BT2</th>
                    <th class="col-speed">Speed Mixing (%)</th>
                    <th class="col-speed">Speed BT1 (%)</th>
                    <th class="col-speed">Speed BT2 (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hourlyData as $row)
                <tr>
                    <td><strong>{{ \Carbon\Carbon::parse($row['waktu'])->format('H:i') }}</strong></td>
                    <td>
                        @php
                        $heating = $row['suhu_heating'];
                        $class = ($heating >= 105 && $heating <= 120) ? 'temp-normal' : 'temp-danger' ; @endphp <span class="{{ $class }}">{{ number_format($heating, 1) }}</span>
                    </td>
                    <td>
                        @php
                        $holding = $row['suhu_holding'];
                        $class = ($holding >= 105 && $holding <= 120) ? 'temp-normal' : 'temp-danger' ; @endphp <span class="{{ $class }}">{{ number_format($holding, 1) }}</span>
                    </td>
                    <td>{{ number_format($row['suhu_precooling'], 1) }}</td>
                    <td>{{ number_format($row['suhu_cooling'], 1) }}</td>
                    <td>{{ number_format($row['flowrate'], 1) }}</td>
                    <td>{{ number_format($row['level_bt1'], 0) }}</td>
                    <td>{{ number_format($row['level_bt2'], 0) }}</td>
                    <td>{{ number_format($row['level_vd'], 0) }}</td>
                    <td>{{ number_format($row['pressure_mixing'], 1) }}</td>
                    <td>{{ number_format($row['pressure_bt2'], 1) }}</td>
                    <td>{{ number_format($row['speed_pompa_mixing'], 0) }}%</td>
                    <td>{{ number_format($row['speed_pump_bt1'], 0) }}%</td>
                    <td>{{ number_format($row['speed_pump_bt2'], 0) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            <strong>Tidak ada data monitoring untuk tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</strong>
        </div>
        @endif
    </div>
    <br><br><br><br><br><br><br><br><br><br> 
    <!-- Abnormal Periods Section -->
    @if(count($abnormalData) > 0)
    <div class="section" style="margin-top: 40px;">
        <div class="section-title">🚨 Periode Suhu Abnormal</div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Mulai</th>
                    <th style="width: 20%;">Selesai</th>
                    <th style="width: 15%;">Durasi</th>
                    <th style="width: 20%;">Status Heating</th>
                    <th style="width: 20%;">Status Holding</th>
                </tr>
            </thead>
            <tbody>
                @foreach($abnormalData as $index => $abnormal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($abnormal['start'])->format('H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($abnormal['end'])->format('H:i:s') }}</td>
                    <td>
                        @php
                        $start = \Carbon\Carbon::parse($abnormal['start']);
                        $end = \Carbon\Carbon::parse($abnormal['end']);
                        $duration = $start->diff($end);
                        $hours = $duration->h;
                        $minutes = $duration->i;
                        $seconds = $duration->s;
                        @endphp
                        {{ sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds) }}
                    </td>
                    <td>
                        @if(isset($abnormal['suhu_heating']) && $abnormal['suhu_heating'] !== '')
                        <span class="temp-danger">{{ $abnormal['suhu_heating'] }}°C</span>
                        @else
                        <span class="temp-normal">Normal</span>
                        @endif
                    </td>
                    <td>
                        @if(isset($abnormal['suhu_holding']) && $abnormal['suhu_holding'] !== '')
                        <span class="temp-danger">{{ $abnormal['suhu_holding'] }}°C</span>
                        @else
                        <span class="temp-normal">Normal</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan ini digenerate otomatis oleh sistem monitoring pasteurisasi</strong></p>
        <p>Waktu generate: {{ now()->format('d F Y, H:i:s') }} WIB</p>
        <p>© {{ date('Y') }} - Sistem Monitoring Pasteurisasi</p>
    </div>
</body>

</html>