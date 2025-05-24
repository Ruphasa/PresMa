@extends('layouts.template')
@section('content')
    <!-- Courses Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mx-0 justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">All About You
                        </h6>
                        <h1 class="display-4">Your Profile</h1>
                    </div>
                </div><!-- End Portfolio Filters -->
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body text-center py-4">
                            <img src="{{ asset('storage/img/' . auth()->user()->img) }}" alt="Foto Profil"
                                class="rounded-circle mb-3" width="120" height="120"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/120?text=No+Image';">
                            <h3 class="mb-0">{{ auth()->user()->nama }}</h3>
                            <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                            <span class="badge bg-secondary">Level ID: {{ auth()->user()->level_id }}</span>
                        </div>
                        <div class="card-footer text-center">
                            <a href="./profile/edit" class="btn btn-primary btn-sm">Edit Profile</a>
                            <a href="./logout" class="btn btn-danger btn-sm">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Courses End -->
@endsection