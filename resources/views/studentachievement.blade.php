@extends('layouts.template')
<!-- Content Start -->
@section('content')

    <!-- Admin Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Prestasi Kamu</h1>
                        <p class="lead">Lihat status dari prestasi kamu.</p>
                    </div>
                </div>
            </div>

            <div class="btn">
                <button class="btn btn-primary" onclick="modalAction('{{ url('') }}')">
                    Tambah Prestasi
                </button>
            </div>
            <!-- Accordion Container -->
            <div id="accordion">
                <!-- Pending Achievements Table (Collapsible) -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingPending">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapsePending" aria-expanded="true" aria-controls="collapsePending">
                                        Pending Achievements
                                    </button>
                                </h5>
                            </div>
                            <div id="collapsePending" class="collapse show" aria-labelledby="headingPending" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table" id="table-pending-achievements">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Lomba ID</th>
                                                <th>Tingkat Prestasi</th>
                                                <th>Juara Ke</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                
                <!-- Valid Achievements Table (Collapsible) -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingReject">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseReject" aria-expanded="false" aria-controls="collapseReject">
                                        Rejected Achievements
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseReject" class="collapse" aria-labelledby="headingReject" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table" id="table-reject-achievements">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Lomba ID</th>
                                                <th>Tingkat Prestasi</th>
                                                <th>Juara Ke</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valid Achievements Table (Collapsible) -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" id="headingValid">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseValid" aria-expanded="false" aria-controls="collapseValid">
                                        Valid Achievements
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseValid" class="collapse" aria-labelledby="headingValid" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table" id="table-valid-achievements">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Lomba ID</th>
                                                <th>Tingkat Prestasi</th>
                                                <th>Juara Ke</th>
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

    <!-- Modal Container -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"></div>
    <!-- Admin Dashboard End -->
@endsection

@push('css')
<style>
    .card-body {
        padding: 1.25rem !important;
        width: 100% !important;
    }
    .card-body .table {
        width: 100% !important;
        table-layout: auto- !important;
        min-width: 100% !important;
    }
    .dataTables_wrapper {
        width: 100% !important;
        min-width: 100% !important;
    }
    .collapse.show {
        display: block !important;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        // Modal Action Function
        window.modalAction = function(url) {
            $('#myModal').modal('show').find('.modal-content').remove(); // Clear previous content
            $('#myModal').append('<div class="modal-content"></div>'); // Add new modal-content div
            $('#myModal .modal-content').load(url, function() {
                // Store the URL for the POST request in the modal's data attribute
                $('#myModal').data('url', url);
            });
        };

        // Pending Achievements Table
        var tablePending = $('#table-pending-achievements').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: "{{ url('student/achievement/listPending') }}",
                dataType: "json",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                { data: 'lomba_id', orderable: true, searchable: true, width: '20%' },
                { data: 'tingkat_prestasi', orderable: true, searchable: true, width: '25%' },
                { data: 'juara_ke', orderable: true, searchable: true, width: '20%' },
            ],
            order: [[1, 'asc']]
        });

        // Valid Achievements Table
        var tableValid;
        var validInitialized = false;
        $('#collapseValid').on('shown.bs.collapse', function () {
            if (!validInitialized) {
                tableValid = $('#table-valid-achievements').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    scrollX: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ url('student/achievement/listValid') }}",
                        dataType: "json",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                        { data: 'lomba_id', orderable: true, searchable: true, width: '20%' },
                        { data: 'tingkat_prestasi', orderable: true, searchable: true, width: '25%' },
                        { data: 'juara_ke', orderable: true, searchable: true, width: '20%' },
                    ],
                    order: [[1, 'asc']]
                });
                validInitialized = true;
            } else {
                tableValid.columns.adjust().responsive.recalc();
            }
        });

        //Rejected Achievements Table
        var tableReject = $('#table-reject-achievements').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            autoWidth: true,
            ajax: {
                url: "{{ url('student/achievement/listReject') }}",
                dataType: "json",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                { data: 'lomba_id', orderable: true, searchable: true, width: '20%' },
                { data: 'tingkat_prestasi', orderable: true, searchable: true, width: '25%' },
                { data: 'juara_ke', orderable: true, searchable: true, width: '20%' },
            ],
            order: [[1, 'asc']]
        });

        $('#collapseValid').on('hidden.bs.collapse', function () {
            if (validInitialized) {
                tableValid.columns.adjust().responsive.recalc();
            }
        });

        $(window).on('resize', function () {
            tablePending.columns.adjust().responsive.recalc();
            if (validInitialized) tableValid.columns.adjust().responsive.recalc();
        });
    });
</script>
@endpush
