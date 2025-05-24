<form action="{{ url('/mahasiswa/ajax') }}" method="POST" id="form-tambah-mahasiswa" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" required>
                    <small id="error-nim" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" required>
                    <small id="error-image" class="error-text form-text text-danger"></small>
                </div>

                    <div class="form-group">
                    <label>Program Studi(prodi_id)</label>
                    <select name="prodi_id" class="form-control" required>
                        <option value="">Pilih Prodi</option>
                        @foreach ($prodi as $d)
                            <option value="{{ $d->prodi_id }}">{{ $d->nama_prodi }} - {{ $d->nidn }}</option>
                        @endforeach
                    </select>
                    <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Dosen(NIDN)</label>
                    <select name="dosen_id" class="form-control" required>
                        <option value="">Pilih Dosen</option>
                        @foreach ($dosen as $d)
                            <option value="{{ $d->nidn }}">{{ $d->nama }} - {{ $d->nidn }}</option>
                        @endforeach
                    </select>
                    <small id="error-dosen_id" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $("#form-tambah-mahasiswa").validate({
            rules: {
                nim: { required: true },
                user_id: { required: true },
                prodi_id: { required: true },
                dosen_id: { required: true },
                level_id: {required: true},
                nama: {required: true},
                password: {required: true},
                email: {required: true },
                image: { required: true, accept: "image/*" }, // Perubahan disini
            },
            submitHandler: function (form) {
                var formData = new FormData(form); // Tambahkan ini
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData, // Dan ubah ini
                    processData: false,  // Tambahkan ini
                    contentType: false,  // Tambahkan ini
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire('Berhasil', response.message, 'success');
                            if (typeof dataMahasiswa !== 'undefined') {
                                dataMahasiswa.ajax.reload(); // reload DataTable
                            }
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
