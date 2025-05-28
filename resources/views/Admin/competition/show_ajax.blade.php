<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Competition</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            @empty($competition)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @endempty
            @isset($competition)
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $competition->lomba_id }}</td>
                    </tr>
                    <tr>
                        <th>Kategori Competition</th>
                        <td>{{ $competition->kategori->kategori_nama }}</td>
                    <tr>
                        <th>Nama Competition</th>
                        <td>{{ $competition->lomba_nama }}</td>
                    </tr>
                    <tr>
                        <th>Tingkat</th>
                        <td>{{ $competition->lomba_tingkat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Competition</th>
                        <td>{{ $competition->lomba_tanggal }}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-striped table-hover table-sm" id="table_rekomendasi">
                    @if ($rekomendasi->isEmpty())
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Cari Rekomndasi Mahasiswa ?</h5>
                            <a type="button" class="btn btn-primary" id="btn-cari-rekomendasi" href="{{ url('/Admin/competition/' . $competition->lomba_id . '/rekomendasi') }}">
                                Carikan doong~
                            </a>
                        </div>
                    @else
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NIM</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekomendasi as $item)
                                <tr>
                                    <td>{{ $item->rekomendasi_id }}</td>
                                    <td>{{ $item->mahasiswa->nim }}</td>
                                    <td>{{ $item->mahasiswa->mahasiswa_nama }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <a type="button" class="btn btn-success" id="btn-kirim-notif" href="{{ url('') }}">
                                Kirim Notif
                            </a>
                    @endif
                </table>
            @endisset
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Keluar</button>
        </div>
    </div>
</div>
