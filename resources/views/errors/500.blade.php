@extends('frontend.layout.layout')
@section('title', '500 - Server Error')
@section('keywords','500 - Server Error')
@section('description','500 - Server Error')
@section('section')

<!-- Content -->
<div class="page-content">
    <!-- inner page banner -->
    <div class="dlab-bnr-inr overlay-black-dark" style="background-image:url({{url('front/images/banner/bnr1.jpg')}});">
        <div class="container">
            <div class="dlab-bnr-inr-entry">
                <!-- Breadcrumb row -->
                <div class="breadcrumb-row">
                    <ul class="list-inline">
                        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
                        <li>Server Error</li>
                    </ul>
                </div>
                <!-- Breadcrumb row END -->
            </div>
        </div>
    </div>
    <!-- inner page banner END -->
    <!-- inner page banner END -->

    <div class="content-block">
        <div class="section-full content-inner-2">
            <div class="container">
                <div class="error-page text-center">
                    <div class="dz_error">500</div>
                    <div>
                        <h2 class="error-head">The Link You Folowed Probably Broken, or the page has been removed...</h2>
                    </div>
                    <div>
                        <a href="{{ url('/') }}" class="btn radius-xl btn-lg">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content END-->

@stop