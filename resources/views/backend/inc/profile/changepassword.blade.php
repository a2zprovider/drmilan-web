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
<style>
    .invalid-message {
        color: #ff3e1d;
        font-size: 85%;
        margin-top: 0.3rem;
        width: 100%;
    }

    .form-control.is-invalid {
        border-color: #ff3e1d;
    }
</style>
@endsection
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Form::open(['url' => route('admin.user.savepassword'), 'method'=>'POST', 'files' => true, 'class' => 'needs-validation','novalidate']) }}
            <div class="card mb-4 header-sticky">
                <div class="d-flex justify-content-between align-items-center py-3 mb-2 card-body">
                    <h4 class="fw-bold m-0">
                        <span class="text-muted fw-light">Change Password </span>
                    </h4>
                    <div>
                        <button class="btn-primary btn" type="submit">Change Password</button>
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

            <!-- Change Password -->
            <div class="card mb-4">
                <!-- <h5 class="card-header">Change Password</h5> -->
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <h6 class="alert-heading fw-bold mb-1">Ensure that these requirements are met</h6>
                        <span>Minimum 8 characters long, at least one uppercase, one lowercase & one number</span>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                            <label class="form-label" for="newPassword">New Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="newPassword" required name="new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                <div class="invalid-feedback"> Password requirements doesn't match. </div>

                            </div>
                        </div>

                        <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" name="confirm_password" required id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                <div class="invalid-feedback"> Please enter confirm password. </div>

                            </div>
                        </div>
                    </div>
                    <div class="invalid-message"> </div>
                </div>
            </div>
            <!--/ Change Password -->
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

<!-- BEGIN: Page JS-->
<script src="{{ url('admin/js/forms-extras.js') }}"></script>
<script src="{{ url('admin/js/form-validation.js') }}"></script>
<script src="{{ url('admin/js/form-layouts.js') }}"></script>
<!-- END: Page JS-->



@endsection