<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            @empty($mahasiswa)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @endempty
            @isset($mahasiswa)
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>NIM</th>
                        <td>{{ $mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $mahasiswa->user->nama }}</td>
                    </tr>
                    {{-- <tr>
                        <th>Prodi</th>
                        <td>{{ $mahasiswa->prodi->prodi_nama }}</td>
                    </tr> --}}
                    {{-- <tr>
                        <th>Angkatan</th>
                        <td>{{ $mahasiswa->angkatan->angkatan_nama }}</td>
                    </tr> --}}
                </table>
            @endisset
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Keluar</button>
        </div>
    </div>
</div>
