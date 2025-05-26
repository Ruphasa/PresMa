@extends('layouts.template')
<!-- Content Start -->
@section('content')

    <!-- Dosen Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center position-relative mb-5">
                        <h1 class="display-4">Dosen Dashboard - Competitions</h1>
                        <p class="lead">Lihat daftar lomba yang telah divalidasi dalam sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Valid Competitions Table -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" id="headingValid">
                            <h5 class="mb-0">
                                Valid Competitions
                            </h5>
                        </div>
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
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"></div>
    <!-- Dosen Dashboard End -->
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
</style>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        // Valid Competitions Table
        var tableValid = $('#table-valid-competitions').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            autoWidth: false,
            ajax: {
                url: "{{ url('Dosen/competition/listValid') }}",
                dataType: "json",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                { data: 'kategori_id', orderable: true, searchable: true, width: '10%' },
                { data: 'lomba_tingkat', orderable: true, searchable: true, width: '15%' },
                { data: 'lomba_tanggal', orderable: true, searchable: true, width: '15%' },
                { data: 'lomba_nama', orderable: true, searchable: true, width: '20%' },
                { data: 'lomba_detail', orderable: true, searchable: true, width: '20%' },
                { data: 'action', orderable: false, searchable: false, width: '15%' }
            ],
            order: [[3, 'asc']] // Order by lomba_tanggal
        });

        $(window).on('resize', function () {
            tableValid.columns.adjust().responsive.recalc();
        });
    });
</script>
@endpush