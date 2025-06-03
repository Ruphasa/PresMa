@extends('layouts.template')
@section('content')
    <!-- Feature Start -->
    <div class="container-fluid bg-image" style="margin: 90px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 my-5 pt-5 pb-lg-5">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Why Choose Us?</h6>
                        <h1 class="display-4">Politeknik Negeri Malang</h1>
                    </div>
                    <p class="mb-4 pb-2">Politeknik Negeri Malang adalah Instansi bla bla bla..</p>
                    <div class="d-flex mb-3">
                        <div class="btn-icon bg-primary mr-4">
                            <i class="fa fa-2x fa-graduation-cap text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>Skilled Instructors</h4>
                            <p>Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no nonumy
                                et eos dolor magna ipsum.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="btn-icon bg-secondary mr-4">
                            <i class="fa fa-2x fa-certificate text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>International Certificate</h4>
                            <p>Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no nonumy
                                et eos dolor magna ipsum.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="btn-icon bg-warning mr-4">
                            <i class="fa fa-2x fa-book-reader text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>Online Classes</h4>
                            <p class="m-0">Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna
                                kasd no nonumy et eos dolor magna ipsum.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="{{ asset('Edukate/img/feature.jpg') }}"
                            style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="{{ asset('Edukate/img/about.jpg') }}"
                            style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">About Us</h6>
                        <h1 class="display-4">PresMa</h1>
                    </div>
                    <p>PresMa adalah Sistem Informasi Pencatatan Prestasi untuk mahasiswa polinema bla bla blaa...</p>
                    <div class="row pt-3 mx-0">
                        <div class="col-3 px-0">
                            <div class="bg-success text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">{{ $totalAchievements }}</h1>
                                <h6 class="text-uppercase text-white">Total<span class="d-block">Prestasi</span></h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-primary text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">{{ $studentsWithAchievements }}</h1>
                                <h6 class="text-uppercase text-white">Mahasiswa<span class="d-block">Berprestasi</span>
                                </h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-secondary text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up">{{ $totalCompetitions }}</h1>
                                <h6 class="text-uppercase text-white">Total<span class="d-block">Lomba</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Team Start -->
    <div class="container-fluid bg-image" style="margin: 0;">
        <div class="container py-5">
            <div class="section-title text-center position-relative mb-5">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Top 5</h6>
                <h1 class="display-4">Mahasiswa Berprestasi Kita</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding: 0 30px;">
                @foreach ($topStudents as $index => $student)
                    <div class="team-item">
                        <img class="img-fluid w-100" src="{{ asset($student->user->img ?? 'Edukate/img/team-1.jpg') }}"
                            alt="">
                        <div class="bg-light text-center p-4">
                            <h5 class="mb-3">{{ $student->user->nama }}</h5>
                            <p class="mb-2">Points: {{ $student->point }}</p>
                            <div class="d-flex justify-content-center">
                                <a class="mx-1 p-1" href="#">{{ $index + 1 }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Courses Start -->
    <div class="container-fluid px-0">
        <div class="row mx-0 justify-content-center pt-5">
            <div class="col-lg-6">
                <div class="section-title text-center position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Lomba Terbaru</h6>
                    <h1 class="display-4">Ayo Segera Ikut Serta!</h1>
                </div>
            </div>
        </div>
        <div class="owl-carousel courses-carousel">
            @foreach ($latestCompetitions as $competition)
                <div class="courses-item position-relative">
                    <img class="img-fluid" src="{{ asset('Edukate/img/courses-1.jpg') }}" alt="">
                    <div class="courses-text">
                        <h4 class="text-center text-white px-3">{{ $competition->lomba_nama }}</h4>
                        <div class="border-top w-100 mt-3">
                            <div class="d-flex justify-content-between p-4">
                                <span class="text-white"><i
                                        class="fa fa-user mr-2"></i>{{ $competition->kategori->kategori_nama ?? 'Unknown' }}</span>
                                <span class="text-white"><i
                                        class="fa fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($competition->lomba_tanggal)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="w-100 bg-white text-center p-4">
                            <a class="btn btn-primary" href="{{ url('competition/' . $competition->lomba_id) }}">Course
                                Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Courses End -->
@endsection
