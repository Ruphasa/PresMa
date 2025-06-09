@extends('layouts.template')
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Lomba Baru</h1>
                        <p class="lead">Sarankan Lomba baru!</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form action="./store" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Kategori Dropdown -->
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Lomba -->
                        <div class="form-group">
                            <label for="lomba_nama">Nama Lomba</label>
                            <input type="text" name="lomba_nama" id="lomba_nama" class="form-control" required>
                        </div>

                        <!-- Tingkat Lomba -->
                        <div class="form-group">
                            <label for="lomba_tingkat">Tingkat</label>
                            <input type="text" name="lomba_tingkat" id="lomba_tingkat" class="form-control" required>
                        </div>

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="lomba_tanggal">Tanggal Lomba</label>
                            <input type="date" name="lomba_tanggal" id="lomba_tanggal" class="form-control" required>
                        </div>

                        <!-- Detail Lomba -->
                        <div class="form-group">
                            <label for="lomba_detail">Detail Lomba</label>
                            <textarea name="lomba_detail" id="lomba_detail" class="form-control" rows="4"
                                required></textarea>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required disabled>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <!-- Keterangan (Opsional) -->
                        <div class="form-group">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>

                        <!-- Ambil USER ID -->
                        <div class="form-group" hidden>
                            <input type="text" name="user_id" id="user_id" class="form-control" hidden value="{{ auth()->user()->id }}">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary mt-3">Simpan Lomba</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection