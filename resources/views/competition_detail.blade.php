@extends('layouts.template')

@section('content')
    <!-- Competition Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ $breadcrumb->list[0] }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/Competition') }}">{{ $breadcrumb->list[1] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb->list[2] }}</li>
                </ol>
            </nav>
            <h1 class="mb-4">{{ $breadcrumb->title }}</h1>

            <!-- Page Title -->
            <div class="mb-4">
                <h4>{{ $page->title }}</h4>
            </div>

            <!-- Competition Details -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('Edukate/img/courses-1.jpg') }}" alt="{{ $competition->lomba_nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $competition->lomba_nama }}</h5>
                            <p class="card-text"><strong>Category:</strong> {{ $competition->kategori->nama ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Date:</strong> {{ $competition->lomba_tanggal }}</p>
                            <p class="card-text"><strong>Details:</strong> {{ $competition->lomba_detail ?? 'No details available.' }}</p>
                            <p class="card-text"><strong>Status:</strong> {{ $competition->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Competition Detail End -->
@endsection