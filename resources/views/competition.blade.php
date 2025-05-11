@extends('layouts.template')
<!-- Content Start -->
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="../admin/dashboard" class="nav-item nav-link active">Dashboard</a>
                    <a href="../admin/user" class="nav-item nav-link">Users</a>
                    <a href="../admin/competition" class="nav-item nav-link">Competitions</a>
                    <a href="../admin/achievement" class="nav-item nav-link">Achievements</a>
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
            <div class="row" id="competitions">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Competition Table</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Code Challenge</td>
                                        <td>2025-05-15</td>
                                        <td><a href="#" class="btn btn-sm btn-primary">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Design Contest</td>
                                        <td>2025-05-20</td>
                                        <td><a href="#" class="btn btn-sm btn-primary">Edit</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Admin Dashboard End -->
@endsection
<!-- Content End -->