@extends('backend.layout.master')
@section('title','Tag Add')
@section('style')

<!-- Vendor Styles -->
<link rel="stylesheet" href="{{ url('admin/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/dropzone/dropzone.css') }}" />

@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Form::open(['url' => route('admin.tag.store'), 'method'=>'POST', 'files' => true, 'class' => 'needs-validation','novalidate']) }}
        <div class="card mb-4 header-sticky">
            <div class="d-flex justify-content-between align-items-center py-3 mb-2 card-body">
                <h4 class="fw-bold m-0">
                    <span class="text-muted fw-light">Tag /</span> Add
                </h4>
                <div>
                    <button class="btn-primary btn" type="reset" style="margin-right: 20px;">Cancel</button>
                    <button class="btn-primary btn" type="submit">Submit</button>
                </div>
            </div>
        </div>
        
        @include('backend.inc.tag._form')

        {{ Form::close() }}


    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
<!--/ Content wrapper -->

@endsection
@section('script')

<script src="{{ url('admin/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ url('admin/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
<script src="{{ url('admin/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ url('admin/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ url('admin/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ url('admin/vendor/libs/tagify/tagify.js') }}"></script>
<script src="{{ url('admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ url('admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ url('admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<script src="{{ url('admin/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ url('admin/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

<script src="{{ url('admin/vendor/libs/dropzone/dropzone.js') }}"></script>
<!-- BEGIN: Page JS-->
<script src="{{ url('admin/js/forms-extras.js') }}"></script>
<script src="{{ url('admin/js/form-validation.js') }}"></script>
<script src="{{ url('admin/js/forms-file-upload.js') }}"></script>
<script src="{{ url('admin/js/form-layouts.js') }}"></script>
<!-- END: Page JS-->


@endsection