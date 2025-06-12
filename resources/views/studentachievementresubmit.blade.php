@extends('layouts.template')
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Tambah Prestasi Baru</h1>
                        <p class="lead">Submit Prestasi baru!.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="alert alert-info text-center col-lg-12">
                    <strong>Perhatian!</strong>
                    {{ $achievement->keterangan }}
                    <br>
                    Silakan lengkapi ulang data prestasi Anda sebelum mengirim ulang.
                </div>
                <div class="col-lg-12">
                    <form action="./update" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="lomba_id">Prestasi Lomba</label>
                            <select name="lomba_id" id="lomba_id" class="form-control">
                                @foreach ($lomba as $l)
                                    <option value="{{ $l->lomba_id }}" {{ $l->lomba_id == $id ? 'selected' : '' }}>
                                        {{ $l->lomba_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tingkat_prestasi">Tingkat Prestasi</label>
                            <input type="text" class="form-control" id="tingkat_prestasi" name="tingkat_prestasi"
                                placeholder="Masukkan Tingkat Prestasi (Nasional, Internasional...)"
                                value="{{ $achievement->tingkat_prestasi }}" required>
                        </div>
                        <div class="form-group">
                            <label for="juara_ke">Juara ke</label>
                            <select name="juara_ke" id="juara_ke" class="form-control" required>
                                <option value="" disabled selected>Pilih Juara ke</option>
                                @foreach ($rank as $r)
                                    <option value="{{ $r }}" {{ $achievement->juara_ke == $r ? 'selected' : '' }}>
                                        {{ $r->rank }}
                                    </option>
                                @endforeach
                        </div>
                        <div class="form-group">
                            <label for="bukti_prestasi">Bukti Prestasi (Gambar)</label>
                            <input type="file" class="form-control-file" id="bukti_prestasi" name="bukti_prestasi"
                                accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <img id="previewImage" src="{{ asset('storage/' . $achievement->bukti_prestasi) }}"
                                alt="Preview Image" class="img-fluid" style="display: block; max-width: 100%;">
                        </div>
                        <script>
                            document.getElementById('bukti_prestasi').addEventListener('change', function() {
                                const file = this.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const previewImage = document.getElementById('previewImage');
                                        previewImage.src = e.target.result;
                                    }
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>
                        <!-- Hidden, Mahasiswa NIM -->
                        <input type="hidden" name="mahasiswa_nim" value="{{ auth()->user()->nim }}">
                        <!-- Submit -->
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-plus"></i> Edit Prestasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection