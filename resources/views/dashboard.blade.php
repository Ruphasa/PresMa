@extends('layouts.template')
@section('content')
<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="index" class="nav-item nav-link active">Dashboard</a>
                <a href="admin/user" class="nav-item nav-link">Users</a>
                <a href="#competitions" class="nav-item nav-link">Competitions</a>
                <a href="#achievements" class="nav-item nav-link">Achievements</a>
            </div>
        </div>
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
                        <p class="lead">Manage your content and settings here.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">User Management</h5>
                            <p class="card-text">View and manage user accounts.</p>
                            <a href="#" class="btn btn-light">Go to Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Course Management</h5>
                            <p class="card-text">Add or edit courses.</p>
                            <a href="#" class="btn btn-light">Go to Courses</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Competition Management</h5>
                            <p class="card-text">Manage competition details.</p>
                            <a href="#" class="btn btn-light">Go to Competitions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Admin Dashboard End -->
@endsection
<!-- Content End -->