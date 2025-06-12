@extends('layouts.template')

@section('content')
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Admin Dashboard</h1>
                        <p class="lead">Manage your content and settings here.</p>
                    </div>
                </div>
            </div>

            <div id="accordion">
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingMahasiswa">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseMahasiswa"
                                        aria-expanded="true" aria-controls="collapseMahasiswa">
                                        Mahasiswa Table
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseMahasiswa" class="collapse show" aria-labelledby="headingMahasiswa"
                                data-parent="#accordion">
                                <div class="card-body">
                                    {{-- Tombol Aksi --}}
                                    <div id="toolbar-mahasiswa" class="d-flex gap-2 mb-3">
                                        <button onclick="modalAction('{{ url('Admin/mahasiswa/create_ajax') }}')"
                                            class="btn btn-success">Tambah Data</button>
                                        <a href="{{ url('Admin/mahasiswa/export_pdf') }}" class="btn btn-primary"
                                            download>Export PDF</a>
                                        <button onclick="modalAction('{{ url('Admin/mahasiswa/import_pdf') }}')"
                                            class="btn btn-info">Import PDF</button>
                                    </div>
                                    {{-- Tabel --}}
                                    <table class="table" id="table-mahasiswa" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Image path</th>
                                                <th>Prodi</th>
                                                <th>Dospem</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingDosen">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseDosen"
                                        aria-expanded="false" aria-controls="collapseDosen">
                                        Dosen Table
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseDosen" class="collapse"aria-labelledby="headingDosen" data-parent="#accordion">
                                <div class="card-body">
                                    {{-- Tombol Aksi --}}
                                    <div id="toolbar-dosen" class="d-flex gap-2 mb-3">
                                        <button onclick="modalAction('{{ url('Admin/dosen/create_ajax') }}')"
                                            class="btn btn-success">Tambah Data</button>
                                        <a href="{{ url('Admin/dosen/export_pdf') }}" class="btn btn-primary"
                                            download>Export PDF</a>
                                        <button onclick="modalAction('{{ url('Admin/dosen/import_pdf') }}')"
                                            class="btn btn-info">Import PDF</button>
                                    </div>

                                    {{-- Tabel --}}
                                    <table class="table" id="table-dosen" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIDN</th>
                                                <th>Nama</th>
                                                <th>Image path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingAdmin">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseAdmin"
                                        aria-expanded="false" aria-controls="collapseAdmin">
                                        Admin Table
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseAdmin" class="collapse" aria-labelledby="headingAdmin"
                                data-parent="#accordion">
                                <div class="card-body">
                                    {{-- Tombol Aksi --}}
                                    <div id="toolbar-admin" class="d-flex gap-2 mb-3">
                                        <button onclick="modalAction('{{ url('Admin/admin/create_ajax') }}')"
                                            class="btn btn-success">Tambah Data</button>
                                        <a href="{{ url('Admin/admin/export_pdf') }}" class="btn btn-primary"
                                            download>Export PDF</a>
                                        <button onclick="modalAction('{{ url('Admin/admin/import_pdf') }}')"
                                            class="btn btn-info">Import PDF</button>
                                    </div>
                                    {{-- Tabel --}}
                                    <table class="table" id="table-admin" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Image path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        $(document).ready(function() {
            // Mahasiswa Table
            $('#table-mahasiswa').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ secure_url('Admin/mahasiswa/list') }}",
                    dataType: "json",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nim',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user.nama',
                        orderable: true,
                        searchable: true
                    }, // Updated to use 'nama'
                    {
                        data: 'user.img',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'prodi.nama_prodi',
                        orderable: true,
                        searchable: true
                    }, // Updated to use 'prodi'
                    {
                        data: 'dosen',
                        orderable: true,
                        searchable: true
                    }, // Updated to use 'dosen'
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Dosen Table
            $('#table-dosen').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ secure_url('Admin/dosen/list') }}",
                    dataType: "json",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nidn',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user.nama',
                        orderable: true,
                        searchable: true
                    }, // Updated to use 'nama'
                    {
                        data: 'user.img',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Admin Table
            $('#table-admin').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ secure_url('Admin/admin/list') }}", // Adjusted endpoint to match convention
                    dataType: "json",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nip',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user.nama',
                        orderable: true,
                        searchable: true
                    }, // Updated to use 'nama'
                    {
                        data: 'user.img',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Ensure DataTables redraw when collapse is shown
            $('[data-toggle="collapse"]').on('click', function() {
                const target = $(this).data('target');
                $(target).on('shown.bs.collapse', function() {
                    $.fn.dataTable.tables({
                        visible: true,
                        api: true
                    }).columns.adjust();
                });
            });
            $(window).on('resize', function() {
                tablePending.columns.adjust().responsive.recalc();
                if (validInitialized) tableValid.columns.adjust().responsive.recalc();
            });
        });
    </script>
@endpush
