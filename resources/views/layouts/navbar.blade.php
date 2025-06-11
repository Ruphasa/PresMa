<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PresMa</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Load Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS (opsional, untuk styling tambahan) -->
    <style>
        .navbar-brand i {
            color: #007bff;
        }

        .navbar-brand h1 {
            display: inline;
            font-size: 1.5rem;
        }

        .dropdown-menu-right {
            right: 0;
            left: auto;
        }

        .img-size-50 {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="navbar-brand ml-lg-3">
                <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>PresMa</h1>
            </a>
            <!-- Toggler for mobile view -->
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <!-- Main Menu -->
                <div class="navbar-nav mx-auto py-0">
                    <a href="{{ url('/') }}"
                        class="nav-item nav-link {{ $activeMenu == 'home' ? 'active' : '' }}">Home</a>
                    @if (Auth::user()->hasRole('DP'))
                        <a href="{{ url('/Achievement') }}"
                            class="nav-item nav-link {{ $activeMenu == 'achievement' ? 'active' : '' }}">My Student
                            Achievement</a>
                    @endif
                    @if (Auth::user()->hasRole('MHS'))
                        <a href="{{ url('/Student/achievement') }}"
                            class="nav-item nav-link {{ $activeMenu == 'achievement' ? 'active' : '' }}">My
                            Achievement</a>
                    @endif
                    <a href="{{ url('/ListCompetition') }}"
                        class="nav-item nav-link {{ $activeMenu == 'listcompetition' ? 'active' : '' }}">Competition</a>
                    @if (Auth::user()->hasRole('ADM'))
                        <a href="{{ url('/Admin') }}"
                            class="nav-item nav-link {{ $activeMenu == 'admin' ? 'active' : '' }}">Admin 🤫</a>
                    @endif
                </div>

                <!-- Dropdown Notifikasi -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" data-toggle="dropdown"
                        role="button" aria-expanded="false">
                        <i class="bi bi-bell">🔔</i>
                        <span class="badge badge-danger" id="notificationCount"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" id="notificationList"
                        aria-labelledby="notificationDropdown">
                        <!-- Notifikasi akan diisi oleh AJAX -->
                    </div>
                </div>

                <!-- User Dropdown -->
                @if (Auth::user())
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button">
                            <img src="{{ asset('storage/img/' . Auth::user()->username . '.png') }}" alt=""
                                class="img-size-50 img-circle mr-2">
                            {{ Auth::user()->nama }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ url('/profile') }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="{{ url('/profile/edit') }}" class="dropdown-item">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('/logout') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2 btn btn-danger"></i> Logout
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Jika belum login, tampilkan tombol login -->
                    <a href="{{ url('/login') }}" class="btn btn-primary py-2 px-4">Login</a>
                @endif
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Load jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- AJAX untuk Notifikasi -->
    <script>
        $(document).ready(function() {
            // Atur CSRF token untuk AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fungsi untuk memuat notifikasi
            function loadNotifications() {
                $.ajax({
                    url: '/notifications',
                    method: 'GET',
                    success: function(response) {
                        const {
                            data,
                            total
                        } = response;
                        const notificationList = $('#notificationList');
                        const notificationCount = $('#notificationCount');

                        // Bersihkan daftar notifikasi
                        notificationList.empty();

                        // Perbarui jumlah notifikasi
                        notificationCount.text(total > 10 ? '10+' : total);
                        notificationCount.toggle(total > 0);

                        // Tambahkan item notifikasi ke dropdown untuk role ADM
                        if ({{ Auth::user()->hasRole('ADM') ? 'true' : 'false' }}) {
                            if (data.pending_achievements > 0) {
                                notificationList.append(
                                    '<a class="dropdown-item" href="' +
                                    '{{ url('/Admin/achievement') }}' +
                                    '">Pending Achievements: ' +
                                    data.pending_achievements + '</a>'
                                );
                            }
                            if (data.pending_competitions > 0) {
                                notificationList.append(
                                    '<a class="dropdown-item" href="' +
                                    '{{ url('Admin/competition') }}' +
                                    '">Pending Competitions: ' +
                                    data.pending_competitions + '</a>'
                                );
                            }
                        } else if ({{ Auth::user()->hasRole('MHS') ? 'true' : 'false' }}) {
                            data.recommended_competitions.forEach(competition => {
                                notificationList.append(
                                    '<a class="dropdown-item" href="' +
                                    '{{ url('Competition/competition.lomba.lomba_id') }}' +
                                    '">Recommended: ' +
                                    competition.lomba_nama + '</a>'
                                );
                            });
                            data.rejected_competitions.forEach(competition => {
                                notificationList.append(
                                    '<a class="dropdown-item" href="' +
                                    '{{ url('Competition/competition.lomba.lomba_id/edit') }}/' +
                                    '">Rejected Competition: ' +
                                    competition.lomba_nama + '</a>'
                                );
                            });
                            data.rejected_achievements.forEach(achievement => {
                                notificationList.append(
                                    '<a class="dropdown-item" href="#">Rejected Achievement: ' +
                                    achievement.lomba.lomba_nama + '</a>'
                                );
                            });
                        } else if ({{ Auth::user()->hasRole('DP') ? 'true' : 'false' }}) {
                            data.rejected_competitions.forEach(competition => {
                                notificationList.append(
                                    '<a class="dropdown-item" href="{{ url('Competition/competition.lomba_id/edit') }}">Rejected Competition: ' +
                                    competition.lomba_nama + '</a>'
                                );
                            });
                            if (data.pending_achievements > 0) {
                                notificationList.append(
                                    '<a class="dropdown-item" href="' +
                                    '{{ url('/Achievement') }}' + '">Pending Achievements: ' +
                                    data.pending_achievements + '</a>'
                                );
                            }
                        }

                        // Jika tidak ada notifikasi, tambahkan pesan default
                        if (notificationList.children().length === 0) {
                            notificationList.append(
                                '<a class="dropdown-item" href="#">No notifications</a>'
                            );
                        }
                    },
                    error: function() {
                        $('#notificationList').append(
                            '<a class="dropdown-item" href="#">Gagal memuat notifikasi</a>'
                        );
                    }
                });
            }

            // Panggil loadNotifications saat halaman dimuat
            loadNotifications();

            // Opsional: Perbarui notifikasi setiap 60 detik
            setInterval(loadNotifications, 60000);
        });
    </script>
</body>

</html>
