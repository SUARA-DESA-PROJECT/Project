@extends('layouts.app')

@section('title', 'Home')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/homepage/style.css') }}">
@endsection

@section('content')
    <div class="welcome-banner reveal-section">
        <div class="decoration"></div>
        
        <h2>Selamat Datang di Suara Desa</h2>
        
        <p>
            <strong>Suara Desa</strong> adalah platform pelaporan kejadian berbasis website yang dapat digunakan oleh masyarakat untuk melaporkan berbagai kejadian atau permasalahan di lingkungan sekitar. Dengan Suara Desa, masyarakat dapat berpartisipasi aktif dalam pembangunan dan pengembangan desa.
        </p>
        
        <p>
            Mari gunakan layanan ini dengan bijak untuk membangun desa yang lebih baik. Setiap laporan yang masuk akan diverifikasi dan ditindaklanjuti oleh pihak terkait.
        </p>
    </div>

    <div class="row reveal-section">
        <div class="col-md-4 mb-4">
            <div class="info-box">
                <div class="info-box-icon">
                    <i class="fa fa-newspaper-o"></i>
                </div>
                <div class="info-box-content">
                    <h4>Total Laporan</h4>
                    <div class="number">24</div>
                    <p>Jumlah laporan yang masuk</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="info-box">
                <div class="info-box-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="info-box-content">
                    <h4>Laporan Terverifikasi</h4>
                    <div class="number">18</div>
                    <p>Laporan yang sudah diverifikasi</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="info-box">
                <div class="info-box-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="info-box-content">
                    <h4>Pengguna</h4>
                    <div class="number">42</div>
                    <p>Jumlah pengguna terdaftar</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4 reveal-section">
        <div class="col-md-8 mb-4">
            <div class="info-box">
                <h4 class="box-title">
                    <i class="fa fa-line-chart"></i> Statistik Laporan
                </h4>
                <div class="chart-container">
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
                    <li class="notification-item">
                        <i class="fa fa-file-text"></i>
                        <span>Laporan baru diterima</span>
                        <div class="notification-time">2 jam yang lalu</div>
                    </li>
                    <li class="notification-item">
                        <i class="fa fa-check"></i>
                        <span>Laporan terverifikasi</span>
                        <div class="notification-time">5 jam yang lalu</div>
                    </li>
                    <li class="notification-item">
                        <i class="fa fa-user-plus"></i>
                        <span>Pengguna baru mendaftar</span>
                        <div class="notification-time">1 hari yang lalu</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/homepage/script.js') }}"></script>
<script src="{{ asset('js/homepage/chart.js') }}"></script>
@endsection