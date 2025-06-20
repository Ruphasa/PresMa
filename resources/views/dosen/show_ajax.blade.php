<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail prestasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            @empty($prestasi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @endempty
            @isset($prestasi)
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tbody>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <td>{{ $prestasi->mahasiswa->user->nama}}</td>
                        </tr>

                        <tr>
                            <th>Nama Lomba</th>
                            <td>{{ $prestasi->lomba->lomba_nama }}</td>
                        </tr>

                        <tr>
                            <th>tingkat Prestasi</th>
                            <td>{{ $prestasi->tingkat_prestasi }}</td>
                        </tr>

                        <tr>
                            <th>Juara Ke</th>
                            <td>{{ $prestasi->juara_ke }}</td>
                        </tr>
                    </tbody>
                </table>
            @endisset
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Keluar</button>
        </div>
    </div>
</div>
