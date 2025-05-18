@extends('layouts.template')
<!-- About Start -->
@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100" src="{{asset('Edukate/img/about.jpg')}}"
                        style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="section-title position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">About Us</h6>
                    <h1 class="display-4">First Choice For Online Education Anywhere</h1>
                </div>
                <p>Tempor erat elitr at rebum at at clita aliquyam consetetur. Diam dolor diam ipsum et, tempor
                    voluptua sit consetetur sit. Aliquyam diam amet diam et eos sadipscing labore. Clita erat ipsum
                    et lorem et sit, sed stet no labore lorem sit. Sanctus clita duo justo et tempor consetetur
                    takimata eirmod, dolores takimata consetetur invidunt magna dolores aliquyam dolores dolore.
                    Amet erat amet et magna</p>
                <div class="row pt-3 mx-0">
                    <div class="col-3 px-0">
                        <div class="bg-success text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up">123</h1>
                            <h6 class="text-uppercase text-white">Available<span class="d-block">Subjects</span>
                            </h6>
                        </div>
                    </div>
                    <div class="col-3 px-0">
                        <div class="bg-primary text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up">1234</h1>
                            <h6 class="text-uppercase text-white">Online<span class="d-block">Courses</span></h6>
                        </div>
                    </div>
                    <div class="col-3 px-0">
                        <div class="bg-secondary text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up">123</h1>
                            <h6 class="text-uppercase text-white">Skilled<span class="d-block">Instructors</span>
                            </h6>
                        </div>
                    </div>
                    <div class="col-3 px-0">
                        <div class="bg-warning text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up">1234</h1>
                            <h6 class="text-uppercase text-white">Happy<span class="d-block">Students</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Feature Start -->
<div class="container-fluid bg-image" style="margin: 90px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 my-5 pt-5 pb-lg-5">
                <div class="section-title position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Why Choose Us?
                    </h6>
                    <h1 class="display-4">Why You Should Start Learning with Us?</h1>
                </div>
                <p class="mb-4 pb-2">Aliquyam accusam clita nonumy ipsum sit sea clita ipsum clita, ipsum dolores
                    amet voluptua duo dolores et sit ipsum rebum, sadipscing et erat eirmod diam kasd labore clita
                    est. Diam sanctus gubergren sit rebum clita amet.</p>
                <div class="d-flex mb-3">
                    <div class="btn-icon bg-primary mr-4">
                        <i class="fa fa-2x fa-graduation-cap text-white"></i>
                    </div>
                    <div class="mt-n1">
                        <h4>Skilled Instructors</h4>
                        <p>Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no
                            nonumy et eos dolor magna ipsum.</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="btn-icon bg-secondary mr-4">
                        <i class="fa fa-2x fa-certificate text-white"></i>
                    </div>
                    <div class="mt-n1">
                        <h4>International Certificate</h4>
                        <p>Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita magna kasd no
                            nonumy et eos dolor magna ipsum.</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="btn-icon bg-warning mr-4">
                        <i class="fa fa-2x fa-book-reader text-white"></i>
                    </div>
                    <div class="mt-n1">
                        <h4>Online Classes</h4>
                        <p class="m-0">Labore rebum duo est Sit dolore eos sit tempor eos stet, vero vero clita
                            magna kasd no nonumy et eos dolor magna ipsum.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100" src="{{asset('Edukate/img/feature.jpg')}}"
                        style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature Start -->


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
        {{-- nanti di ganti foreach --}}
        @for ($index = 0; $index < 6; $index++)
            <div class="courses-item position-relative">
                <img class="img-fluid" src="{{asset('Edukate/img/courses-1.jpg')}}" alt="">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3">Web design & development courses for beginners</h4>
                    <div class="border-top w-100 mt-3">
                        <div class="d-flex justify-content-between p-4">
                            <span class="text-white"><i class="fa fa-user mr-2"></i>Jhon Doe</span>
                            <span class="text-white"><i class="fa fa-star mr-2"></i>4.5 <small>(250)</small></span>
                        </div>
                    </div>
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="detail.html">Course Detail</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
<!-- Courses End -->


<!-- Team Start -->
<div class="container-fluid bg-image" style="margin: 0;">
    <div class="container py-5">
        <div class="section-title text-center position-relative mb-5">
            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Top 5</h6>
            <h1 class="display-4">Mahasiswa Berprestasi Kita</h1>
        </div>
        <div class="owl-carousel team-carousel position-relative" style="padding: 0 30px;">
            @for ($index = 0; $index < 5; $index++)
                <div class="team-item">
                    <img class="img-fluid w-100" src="{{asset('Edukate/img/team-1.jpg')}}" alt="">
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Ruphasa Mafahl</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#">{{$index + 1}}</i></a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
<!-- Team End -->
@endsection