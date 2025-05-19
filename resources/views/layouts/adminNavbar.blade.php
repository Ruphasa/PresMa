    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="{{ url('/Admin/') }}" class="nav-item nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ url('/Admin/User') }}" class="nav-item nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">Users</a>
                    <a href="{{ url('/Admin/Competition') }}" class="nav-item nav-link {{ ($activeMenu == 'competitions') ? 'active' : '' }}">Competitions</a>
                    <a href="{{ url('/Admin/Achievement') }}" class="nav-item nav-link {{ ($activeMenu == 'achievements') ? 'active' : '' }}">Achievements</a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->