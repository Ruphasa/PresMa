<form action="{{ url('prodi/store_ajax') }}" method="POST" id="form-tambah-prodi">
    @csrf
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Program Studi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Kode Prodi</label>
                    <input type="text" name="kode_prodi" class="form-control" required>
                    <small id="error-kode_prodi" class="form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Prodi</label>
                    <input type="text" name="nama_prodi" class="form-control" required>
                    <small id="error-nama_prodi" class="form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script src="{{ secure_asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ secure_asset('js/vendor/jquery.validate.min.js') }}"></script>
<script src="{{ secure_asset('js/vendor/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#form-tambah-prodi').validate({
            rules: {
                kode_prodi: {
                    required: true
                },
                nama_prodi: {
                    required: true
                }
            },
            messages: {
                kode_prodi: {
                    required: "Kode Prodi wajib diisi"
                },
                nama_prodi: {
                    required: "Nama Prodi wajib diisi"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire('Berhasil', response.message, 'success');
                            if (typeof dataProdi !== 'undefined') {
                                dataProdi.ajax.reload();
                            }
                        } else {
                            $('.form-text.text-danger').text('');
                            $.each(response.msgField, function(key, val) {
                                $('#error-' + key).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Terjadi kesalahan: ' + xhr.responseText,
                            'error');
                    }
                });
                return false;
            }
        });
    });
</script>
