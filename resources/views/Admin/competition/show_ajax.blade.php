<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Competition</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            @empty($competition)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @endempty
            @isset($competition)
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $competition->lomba_id }}</td>
                    </tr>
                    <tr>
                        <th>Kategori Competition</th>
                        <td>{{ $competition->kategori->kategori_nama }}</td>
                    <tr>
                        <th>Nama Competition</th>
                        <td>{{ $competition->lomba_nama }}</td>
                    </tr>
                    <tr>
                        <th>Tingkat</th>
                        <td>{{ $competition->lomba_tingkat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Competition</th>
                        <td>{{ $competition->lomba_tanggal }}</td>
                    </tr>
                </table>
                <div id="rekomendasi-section">
                    @if ($rekomendasi->isEmpty())
                        <div>
                            <p>Cari Rekomendasi Mahasiswa ?</p>
                            <button class="btn btn-primary" id="find-recommendations-btn"
                                data-competition-id="{{ $competition->lomba_id }}">Carikan
                                doong~</button>
                        </div>
                    @else
                        @include('partials.rekomendasi_list')
                    @endif
                </div>
            @endisset
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Keluar</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#find-recommendations-btn').on('click', function() {
            var competition_id = $(this).data('competition-id');

            $.ajax({
                url: '/find-recommendations/' + competition_id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.html) {
                        $('#rekomendasi-section').html(data.html);
                    } else if (data.showPopup) {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: data.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    if (response && response.message) {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert('Terjadi kesalahan: '.xhr.responseText);
                    }
                }
            });
        });
    });
</script>
