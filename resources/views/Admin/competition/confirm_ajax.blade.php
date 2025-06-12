@empty($mahasiswa)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data Mahasiswa tidak ditemukan
                </div>
                <a href="{{ secure_url('/mahasiswa') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ secure_url('/mahasiswa/' . $user->user_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data berikut?
                    </div>

                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-right col-4">Username:</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">User ID:</th>
                            <td>{{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Jumlah Mahasiswa:</th>
                            <td>{{ $mahasiswa->count() }}</td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <h6>Daftar Mahasiswa:</h6>
                        <ul>
                            @foreach ($mahasiswa as $mhs)
                                <li>{{ $mhs->nim }} - {{ $mhs->user->username ?? 'Tidak ditemukan' }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").on('submit', function(e) {
                e.preventDefault();
                let form = this;
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire('Berhasil', response.message, 'success');
                            dataMahasiswa.ajax.reload();
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                    }
                });
            });
        });
    </script>
@endempty
