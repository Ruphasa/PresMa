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
    <form action="{{ url('/Admin/competition/' . $competition->lomba_id . '/reject_ajax') }}" method="POST"
        id="form-reject-competition">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tolak Lomba</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menolak lomba seperti di bawah ini? Status akan diubah menjadi
                        <strong>Rejected</strong>. Silakan masukkan alasan penolakan.
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
                    <div class="form-group">
                        <label for="keterangan">Alasan Penolakan:</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                            placeholder="Masukkan alasan penolakan..." required></textarea>
                        <span id="error-keterangan" class="error-text text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-reject-competition").validate({
                rules: {
                    reject_note: {
                        required: true
                    }
                },
                messages: {
                    reject_note: "Alasan penolakan wajib diisi."
                },
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
                                $('#table-pending-competitions').DataTable().ajax.reload();
                                $('#table-valid-competitions').DataTable().ajax.reload();
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
@endempty
