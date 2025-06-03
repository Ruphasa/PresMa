@extends('layouts.template')

@section('content')
    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Admin Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Admin Dashboard</h1>
                        <p class="lead" id="timeNow">Selamat datang, kelola sistem Anda dengan mudah di sini.
                            {{ $timeNow }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistik Card -->
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 bg-primary text-white text-center p-3">
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="display-5" id="totalUsers">{{ $totalUsers ?? 0 }}</h2>
                        <p class="card-text">Jumlah pengguna terdaftar</p>
                        <a href="{{ url('/Admin/user') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 bg-success text-white text-center p-3">
                        <h5 class="card-title">Total Competitions</h5>
                        <h2 class="display-5" id="totalCompetitions">{{ $totalCompetitions ?? 0 }}</h2>
                        <p class="card-text">Jumlah lomba yang divalidasi</p>
                        <a href="{{ url('/Admin/competition') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 bg-info text-white text-center p-3">
                        <h5 class="card-title">Total Achievements</h5>
                        <h2 class="display-5" id="totalAchievements">{{ $totalAchievements ?? 0 }}</h2>
                        <p class="card-text">Jumlah prestasi tercatat</p>
                        <a href="{{ url('Admin/achievement') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 bg-warning text-white text-center p-3">
                        <h5 class="card-title">Pending Competitions</h5>
                        <h2 class="display-5" id="pendingCompetitions">{{ $pendingCompetitions ?? 0 }}</h2>
                        <p class="card-text">Jumlah lomba menunggu validasi</p>
                        <a href="{{ url('/Admin/competition') }}" class="btn btn-light btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <!-- Grafik atau Informasi Tambahan -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4>Statistik Lomba per Bulan</h4>
                        </div>
                        <div class="card-body">
                            <div id="competitionChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Admin Dashboard End -->
@endsection

@push('css')
    <style>
        .card {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            padding: 1.5rem;
        }

        .display-5 {
            font-size: 2rem;
            font-weight: 600;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Tunggu DOM selesai dimuat
        $(document).ready(function() {
            // Fungsi untuk memperbarui data secara real-time
            function updateDashboardStats() {
                $.ajax({
                    url: '{{ url('Admin/dashboard/stats') }}',
                    method: 'GET',
                    success: function(response) {
                        console.log('Stats response:', response);

                        // Debugging: pastikan elemen ditemukan
                        if ($('#totalUsers').length) {
                            $('#totalUsers').text(response.totalUsers || 0);
                        } else {
                            console.error('Element #totalUsers not found.');
                        }

                        if ($('#totalCompetitions').length) {
                            $('#totalCompetitions').text(response.totalCompetitions || 0);
                        } else {
                            console.error('Element #totalCompetitions not found.');
                        }

                        if ($('#totalAchievements').length) {
                            $('#totalAchievements').text(response.totalAchievements || 0);
                        } else {
                            console.error('Element #totalAchievements not found.');
                        }

                        if ($('#pendingCompetitions').length) {
                            $('#pendingCompetitions').text(response.pendingCompetitions || 0);
                        } else {
                            console.error('Element #pendingCompetitions not found.');
                        }

                        if ($('#timeNow').length) {
                            $('#timeNow').text(
                                'Selamat datang, kelola sistem Anda dengan mudah di sini. ' +
                                response.timeNow);
                        } else {
                            console.error('Element #timeNow not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching stats:', status, error, xhr.responseText);
                    }
                });
            }

            // Panggil fungsi setiap 5 detik
            setInterval(updateDashboardStats, 5000);

            // Inisialisasi grafik
            const chartElement = document.getElementById('competitionChart');
            if (chartElement) {
                const competitionChart = new Chart(chartElement, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                            label: 'Jumlah Lomba',
                            data: [10, 20, 15, 25, 1, 0, 0, 0, 0, 0, 0, 0],
                            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545',
                                '#6f42c1', '#fd7e14', '#20c997', '#e83e8c', '#343a40',
                                '#6610f2', '#007bff'
                            ],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                console.error('Element with ID "competitionChart" not found.');
            }
        });
    </script>
@endpush
