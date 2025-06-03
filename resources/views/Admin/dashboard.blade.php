@extends('layouts.template')

@section('content')
    <!-- Admin Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Admin Dashboard</h1>
                        <p class="lead" id="timeNow">Selamat datang, kelola sistem Anda dengan mudah di sini.
                            {{ $timeNow }}</p>
                        <a href="{{ url('Admin/dashboard/export-pdf') }}" class="btn btn-primary mt-3">Export to PDF</a>
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

            <!-- Grafik Statistik -->
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4>Statistik Lomba per Bulan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="competitionChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4>Mahasiswa Berprestasi per Bulan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="achievementChart" style="height: 300px;"></canvas>
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
        $(document).ready(function() {
            // Inisialisasi grafik lomba
            const competitionChartElement = document.getElementById('competitionChart');
            let competitionChart = null;
            if (competitionChartElement) {
                competitionChart = new Chart(competitionChartElement, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                            label: 'Jumlah Lomba',
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
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
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Element with ID "competitionChart" not found.');
            }

            // Inisialisasi grafik mahasiswa berprestasi
            const achievementChartElement = document.getElementById('achievementChart');
            let achievementChart = null;
            if (achievementChartElement) {
                achievementChart = new Chart(achievementChartElement, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                            label: 'Mahasiswa Berprestasi',
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
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
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Element with ID "achievementChart" not found.');
            }

            // Fungsi untuk memperbarui data secara real-time
            function updateDashboardStats() {
                $.ajax({
                    url: '{{ url('Admin/dashboard/stats') }}',
                    method: 'GET',
                    success: function(response) {
                        console.log('Stats response:', response);

                        // Update statistik kartu
                        $('#totalUsers').text(response.totalUsers || 0);
                        $('#totalCompetitions').text(response.totalCompetitions || 0);
                        $('#totalAchievements').text(response.totalAchievements || 0);
                        $('#pendingCompetitions').text(response.pendingCompetitions || 0);
                        $('#timeNow').text('Selamat datang, kelola sistem Anda dengan mudah di sini. ' +
                            response.timeNow);

                        // Update grafik lomba
                        if (competitionChart && response.competitionData) {
                            console.log('Updating competition chart with data:', response
                                .competitionData);
                            competitionChart.data.datasets[0].data = response.competitionData;
                            competitionChart.update();
                        }

                        // Update grafik mahasiswa berprestasi
                        if (achievementChart && response.achievementData) {
                            console.log('Updating achievement chart with data:', response
                                .achievementData);
                            achievementChart.data.datasets[0].data = response.achievementData;
                            achievementChart.update();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching stats:', status, error, xhr.responseText);
                    }
                });
            }

            // Panggil fungsi setiap 5 detik
            setInterval(updateDashboardStats, 5000);
            updateDashboardStats(); // Panggil sekali saat halaman dimuat
        });
    </script>
@endpush
