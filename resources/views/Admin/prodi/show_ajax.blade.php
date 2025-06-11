<div id="modal-master" class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Program Studi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            @empty($prodi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data Program Studi tidak ditemukan.
                </div>
            @endempty

            @isset($prodi)
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Kode Prodi</th>
                        <td>{{ $prodi->kode_prodi }}</td>
                    </tr>
                    <tr>
                        <th>Nama Prodi</th>
                        <td>{{ $prodi->nama_prodi }}</td>
                    </tr>
                    @if(isset($prodi->fakultas))
                    <tr>
                </table>
            @endisset
        </div>

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Keluar</button>
        </div>
    </div>
</div>
