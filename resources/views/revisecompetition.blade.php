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
                                <option value="{{ $compeptition->kategori->kategori_id }}">
                                    {{ $competition->kategori->kategori_nama }}</option>
                                @foreach ($categories as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Lomba -->
                        <div class="form-group">
                            <label for="lomba_nama">Nama Lomba</label>
                            <input type="text" name="lomba_nama" id="lomba_nama" class="form-control" required>
                            {{ old($competition->lomba_nama ?? '') }}
                        </div>

                        <!-- Tingkat Lomba -->
                        <div class="form-group">
                            <label for="lomba_tingkat">Tingkat</label>
                            <select name="lomba_tingkat" id="lomba_tingkat" class="form-control" required>
                                <option value="{{ $competition->lomba_tingkat }}">
                                    {{ old($competition->lomba_tingkat ?? '') }}</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                                <option value="Regional">Regional</option>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="lomba_tanggal">Tanggal Lomba</label>
                            <input type="date" name="lomba_tanggal" id="lomba_tanggal" class="form-control" required>
                            {{ old($competition->lomba_tanggal ?? '') }}
                        </div>

                        <!-- Detail Lomba -->
                        <div class="form-group">
                            <label for="lomba_detail">Detail Lomba</label>
                            <textarea name="lomba_detail" id="lomba_detail" class="form-control" rows="4" required>
                                {{ old($competition->lomba_detail ?? '') }}
                            </textarea>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status" hidden>Status</label>
                            <select name="status" id="status" class="form-control" required disabled hidden>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <!-- Ambil USER ID -->
                        <div class="form-group" hidden>
                            <input type="text" name="user_id" id="user_id" class="form-control" hidden
                                value="{{ $userId }}">
                        </div>

                        <!-- Submit -->
                        <a type="delete" class="btn btn-primary mt-3">Urungkan Lomba</button>

                            <button type="submit" class="btn btn-primary mt-3">Upload Lomba</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
