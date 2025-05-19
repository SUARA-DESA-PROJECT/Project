@extends('layouts.app-warga')

@section('title', 'Home')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/homepage/style.css') }}">
@endsection

@section('content')
    <div class="profile-section reveal-section">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fa fa-user-circle fa-4x"></i>
                        </div>
                        <div class="profile-info">
                            <h3>{{ $warga->username }}</h3>
                            <p class="text-muted">Warga Desa</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm mt-2" style="background-color: #468b94; color: white;">
                                <i class="fa fa-edit"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-banner reveal-section">
        <div class="decoration"></div>
        
        <h2>Selamat Datang, {{ $warga->username }} di Suara Desa</h2>
        
        <p>
            <strong>Suara Desa</strong> adalah platform pelaporan kejadian berbasis website yang dapat digunakan oleh masyarakat untuk melaporkan berbagai kejadian atau permasalahan di lingkungan sekitar. Dengan Suara Desa, masyarakat dapat berpartisipasi aktif dalam pembangunan dan pengembangan desa.
        </p>
        
        <p>
            Mari gunakan layanan ini dengan bijak untuk membangun desa yang lebih baik. Setiap laporan yang masuk akan diverifikasi dan ditindaklanjuti oleh pihak terkait.
        </p>
    </div>
    
    <div class="row mt-4 reveal-section">
        <div class="col-md-8 mb-4">
            <div class="info-box">
                <h4 class="box-title">
                    <i class="fa fa-line-chart"></i> Statistik Laporan
                </h4>
                <div class="chart-container" style="position: relative; height:300px; width:100%">
                    <canvas id="reportStatChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="info-box">
                <h4 class="box-title">
                    <i class="fa fa-bell"></i> Notifikasi Terbaru
                </h4>
                <ul class="notification-list">
                    <!-- @if(isset($debug))
                        <li class="notification-item">
                            <span>Debug: Username: {{ $debug['current_username'] }}, Total Reports: {{ $debug['total_reports_in_db'] }}, User Reports: {{ $debug['reports_for_user'] }}</span>
                        </li>
                    @endif -->
                    
                    @forelse($recentReports as $report)
                        <li class="notification-item">
                            <i class="fa {{ $report->status_verifikasi == 'Terverifikasi' ? 'fa-check' : 'fa-file-text' }}"></i>
                            <span>Laporan "{{ $report->judul_laporan }}" {{ $report->status_verifikasi == 'Terverifikasi' ? 'telah diverifikasi' : 'telah dikirim' }}</span>
                            <div class="notification-time">{{ \Carbon\Carbon::parse($report->created_at)->locale('id')->diffForHumans() }}</div>
                        </li>
                    @empty
                        <li class="notification-item">
                            <span>Belum ada laporan terbaru</span>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/homepage/script.js') }}"></script>
<script>
    const ctx = document.getElementById('reportStatChart').getContext('2d');
    let myChart;

    fetch('{{ route("report.statistics-warga") }}')
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
                            text: 'Statistik Laporan Anda dalam 6 Bulan Terakhir',
                            padding: 20
                        },
                        legend: {
                            position: 'top'
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
</script>
@endsection