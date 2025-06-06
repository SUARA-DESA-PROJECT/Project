@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4">Dashboard</h2>
    <p class="text-muted">Ringkasan statistik dan informasi laporan</p>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card rounded-4 mb-4" style="background-color: #4B8F8C;">
                <div class="card-body py-2">
                    <div class="text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 small text-white">Total Laporan<br>Terverifikasi</p>
                            <h3 class="mb-0 text-white">{{ $verifiedCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card rounded-4 mb-4" style="background-color: #4B8F8C;">
                <div class="card-body py-2">
                    <div class="text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 small text-white">Total Laporan<br>belum verifikasi</p>
                            <h3 class="mb-0 text-white">{{ $unverifiedCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card rounded-4 mb-4" style="background-color: #4B8F8C;">
                <div class="card-body py-2">
                    <div class="text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 small">Total<br>Laporan</p>
                            <h3 class="mb-0 text-white">{{ $totalReports }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card rounded-4 mb-4" style="background-color: #4B8F8C;">
                <div class="card-body py-2">
                    <div class="text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 small">Laporan<br>Diproses</p>
                            <h3 class="mb-0 text-white">{{ $inProcessCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Daily Reports Chart -->
        <div class="col-xl-6">
            <div class="card mb-4" style="height: 400px;">
                <div class="card-header py-2">
                    <i class="fa fa-line-chart"></i>
                    <span class="ms-2">Statistik Laporan</span>
                </div>
                <div class="card-body">
                    <canvas id="dailyReportsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Distribution Chart -->
        <div class="col-xl-6">
            <div class="card mb-4" style="height: 400px;">
                <div class="card-header py-2">
                    <i class="fa fa-pie-chart"></i>
                    <span class="ms-2">Distribusi Kategori</span>
                </div>
                <div class="card-body">
                    <canvas id="categoryDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Reports by Location -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                <i class="fas fa-chart-line me-1"></i>
                Laporan berdasarkan Lokasi
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

    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Weekly Reports Chart
        const weeklyData = @json($weeklyReports);
        const weeklyLabels = weeklyData.map(item => 'Minggu ' + item.week);
        const weeklyValues = weeklyData.map(item => item.total);

        new Chart(document.getElementById('weeklyReportsChart'), {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: weeklyValues,
                    borderColor: '#4B8F8C',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tren Laporan Mingguan ' + new Date().getFullYear()
                    }
                },
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

        // Daily Reports Chart
        const ctx = document.getElementById('dailyReportsChart').getContext('2d');
        let myChart;

        fetch('{{ route("report.statistics") }}')
            .then(response => response.json())
            .then(data => {
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Laporan Masuk',
                            data: data.totalReports,
                            backgroundColor: '#75B7B6',
                            borderColor: '#75B7B6',
                            borderWidth: 1
                        },
                        {
                            label: 'Laporan Terverifikasi',
                            data: data.verifiedReports,
                            backgroundColor: '#92DEB7',
                            borderColor: '#92DEB7',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Statistik Laporan 6 Bulan Terakhir',
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            },
                            legend: {
                                position: 'top',
                                labels: {
                                    boxWidth: 12,
                                    padding: 15
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        layout: {
                            padding: {
                                right: 10
                            }
                        }
                    }
                });
            });

        // Category Distribution Chart
        const categoryData = @json($categoryDistribution);
        const categoryLabels = categoryData.map(item => item.kategori_laporan);
        const categoryValues = categoryData.map(item => item.total);

        const pieCtx = document.getElementById('categoryDistributionChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryValues,
                    backgroundColor: [
                        '#FF6B6B',  // Bright Red
                        '#4ECDC4',  // Turquoise
                        '#FFD93D',  // Bright Yellow
                        '#6C5CE7',  // Purple
                        '#A8E6CF',  // Mint Green
                        '#FF8B94',  // Coral Pink
                        '#45B7D1',  // Sky Blue
                        '#98DDCA',  // Seafoam
                        '#FFA07A',  // Light Salmon
                        '#FF69B4'   // Hot Pink
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>

    <style>
    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideInPop {
        0% {
            opacity: 0;
            transform: translateX(-10px) scale(0.98);
        }
        50% {
            transform: translateX(3px) scale(1.01);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    /* Title Styles */
    h1 {
        color: #333333;
        font-weight: 600;
        margin-bottom: 10px;
        animation: fadeInUp 0.4s ease-out;
    }

    h2 {
        color: #333333; /* Dark gray, almost black */
        font-weight: 600;
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 20px;
        animation: fadeInUp 0.4s ease-out 0.1s backwards;
    }

    /* Card Animations */
    .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: scaleIn 0.4s ease-out;
    }

    .card:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    /* Dashboard Cards Sequential Animation */
    .col-xl-3:nth-child(1) .card { animation-delay: 0.1s; }
    .col-xl-3:nth-child(2) .card { animation-delay: 0.2s; }
    .col-xl-3:nth-child(3) .card { animation-delay: 0.3s; }
    .col-xl-3:nth-child(4) .card { animation-delay: 0.4s; }

    /* Chart Cards Animation */
    .col-xl-6 .card {
        animation: slideInPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    }

    .col-xl-6:nth-child(1) .card { animation-delay: 0.5s; }
    .col-xl-6:nth-child(2) .card { animation-delay: 0.6s; }

    /* Table Animation */
    .table {
        animation: fadeInUp 0.4s ease-out 0.7s backwards;
    }

    /* Canvas Animation */
    canvas {
        transition: all 0.3s ease;
    }
    </style>
</div>
@endsection