@extends('layouts.template')
<!-- Content Start -->
@section('content')

    <!-- Admin Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Admin Dashboard - Prestasi</h1>
                        <p class="lead">Kelola daftar prestasi yang terdaftar dalam sistem.</p>
                    </div>
                </div>
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
        table-layout: auto !important;
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
        // Pending Achievements Table
        var tablePending = $('#table-pending-achievements').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: "{{ url('Admin/achievement/listPending') }}",
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
                { data: 'validate', orderable: false, searchable: false, width: '30%' }
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
                        url: "{{ url('Admin/achievement/listValid') }}",
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
                        { data: 'action', orderable: false, searchable: false, width: '30%' }
                    ],
                    order: [[1, 'asc']]
                });
                validInitialized = true;
            } else {
                tableValid.columns.adjust().responsive.recalc();
            }
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

        // Validation Modal Logic
        window.showValidationModal = function(prestasiId) {
            $('#validationModal').modal('show');
            $('#confirmValidate').off('click').on('click', function() {
                $.ajax({
                    url: '{{ url("prestasi") }}/' + prestasiId + '/validate_ajax',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#validationModal').modal('hide');
                            tablePending.ajax.reload();
                            if (validInitialized) tableValid.ajax.reload();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat memvalidasi prestasi.');
                    }
                });
            });
        };

        // Reject Modal Logic
        window.showRejectModal = function(prestasiId) {
            $('#rejectModal').modal('show');
            $('#confirmReject').off('click').on('click', function() {
                $.ajax({
                    url: '{{ url("prestasi") }}/' + prestasiId + '/reject_ajax',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#rejectModal').modal('hide');
                            tablePending.ajax.reload();
                            if (validInitialized) tableValid.ajax.reload();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat menolak prestasi.');
                    }
                });
            });
        };
    });
</script>
@endpush