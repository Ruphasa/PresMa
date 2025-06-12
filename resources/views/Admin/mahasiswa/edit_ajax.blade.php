@empty($mahasiswa)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data mahasiswa tidak ditemukan.
                </div>
                <a href="{{ secure_url('/Admin/mahasiswa') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ secure_url('/Admin/mahasiswa/' . $mahasiswa->nim . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIM</label>
                        <input value="{{ $mahasiswa->nim }}" type="text" name="nim" id="nim"
                            class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input value="{{ $mahasiswa->user->nama }}" type="text" name="nama" id="nama"
                            class="form-control">
                        <small id="error-nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $mahasiswa->user->email }}" type="email" name="email" id="email"
                            class="form-control">
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-control" id="prodi_id">
                            @foreach ($prodi as $item)
                                <option value="{{ $item->prodi_id }}"
                                    {{ $item->prodi_id == $mahasiswa->prodi_id ? 'selected' : '' }}>
                                    {{ $item->prodi_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Dosen Pembimbing</label>
                        <select name="dosen_id" class="form-control" id="dosen_id">
                            @foreach ($dosen as $item)
                                <option value="{{ $item->nidn }}"
                                    {{ $item->nidn == $mahasiswa->dosen_id ? 'selected' : '' }}>
                                    {{ $item->user->nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-dosen_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Angkatan</label>
                        <input value="{{ $mahasiswa->angkatan }}" type="text" name="angkatan" id="angkatan"
                            class="form-control">
                        <small id="error-angkatan" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>IPK</label>
                        <input value="{{ $mahasiswa->ipk }}" type="text" name="ipk" id="ipk"
                            class="form-control">
                        <small id="error-ipk" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Preferensi Lomba</label>
                        <select name="prefrensi_lomba" id="prefrensi_lomba" class="form-control">
                            @foreach ($kategori as $item)
                                <option value="{{ $item->kategori_id }}"
                                    {{ $item->kategori_id == $mahasiswa->prefrensi_lomba ? 'selected' : '' }}>
                                    {{ $item->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-prefrensi_lomba" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#form-edit').validate({
                rules: {
                    nama: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    prodi_id: {
                        required: true
                    },
                    dosen_id: {
                        required: true
                    },
                    angkatan: {
                        required: true,
                        digits: true
                    },
                    ipk: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 4
                    },
                    prefrensi_lomba: {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endempty
