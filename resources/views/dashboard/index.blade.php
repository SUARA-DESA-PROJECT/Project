@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary rounded-4 mb-4">
                <div class="card-body">
                    <div class="text-white">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Total Laporan Terverifikasi</p>
                            <p class="mb-0"><strong>{{ $verifiedCount }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning rounded-4 mb-4">
                <div class="card-body">
                    <div class="text-white">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Total Laporan belum verifikasi</p>
                            <p class="mb-0"><strong>{{ $unverifiedCount }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success rounded-4 mb-4">
                <div class="card-body">
                    <div class="text-white">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Total Laporan</p>
                            <p class="mb-0"><strong>{{ $totalReports }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 mb-4" style="background-color: #00c3ff;">
                <div class="card-body">
                    <div class="text-white">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Laporan Diproses</p>
                            <p class="mb-0"><strong>{{ $inProcessCount }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Line Chart -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Laporan 7 Hari Terakhir
                </div>
                <div class="card-body">
                    <canvas id="weeklyReportsChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <!-- Replace the status pie chart section with this -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Distribusi Kategori
                </div>
                <div class="card-body">
                    <canvas id="categoryPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Reports by Location -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Laporan Berdasarkan Lokasi
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Lokasi</th>
                                <th>Jumlah Laporan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportsByLocation as $report)
                            <tr>
                                <td>{{ $report->lokasi }}</td>
                                <td>{{ $report->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Weekly Reports Line Chart
    const weeklyData = @json($lastSevenDays);
    new Chart(document.getElementById('weeklyReportsChart'), {
        type: 'line',
        data: {
            labels: weeklyData.map(item => moment(item.date).format('DD/MM/YYYY')),
            datasets: [{
                label: 'Jumlah Laporan',
                data: weeklyData.map(item => item.total),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Category Distribution Chart
    const categoryData = @json($reportsByCategory);
    new Chart(document.getElementById('categoryPieChart'), {
        type: 'pie',
        data: {
            labels: categoryData.map(item => item.kategori_laporan),
            datasets: [{
                data: categoryData.map(item => item.total),
                backgroundColor: ['#dc3545', '#ffc107', '#17a2b8']
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const item = categoryData[context.dataIndex];
                            return `${item.kategori_laporan}: ${item.total} (${item.percentage.toFixed(1)}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection