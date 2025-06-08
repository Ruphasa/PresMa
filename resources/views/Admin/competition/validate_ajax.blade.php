@empty($competition)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data lomba yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/Admin/competition') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/Admin/competition/' . $competition->lomba_id . '/validate_ajax') }}" method="POST"
        id="form-validate-competition">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Validasi Lomba</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin memvalidasi lomba seperti di bawah ini? Status akan diubah menjadi
                        <strong>Valid</strong>.
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Kategori ID :</th>
                            <td class="col-9">{{ $competition->kategori_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tingkat :</th>
                            <td class="col-9">{{ $competition->lomba_tingkat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal :</th>
                            <td class="col-9">{{ $competition->lomba_tanggal }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama :</th>
                            <td class="col-9">{{ $competition->lomba_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Detail :</th>
                            <td class="col-9">{{ $competition->lomba_detail }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Validasi</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-validate-competition").validate({
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
                                // Reload both tables to reflect the status change
                                if ($.fn.DataTable.isDataTable(
                                        '#table-pending-competitions')) {
                                    $('#table-pending-competitions').DataTable().ajax
                                        .reload();
                                }
                                if ($.fn.DataTable.isDataTable(
                                        '#table-valid-competitions')) {
                                    $('#table-valid-competitions').DataTable().ajax
                                        .reload();
                                }
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
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal memproses permintaan. Silakan coba lagi.'
                            });
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
@endempty
