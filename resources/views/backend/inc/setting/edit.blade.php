@extends('backend.layout.master')
@section('title','General Setting')
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
        {{ Form::open(['url' => route('admin.setting.update'), 'method'=>'POST', 'files' => true, 'class' => 'needs-validation','novalidate']) }}
        <div class="card mb-4 header-sticky">
            <div class="d-flex justify-content-between align-items-center py-3 mb-2 card-body">
                <h4 class="fw-bold m-0">
                    <span class="text-muted fw-light">General Setting /</span> Edit
                </h4>
                <div>
                    <button class="btn-primary btn" type="submit">Update</button>
                </div>
            </div>
        </div>
        
        @include('backend.inc.setting._form')

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
<script src="{{ url('admin/js/form-layouts.js') }}"></script>
<!-- END: Page JS-->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var logo_upload_url = $('.logo-upload-url').data('url');
    var footerlogo_upload_url = $('.footerlogo-upload-url').data('url');
    var favicon_upload_url = $('.favicon-upload-url').data('url');
    const a = '<div class="dz-preview dz-file-preview">\n<div class="dz-details">\n  <div class="dz-thumbnail">\n    <img data-dz-thumbnail>\n    <span class="dz-nopreview">No preview</span>\n    <div class="dz-success-mark"></div>\n    <div class="dz-error-mark"></div>\n    <div class="dz-error-message"><span data-dz-errormessage></span></div>\n    <div class="progress">\n      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>\n    </div>\n  </div>\n  <div class="dz-filename" data-dz-name></div>\n  <div class="dz-size" data-dz-size></div>\n</div>\n</div>';
    var myDropzone = new Dropzone("#dropzone1-basic", {
        previewTemplate: a,
        parallelUploads: 1,
        uploadMultiple: false,
        maxFilesize: 5,
        addRemoveLinks: !0,
        maxFiles: 1,
        acceptedFiles: "image/*",
        removedfile: function(file) {
            console.log('file', file);
            if (file.status != 'error') {
                var logo_name = $('.logo_file').val();
                var logo_delete_url = $('.logo-delete-url').data('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: logo_delete_url,
                    data: {
                        filename: logo_name
                    },
                    success: function(data) {
                        $('.logo_file').val('');
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response) {
            console.log(response);
            if (file.status != 'error') {
                var formData = new FormData();
                formData.append('image', file);
                $.ajax({
                    type: 'POST',
                    url: logo_upload_url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('.logo_file').val(data.success);
                        file.previewElement.classList.add("dz-success");

                        file.previewElement.id = data.success;
                        var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                        file.previewElement.querySelector("img").alt = data.success;
                        olddatadzname.innerHTML = data.success;

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        },
    });
    var myDropzone2 = new Dropzone("#dropzone3-basic", {
        previewTemplate: a,
        parallelUploads: 1,
        uploadMultiple: false,
        maxFilesize: 5,
        addRemoveLinks: !0,
        maxFiles: 1,
        acceptedFiles: "image/*",
        removedfile: function(file) {
            console.log('file', file);
            if (file.status != 'error') {
                var footerlogo_name = $('.footerlogo_file').val();
                var footerlogo_delete_url = $('.footerlogo-delete-url').data('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: footerlogo_delete_url,
                    data: {
                        filename: footerlogo_name
                    },
                    success: function(data) {
                        $('.footerlogo_file').val('');
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response) {
            console.log(response);
            if (file.status != 'error') {
                var formData = new FormData();
                formData.append('image', file);
                $.ajax({
                    type: 'POST',
                    url: footerlogo_upload_url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('.footerlogo_file').val(data.success);
                        file.previewElement.classList.add("dz-success");

                        file.previewElement.id = data.success;
                        var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                        file.previewElement.querySelector("img").alt = data.success;
                        olddatadzname.innerHTML = data.success;

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        },
    });

    var myDropzone1 = new Dropzone(".dropzone2-basic", {
        previewTemplate: a,
        parallelUploads: 1,
        uploadMultiple: false,
        maxFilesize: 5,
        addRemoveLinks: !0,
        maxFiles: 1,
        acceptedFiles: "image/*",
        removedfile: function(file) {
            console.log('file', file);
            if (file.status != 'error') {
                var favicon_name = $('.favicon_file').val();
                var favicon_delete_url = $('.favicon-delete-url').data('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: favicon_delete_url,
                    data: {
                        filename: favicon_name
                    },
                    success: function(data) {
                        $('.favicon_file').val('');
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response) {
            console.log(response);
            if (file.status != 'error') {
                var formData = new FormData();
                formData.append('image', file);
                $.ajax({
                    type: 'POST',
                    url: favicon_upload_url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('.favicon_file').val(data.success);
                        file.previewElement.classList.add("dz-success");

                        file.previewElement.id = data.success;
                        var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                        file.previewElement.querySelector("img").alt = data.success;
                        olddatadzname.innerHTML = data.success;

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        },
    });
</script>

@if($setting->logo)
<script>
    var mockFile = {
        name: "{{ $setting->logo }}",
        size: "2"
    };
    myDropzone.emit("addedfile", mockFile);
    myDropzone.emit("thumbnail", mockFile, "{{ url('images/setting/' . $setting->logo) }}");
    myDropzone.emit("complete", mockFile);
    $('.logo_file').val('{{ $setting->logo }}')
</script>
@endif
@if($setting->footerlogo)
<script>
    var mockFile2 = {
        name: "{{ $setting->footerlogo }}",
        size: "2"
    };
    myDropzone2.emit("addedfile", mockFile2);
    myDropzone2.emit("thumbnail", mockFile2, "{{ url('images/setting/' . $setting->footerlogo) }}");
    myDropzone2.emit("complete", mockFile2);
    $('.footerlogo_file').val('{{ $setting->footerlogo }}')
</script>
@endif
@if($setting->favicon)
<script>
    var mockFile1 = {
        name: "{{ $setting->favicon }}",
        size: "2"
    };
    myDropzone1.emit("addedfile", mockFile1);
    myDropzone1.emit("thumbnail", mockFile1, "{{ url('images/setting/' . $setting->favicon) }}");
    myDropzone1.emit("complete", mockFile1);
    $('.favicon_file').val('{{ $setting->favicon }}')
</script>
@endif

@endsection