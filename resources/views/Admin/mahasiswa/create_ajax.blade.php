<form action="{{ url('Admin/mahasiswa/ajax') }}" method="POST" id="form-tambah-mahasiswa" enctype="multipart/form-data">
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
                    <label>Level</label>
                    <select name="level_id" class="form-control" required>
                        <option value="">Pilih Level</option>
                        @foreach ($level as $lvl)
                            <option value="{{ $lvl->level_id }}">{{ $lvl->level_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
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
                    <label>Program Studi</label>
                    <select name="prodi_id" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach ($prodi as $pr)
                            <option value="{{ $pr->prodi_id }}">{{ $pr->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Dosen ID (NIDN)</label>
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
<script src="{{ secure_asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ secure_asset('js/vendor/jquery.validate.min.js') }}"></script>
<script src="{{ secure_asset('js/vendor/additional-methods.min.js') }}"></script>
<script src="{{ secure_asset('js/vendor/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#form-tambah-mahasiswa").validate({
            rules: {
                nim: {
                    required: true
                },
                // user_id tidak perlu divalidasi di frontend karena dibuat di backend
                prodi_id: {
                    required: true
                },
                dosen_id: {
                    required: true
                },
                level_id: {
                    required: true
                },
                nama: {
                    required: true
                },
                password: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }, // Tambahkan validasi format email
                image: {
                    required: true,
                    accept: "image/*"
                },
            },
            messages: { // Tambahkan custom messages untuk validasi
                nim: {
                    required: "NIM wajib diisi."
                },
                prodi_id: {
                    required: "Program Studi wajib dipilih."
                },
                dosen_id: {
                    required: "Dosen wajib dipilih."
                },
                level_id: {
                    required: "Level wajib dipilih."
                },
                nama: {
                    required: "Nama wajib diisi."
                },
                password: {
                    required: "Password wajib diisi."
                },
                email: {
                    required: "Email wajib diisi.",
                    email: "Format email tidak valid."
                },
                image: {
                    required: "Gambar wajib diunggah.",
                    accept: "Hanya file gambar (jpeg, png, jpg, gif) yang diizinkan."
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal(
                                'hide'
                            ); // Pastikan ID modal Anda benar, misal 'myModal'
                            Swal.fire('Berhasil', response.message, 'success');
                            if (typeof dataMahasiswa !== 'undefined') {
                                dataMahasiswa.ajax.reload(); // reload DataTable
                            }
                        } else {
                            // Clear all previous errors
                            $('.error-text').text('');
                            // Display new errors
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Terjadi kesalahan pada server: ' + xhr
                            .responseText, 'error');
                        console.error("AJAX Error:", status, error, xhr
                            .responseText); // Untuk debug lebih lanjut
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
