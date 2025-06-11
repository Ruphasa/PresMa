<!-- resources/views/prodi/index.blade.php -->
@extends('layouts.template')
@section('content')
    <div class="container">
        <h1>Halaman Prodi</h1>
        <table id="table-prodi" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prodi</th>
                    <th>Jumlah Mahasiswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#table-prodi').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('prodi.list') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama_prodi', name: 'nama_prodi' },
                { data: 'mahasiswa_count', name: 'mahasiswa_count' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush
