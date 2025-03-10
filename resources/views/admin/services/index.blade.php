@extends('admin.layout.app')
@section('title', 'Services')
@section('content-admin')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title-5 m-b-10">Services</h3>
                <div class="table-data__tool text-right">
                    <div class="table-data__tool-right">
                        <a class="au-btn au-btn-icon au-btn--blue au-btn--small text-white"
                            href="{{ route('services.create') }}">
                            <i class="zmdi zmdi-plus"></i>Add Service
                        </a>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2" id="services-table">
                        <thead>
                            <tr>
                                <th>no</th>
                                <th>category</th>
                                <th>name</th>
                                <th>slug</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var table = $('#services-table').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                searching: false,
                ajax: '{{ route('services.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
