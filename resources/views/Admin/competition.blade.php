@extends('layouts.template')
<!-- Content Start -->
@section('content')
    <!-- Admin Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Admin Dashboard - Competitions</h1>
                        <p class="lead">Kelola daftar lomba yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Accordion Container -->
            <div id="accordion">
                <!-- Pending Competitions Table (Collapsible) -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingPending">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapsePending"
                                        aria-expanded="true" aria-controls="collapsePending">
                                        Pending Competitions
                                    </button>
                                </h5>
                            </div>
                            <div id="collapsePending" class="collapse show" aria-labelledby="headingPending"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table" id="table-pending-competitions">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kategori ID</th>
                                                <th>Tingkat</th>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>Detail</th>
                                                <th>Validate</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valid Competitions Table (Collapsible) -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingValid">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseValid"
                                        aria-expanded="false" aria-controls="collapseValid">
                                        Valid Competitions
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseValid" class="collapse" aria-labelledby="headingValid"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table" id="table-valid-competitions">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kategori ID</th>
                                                <th>Tingkat</th>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>Detail</th>
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
        data-keyboard="false" data-width="75%" aria-hidden="true"></div> <!-- Admin Dashboard End -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Modal Action Function
            window.modalAction = function(url) {
                $('#myModal').html(''); // Bersihkan semua konten lama
                $('#myModal').load(url, function() {
                    $('#myModal').modal('show'); // Tampilkan modal setelah konten dimuat
                    $('#myModal').data('url', url); // Simpan URL untuk keperluan POST
                });
            };

            // Pending Competitions Table
            var tablePending;
            tablePending = $('#table-pending-competitions').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                autoWidth: false,
                ajax: {
                    url: "{{ url('Admin/competition/listPending') }}",
                    dataType: "json",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'kategori_id',
                        orderable: true,
                        searchable: true,
                        width: '10%'
                    },
                    {
                        data: 'lomba_tingkat',
                        orderable: true,
                        searchable: true,
                        width: '15%'
                    },
                    {
                        data: 'lomba_tanggal',
                        orderable: true,
                        searchable: true,
                        width: '15%'
                    },
                    {
                        data: 'lomba_nama',
                        orderable: true,
                        searchable: true,
                        width: '20%'
                    },
                    {
                        data: 'lomba_detail',
                        orderable: true,
                        searchable: true,
                        width: '20%'
                    },
                    {
                        data: 'validate',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    }
                ],
                order: [
                    [3, 'asc']
                ]
            });

            // Valid Competitions Table
            var tableValid;
            var validInitialized = false;
            $('#collapseValid').on('shown.bs.collapse', function() {
                if (!validInitialized) {
                    tableValid = $('#table-valid-competitions').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        scrollX: true,
                        autoWidth: false,
                        ajax: {
                            url: "{{ url('Admin/competition/listValid') }}",
                            dataType: "json",
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                width: '5%'
                            },
                            {
                                data: 'kategori_id',
                                orderable: true,
                                searchable: true,
                                width: '10%'
                            },
                            {
                                data: 'lomba_tingkat',
                                orderable: true,
                                searchable: true,
                                width: '15%'
                            },
                            {
                                data: 'lomba_tanggal',
                                orderable: true,
                                searchable: true,
                                width: '15%'
                            },
                            {
                                data: 'lomba_nama',
                                orderable: true,
                                searchable: true,
                                width: '20%'
                            },
                            {
                                data: 'lomba_detail',
                                orderable: true,
                                searchable: true,
                                width: '20%'
                            },
                            {
                                data: 'action',
                                orderable: false,
                                searchable: false,
                                width: '15%'
                            }
                        ],
                        order: [
                            [3, 'asc']
                        ]
                    });
                    validInitialized = true;
                } else {
                    tableValid.columns.adjust().responsive.recalc();
                }
            });

            $('#collapseValid').on('hidden.bs.collapse', function() {
                if (validInitialized) {
                    tableValid.columns.adjust().responsive.recalc();
                }
            });

            $(window).on('resize', function() {
                tablePending.columns.adjust().responsive.recalc();
                if (validInitialized) tableValid.columns.adjust().responsive.recalc();
            });
        });
    </script>
@endpush
