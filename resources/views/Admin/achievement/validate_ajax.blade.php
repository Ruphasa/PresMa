@empty($achievement)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data prestasi yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/Admin/achievement') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@endempty

@isset($achievement)
    <form action="{{ url('/Admin/achievement/' . $achievement->prestasi_id . '/validate_ajax') }}" method="POST"
        id="form-validate">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Validasi Data Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-4">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi!</h5>
                        Apakah Anda ingin memvalidasi prestasi berikut? Status akan diubah menjadi <strong>Valid</strong>.
                    </div>
                    <div class="form-group">
                        <label>Lomba ID</label>
                        <div class="form-control" readonly>{{ $achievement->lomba_id }}</div>
                    </div>
                    <div class="form-group">
                        <label>Tingkat Prestasi</label>
                        <div class="form-control" readonly>{{ $achievement->tingkat_prestasi }}</div>
                    </div>
                    <div class="form-group">
                        <label>Juara Ke</label>
                        <div class="form-control" readonly>{{ $achievement->juara_ke }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Validasi</button>
                </div>
            </div>
        </div>
    </form>
@endisset
<script>
    $(document).ready(function() {
        $("#form-validate").validate({
            rules: {},
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            $('#table-pending-achievements').DataTable().ajax.reload();
                            $('#table-valid-achievements').DataTable().ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
