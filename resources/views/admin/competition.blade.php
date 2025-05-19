@extends('layouts.template')
<!-- Content Start -->
@section('content')

    <!-- Admin Dashboard Start -->
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
            <div class="row" id="table-competitions-container">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Competition Table</h5>
                            <table class="table" id="table-competitions">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Category</th>
                                        <th>Level</th>
                                        <th>Name</th>
                                        <th>Details</th>
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
    <!-- Admin Dashboard End -->
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#table-competitions').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('Admin/Competition/list') }}",
                dataType: "json",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kategori.kategori_nama', orderable: true, searchable: true },
                { data: 'lomba_tingkat', orderable: true, searchable: true },
                { data: 'lomba_nama', orderable: true, searchable: true },
                { data: 'lomba_detail', orderable: false, searchable: true },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']]
        });
    });
</script>
@endpush