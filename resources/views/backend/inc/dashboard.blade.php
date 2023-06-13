@extends('backend.layout.master')
@section('title','Dashboard')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

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
        <div class="row">
            <div class="col-lg-12 col-md-12 order-1">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <span class="d-block fw-semibold mb-1">Doctors</span>   
                                <h3 class="card-title mb-1">{{ @$doctors }}</h3>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <span class="d-block fw-semibold mb-1">Category</span>
                                <h3 class="card-title mb-1">{{ @$categories }}</h3>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <span class="d-block fw-semibold mb-1">Blog</span>
                                <h3 class="card-title mb-1">{{ @$blogs }}</h3>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <span class="d-block fw-semibold mb-1">Blog Category</span>
                                <h3 class="card-title mb-1">{{ @$blogcategories }}</h3>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <span class="d-block fw-semibold mb-1">Tag</span>
                                <h3 class="card-title mb-1">{{ @$tags }}</h3>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <span class="d-block fw-semibold mb-1">Pages</span>
                                <h3 class="card-title mb-1">{{ @$pages }}</h3>
                            </div>
                            <div class="mb-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Statistics -->
            <div class="col-md-5 col-lg-5 col-xl-5 order-0 mb-4">
            </div>
            <!--/ Order Statistics -->
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
<!--/ Content wrapper -->

@endsection
@section('script')

@endsection