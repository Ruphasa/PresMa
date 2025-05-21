<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <a href="index.html" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>PresMa</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="{{ url('/') }}"class="nav-item nav-link {{ ($activeMenu == 'home') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/Achievement') }}" class="nav-item nav-link {{ ($activeMenu == 'acheivement') ? 'active' : '' }}">My Achievement</a>
                <a href="{{ url('Dosen/achievement') }}" class="nav-item nav-link {{ ($activeMenu == 'acheivement') ? 'active' : '' }}">My Achievement</a>
                <a href="{{ url('/Competition') }}" class="nav-item nav-link {{ ($activeMenu == 'competition') ? 'active' : '' }}">Competition</a>
                <a href="{{ url('/Admin') }}" class="nav-item nav-link {{ ($activeMenu == 'admin') ? 'active' : '' }}">Admin 🤫</a>
            </div>
            <a href="" class="btn btn-primary py-2 px-4 d-none d-lg-block">Login</a>
        </div>
    </nav>
</div>
<!-- Navbar End -->