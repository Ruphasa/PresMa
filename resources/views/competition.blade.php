@extends('layouts.template')

@section('content')
    <!-- Competitions Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mx-0 justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Competition
                        </h6>
                        <h1 class="display-4">List of Competitions Available</h1>
                    </div>
                </div><!-- End Portfolio Filters -->
            </div>
            <div class="row">
                @forelse ($competitions as $c)
                    <div class="col-lg-4 col-md-6 pb-4">
                        <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                            href="{{ url('Competition/' . $c->lomba_id) }}">
                            <img class="img-fluid" src="{{ asset('Edukate/img/courses-1.jpg') }}" alt="">
                            <div class="courses-text">
                                <h4 class="text-center text-white px-3">{{ $c->lomba_nama }}</h4>
                                <div class="border-top w-100 mt-3">
                                    <div class="d-flex justify-content-between p-4">
                                        <span class="text-white"><i
                                                class="fa fa-list mr-2"></i>{{ $c->kategori->kategori_nama ?? 'N/A' }}</span>
                                        <span class="text-white"><i
                                                class="fa fa-calendar mr-2"></i>{{ $c->lomba_tanggal }}</span>
                                    </div>
                                    <div class="text-center text-white pb-2">
                                        <span><i class="fa fa-info-circle mr-2"></i>{{ $c->lomba_tingkat }}</span>
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
