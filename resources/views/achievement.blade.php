@extends('layouts.template')
<!-- Content Start -->
@section('content')
    <!-- Admin Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row" id="table-achievements-container">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Achievement Table</h5>
                            <table class="table" id="table-achievements">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Lomba</th>
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
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"></div>
    <!-- Admin Dashboard End -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#table-achievements').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('Dosen/achievement/list') }}",
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
                        data: 'lomba.lomba_nama',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'tingkat_prestasi',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'juara_ke',
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
        });
    </script>
@endpush
