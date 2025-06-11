@extends('layouts.template')
@section('content')
    <!-- Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <div class="section-title position-relative mb-5">
                            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Competition
                                Detail
                            </h6>
                            <h1 class="display-4">{{ $competition->lomba_nama }}</h1>
                        </div>
                        <img class="img-fluid rounded w-100 mb-4" src="{{ asset('Edukate/img/header.jpg') }}" alt="Image">
                        <p>{{ $competition->lomba_detail }}</p>

                        <p>Sadipscing labore amet rebum est et justo gubergren. Et eirmod ipsum sit diam ut magna lorem.
                            Nonumy vero labore lorem sanctus rebum et lorem magna kasd, stet amet magna accusam
                            consetetur eirmod. Kasd accusam sit ipsum sadipscing et at at sanctus et. Ipsum sit
                            gubergren dolores et, consetetur justo invidunt at et aliquyam ut et vero clita. Diam sea
                            sea no sed dolores diam nonumy, gubergren sit stet no diam kasd vero.</p>
                    </div>

                    <h2 class="mb-3">Related Competition</h2>
                    <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                        @for ($index = 0; $index < 4; $index++)
                            <a class="courses-list-item position-relative d-block overflow-hidden mb-2" href="detail.html">
                                <img class="img-fluid" src="{{ asset('Edukate/img/courses-1.jpg') }}" alt="">
                                <div class="courses-text">
                                    <h4 class="text-center text-white px-3">Web design & development courses for
                                        beginners</h4>
                                    <div class="border-top w-100 mt-3">
                                        <div class="d-flex justify-content-between p-4">
                                            <span class="text-white"><i class="fa fa-user mr-2"></i>Jhon Doe</span>
                                            <span class="text-white"><i class="fa fa-star mr-2"></i>4.5
                                                <small>(250)</small></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endfor
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="bg-primary mb-5 py-3">
                        <h3 class="text-white py-3 px-4 m-0">Competition Features</h3>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Penyelenggara</h6>
                            <h6 class="text-white my-3">John Doe</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Kategori</h6>
                            <h6 class="text-white my-3">{{ $competition->kategori->kategori_nama ?? 'Unknown' }}</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Batas Waktu Pendaftaran</h6>
                            <h6 class="text-white my-3">{{ $competition->lomba_tanggal }}</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Tingkat</h6>
                            <h6 class="text-white my-3">{{ $competition->lomba_tingkat }}</h6>
                        </div>
                        <div class="py-3 px-4">
                            <a class="btn btn-block btn-secondary py-3 px-5" href="">Daftar Sekarang</a>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h2 class="mb-3">Categories</h2>
                        <ul class="list-group list-group-flush">
                            @for ($index = 0; $index < 5; $index++)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <a href="" class="text-decoration-none h6 m-0">Web Design</a>
                                    <span class="badge badge-primary badge-pill">150</span>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="mb-4">Recent Courses</h2>
                        @for ($index = 0; $index < 4; $index++)
                            <a class="d-flex align-items-center text-decoration-none mb-4" href="">
                                <img class="img-fluid rounded" src="{{ asset('Edukate/img/courses-80x80.jpg') }}"
                                    alt="">
                                <div class="pl-3">
                                    <h6>Web design & development courses for beginners</h6>
                                    <div class="d-flex">
                                        <small class="text-body mr-3"><i class="fa fa-user text-primary mr-2"></i>Jhon
                                            Doe</small>
                                        <small class="text-body"><i class="fa fa-star text-primary mr-2"></i>4.5
                                            (250)</small>
                                    </div>
                                </div>
                            </a>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->
@endsection
