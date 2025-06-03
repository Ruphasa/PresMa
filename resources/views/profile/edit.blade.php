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
                        <h1 class="display-4">Edit Profile</h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body">
                            <form action="./update" method="POST" enctype="multipart/form-data">
                                @csrf

                                @method('PUT')
                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger text-center">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="text-center mb-4">
                                    <img src="{{ auth()->user()->img
                                        ? asset('storage/img/' . auth()->user()->img)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama) . '&size=120&background=random' }}"
                                        alt="Foto Profil" class="rounded-circle shadow" width="120" height="120"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/120?text=No+Image';" />
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', auth()->user()->nama) }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ auth()->user()->email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="img">Foto Profil</label>
                                    <input type="file" name="img" class="form-control-file">
                                </div>

                                @if (auth()->user()->level_id == 3)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ipk">IPK</label>
                                                <input type="text" name="ipk" class="form-control"
                                                    value="{{ old('ipk', auth()->user()->mahasiswa->ipk ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="point">Prefrensi Lomba</label>
                                                <input type="text" name="point" class="form-control"
                                                    value="{{ old('point', auth()->user()->mahasiswa->prefrensi_lomba ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="ipk"
                                        value="{{ auth()->user()->mahasiswa()->ipk ?? '' }}">
                                    <input type="hidden" name="point"
                                        value="{{ auth()->user()->mahasiswa()->preferensi_lomba ?? '' }}">
                                @endif

                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-primary px-5">Update Profil</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Courses End -->
@endsection
