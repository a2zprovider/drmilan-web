@extends('backend.layout.master')
@section('title','Slider List')
@section('style')

<!-- Vendor Styles -->
<link rel="stylesheet" href="{{ url('admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<style>
    .dataTables_info {
        padding-left: 20px;
        margin-bottom: 20px;
    }

    .dataTables_length {
        padding-left: 20px;
    }

    .dataTables_filter {
        padding-right: 20px;
    }

    .dataTables_paginate {
        padding-right: 20px;
        margin-bottom: 20px;
    }
</style>
@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="fw-bold m-0">
                    <span class="text-muted fw-light">Slider /</span> View
                </h4>
                <div>
                    <div class="btn-danger btn" id="delete_record" style="margin-right: 20px;"> Delete </div>
                    <a href="{{ route('admin.slider.create') }}" class="btn-primary btn text-white"> Add </a>
                </div>
            </div>
        </div>

        @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(count($errors->all()))
        @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{$error}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
        @endif

        <!-- Select -->
        <div class="card">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!--/ Select -->
    </div>
    <!-- / Content -->
</div>
<!-- / Content wrapper -->

@endsection
@section('script')


<!-- Data Tables -->
<script src="{{ url('admin/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ url('admin/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
<script src="{{ url('admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
<!-- Select -->
<script src="{{ url('admin/vendor/libs/datatables-select/datatables-select.js') }}"></script>
<script src="{{ url('admin/vendor/libs/datatables-select-bs5/select.bootstrap5.js') }}"></script>
<script src="{{ url('admin/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
<!-- / Data Tables -->

<script src="{{ url('admin/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<!-- BEGIN: Page JS-->
<script src="{{ url('admin/js/tables-datatables-extensions.js') }}"></script>
<script src="{{ url('admin/js/extended-ui-sweetalert2.js') }}"></script>
<!-- END: Page JS-->

<script type="text/javascript">
    $(function() {

        var table = $('.data-table').dataTable({
            select: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.slider.index') }}",

            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: 0,
                searchable: !1,
                orderable: !1,
                render: function(data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes form-check-input check" value="' + full.id + '">';
                },
                checkboxes: {
                    selectRow: !0,
                    selectAllRender: '<input type="checkbox" class="form-check-input">'
                },
            }, {
                targets: 1,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }],
            order: [
                [1, "desc"]
            ],
            select: {
                style: "multi"
            },
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Delete record
        $('#delete_record').click(function() {
            var ids_arr = [];
            // Read all checked checkboxes
            $(".data-table tbody tr.selected").each(function() {
                var val = $(this).find('input[type=checkbox]').val();
                ids_arr.push(val);
            });

            // Check checkbox checked or not
            if (ids_arr.length > 0) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Selected records will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin.slider.deleteAll") }}',
                            type: 'post',
                            data: {
                                request: 2,
                                ids_arr: ids_arr
                            },
                            success: function(response) {
                                location.reload();
                            }
                        });
                        Swal.fire('Deleted!', 'Selected records has been deleted successfully!', 'success')
                    }
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Please select at least one record!",
                    icon: "error",
                })
            }
        });
    });

    function handelDelete(id) {
        var url = "{{ route('admin.slider.index') }}";
        url = url + '/' + id;
        Swal.fire({
            title: "Are you sure?",
            text: "This record will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(url);
                var form = $('#deleteFormModal');
                form.attr('action', url)
                form.submit();
                Swal.fire('Deleted!', 'Record has been deleted successfully!', 'success')
            }
        })
    }
</script>

@endsection