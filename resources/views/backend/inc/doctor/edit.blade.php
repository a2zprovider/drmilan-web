@extends('backend.layout.master')
@section('title','Doctor Edit')
@section('style')

<!-- Vendor Styles -->
<link rel="stylesheet" href="{{ url('admin/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ url('admin/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
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
        {{ Form::open(['url' => route('admin.doctor.update',$page->id), 'method'=>'PUT', 'files' => true, 'class' => 'needs-validation','novalidate']) }}
        <div class="card mb-4 header-sticky">
            <div class="d-flex justify-content-between align-items-center py-3 mb-2 card-body">
                <h4 class="fw-bold m-0">
                    <span class="text-muted fw-light">Doctor /</span> Edit
                </h4>
                <div>
                    <a href="{{ route('admin.doctor.index') }}" class="btn-primary btn" type="reset" style="margin-right: 20px;">Cancel</a>
                    <button class="btn-primary btn" type="submit">Update</button>
                </div>
            </div>
        </div>

        @include('backend.inc.doctor._form')

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
<script src="{{ url('admin/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ url('admin/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
<script src="{{ url('admin/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

<script src="{{ url('admin/vendor/libs/dropzone/dropzone.js') }}"></script>
<!-- BEGIN: Page JS-->
<script src="{{ url('admin/js/forms-extras.js') }}"></script>
<script src="{{ url('admin/js/form-validation.js') }}"></script>
<script src="{{ url('admin/js/form-layouts.js') }}"></script>
<!-- END: Page JS-->

<script>
    $('form').submit(function() {
        let e = $('.was-validated .form-control:invalid').first();
        e.focus();
        e.parents('.tab-pane').siblings().removeClass('active show');
        e.parents('.tab-pane').addClass('active show');
        let id_name = e.parents('.tab-pane').attr('id');
        let a = $(this).find(".nav.nav-tabs .nav-item a.nav-link[data-bs-target='#" + id_name + "']");
        $(this).find(".nav.nav-tabs .nav-item a.nav-link").removeClass('active');
        a.addClass('active');
        $(this).find(".form-check-input:invalid").focus();
    });
    $(document).ready(function() {
        var max_fields = 30;
        var wrapper = $(".container1");
        var add_button = $(".add_form_field");
        var val = $(".add_form_field").data('id');

        var x = val - 1;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append(`<div class="row mt-3"><div class="col-md-5"> <label class="form-label">To</label><input type="text" name="field[to][]" class="form-control"  placeholder="To" required><div class="invalid-feedback"> Please enter field to. </div></div><div class="col-md-5"> <label class="form-label">From</label><input type="text" name="field[from][]" required class="form-control"  placeholder="From"><div class="invalid-feedback"> Please enter field from. </div></div><div class="col-md-2 mt-1"><a href="#" class="delete btn btn-label-danger mt-4"><i class="bx bx-x"></i><span class="align-middle">Delete</span></a></div></div>`); //add input box

            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove();
            x--;
        })
    });
</script>

<script>
    $(document).ready(function() {
        var max_fields = 30;
        var wrapper1 = $(".container2");
        var add_button1 = $(".add_form_field1");
        var val1 = $(".add_form_field1").data('id');

        var x1 = val1 - 1;
        $(add_button1).click(function(e) {
            e.preventDefault();
            if (x1 < max_fields) {
                x1++;
                $(wrapper1).append(`<div class="row mt-3"><div class="col-md-5"> <label class="form-label">To</label><input type="text" name="field1[to][]" class="form-control"  placeholder="To" required><div class="invalid-feedback"> Please enter field to. </div></div><div class="col-md-5"> <label class="form-label">From</label><input type="text" name="field1[from][]" required class="form-control"  placeholder="From"><div class="invalid-feedback"> Please enter field from. </div></div><div class="col-md-2 mt-1"><a href="#" class="delete btn btn-label-danger mt-4"><i class="bx bx-x"></i><span class="align-middle">Delete</span></a></div></div>`); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper1).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove();
            x1--;
        })
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var upload_url = $('.image-upload-url').data('url');
    var multi_upload_url = $('.images-upload-url').data('url');
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
            if (file.status != 'error') {
                var name = $('.image_file').val();
                var delete_url = $('.image-delete-url').data('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: delete_url,
                    data: {
                        filename: name
                    },
                    success: function(data) {
                        $('.image_file').val('');
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
            if (file.status != 'error') {
                var formData = new FormData();
                formData.append('image', file);
                $.ajax({
                    type: 'POST',
                    url: upload_url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('.image_file').val(data.success);
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
    var myDropzone1 = new Dropzone(".dropzone-multi", {
        previewTemplate: a,
        uploadMultiple: true,
        maxFilesize: 5,
        addRemoveLinks: !0,
        acceptedFiles: "image/*",
        removedfile: function(file) {
            if (file.status != 'error') {
                let imgArr = $('.images_file').val();
                if (imgArr == '') {
                    imgArr = [];
                } else {
                    imgArr = imgArr.split(',');
                }
                let filterArr = imgArr.filter(checkFilter);

                function checkFilter(name) {
                    return name != file.name;
                }
                var multi_delete_url = $('.images-delete-url').data('url');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: multi_delete_url,
                    data: {
                        filename: file.name
                    },
                    success: function(data) {
                        $('.images_file').val(filterArr);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
            var fileRef;
            return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response) {
            if (file.status != 'error') {
                var formData = new FormData();
                formData.append('image', file);
                $.ajax({
                    type: 'POST',
                    url: multi_upload_url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        let imgArr = $('.images_file').val();
                        if (imgArr == '') {
                            imgArr = [];
                        } else {
                            imgArr = imgArr.split(',');
                        }
                        imgArr[imgArr.length] = data.success;
                        $('.images_file').val(imgArr);
                        file.previewElement.classList.add("dz-success");
                        file.name = data.success;
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

@if($page->image)
<script>
    var mockFile = {
        name: "{{ $page->image }}",
        size: "2"
    };
    myDropzone.emit("addedfile", mockFile);
    myDropzone.emit("thumbnail", mockFile, "{{ url('images/doctor/' . $page->image) }}");
    myDropzone.emit("complete", mockFile);
    $('.image_file').val('{{ $page->image }}')
</script>
@endif

@if($page->images)
<script>
    const images = "{{ $page->images }}";
    let imagesArr = images.split(',');
    imagesArr.forEach(showImages);

    function showImages(item, index) {
        var mockFile = {
            name: item,
            size: "2"
        };
        myDropzone1.emit("addedfile", mockFile);
        let url = "images/doctor/imgs/" + item;
        if (window.location.host == 'localhost') {
            url = window.location.origin + '/furniture/' + url;
        } else {
            url = window.location.origin + '/' + url;
        }
        myDropzone1.emit("thumbnail", mockFile, url);
        myDropzone1.emit("complete", mockFile);
    }
    $('.images_file').val('{{ $page->images }}')
</script>
@endif

@endsection