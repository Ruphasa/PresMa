@extends('layouts.template')
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Tambah Prestasi Baru</h1>
                        <p class="lead">Submit Prestasi baru!</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form action="./store" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="lomba_id">Prestasi Lomba</label>
                            <select name="lomba_id" id="lomba_id" class="form-control" required>
                                <option value="" disabled selected>Pilih Lomba</option>
                                @foreach ($lomba as $l)
                                    <option value="{{ $l->id }}">{{ $l->lomba_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tingkat_prestasi">Tingkat Prestasi</label>
                            <input type="text" class="form-control" id="tingkat_prestasi" name="tingkat_prestasi" placeholder="Masukkan Tingkat Prestasi (Nasional, Internasional...)" required>
                        </div>
                        <div class="form-group">
                            <label for="juara_ke">Juara ke</label>
                            <input type="number" class="form-control" id="juara_ke" name="juara_ke"
                                placeholder="Masukkan Juara ke (1, 2, 3...)" required>
                        </div>
                        <!-- Hidden, Mahasiswa NIM -->
                        <input type="hidden" name="mahasiswa_id" value="{{ auth()->user()->nim }}">
                        <!-- Submit -->
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-plus"></i> Tambah Prestasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
