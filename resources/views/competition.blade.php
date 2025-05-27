@extends('layouts.template')

@section('content')
    <!-- Competitions Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ $breadcrumb->list[0] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb->list[1] }}</li>
                </ol>
            </nav>
            <h1 class="mb-4">{{ $breadcrumb->title }}</h1>

            <!-- Page Title -->
            <div class="mb-4">
                <h4>{{ $page->title }}</h4>
            </div>

            <div class="row mx-0 justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Competition
                        </h6>
                        <h1 class="display-4">List of Latest Competitions Available</h1>
                    </div>
                </div><!-- End Portfolio Filters -->
            </div>
            <div class="row">
                @forelse ($competitions as $competition)
                    <div class="col-lg-4 col-md-6 pb-4">
                        <a class="courses-list-item position-relative d-block overflow-hidden mb-2" href="{{ route('competition.detail', $competition->lomba_id) }}">
                            <img class="img-fluid" src="{{ asset('Edukate/img/courses-1.jpg') }}" alt="">
                            <div class="courses-text">
                                <h4 class="text-center text-white px-3">{{ $competition->lomba_nama }}</h4>
                                <div class="border-top w-100 mt-3">
                                    <div class="d-flex justify-content-between p-4">
                                        <span class="text-white"><i class="fa fa-list mr-2"></i>{{ $competition->kategori->nama ?? 'N/A' }}</span>
                                        <span class="text-white"><i class="fa fa-calendar mr-2"></i>{{ $competition->lomba_tanggal }}</span>
                                    </div>
                                    <div class="text-center text-white pb-2">
                                        <span><i class="fa fa-info-circle mr-2"></i>{{ $competition->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No validated competitions available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Competitions End -->
@endsection