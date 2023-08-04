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
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <h6 class="fw-semibold">Basic Details</h6>
                        <hr class="mt-0" />
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('name', 'Name',['class' => 'form-label']) }}
                        {{ Form::text('name', '', ['class' => 'form-control bootstrap-maxlength-example', 'placeholder'=>'Name', 'id'=>'name', 'maxlength'=>'70', 'required'] )}}
                        <div class="invalid-feedback"> Please enter name. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('position', 'Position',['class' => 'form-label']) }}
                        {{ Form::text('position', '', ['class' => 'form-control', 'placeholder'=>'Position', 'id'=>'position', 'required'] )}}
                        <div class="invalid-feedback"> Please enter position. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('link', 'Link',['class' => 'form-label']) }}
                        {{ Form::text('link', '', ['class' => 'form-control', 'placeholder'=>'Link', 'id'=>'link'] )}}
                        <div class="invalid-feedback"> Please enter link. </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('message', 'Message',['class' => 'form-label']) }}
                        {{ Form::textarea('message','', ['class'=>'form-control bootstrap-maxlength-example', 'placeholder'=>'Message', 'rows'=>'3' ,'id'=>'message','maxlength'=>'300' ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4 mt-4">
    <div class="nav-align-top">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-image" role="tab" aria-selected="false">Image</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="form-tabs-image" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        <h6 class="fw-semibold">Image</h6>
                        <hr class="mt-0" />
                        <div action="https://demos.themeselection.com/upload" class="dropzone needsclick" id="dropzone1-basic">
                            <div class="dz-message needsclick">
                                Drop files here or click to upload
                            </div>
                            <div class="fallback">
                                <input name="image" type="file" required />
                            </div>
                        </div>
                        <input name="image" type="hidden" class="image_file" required />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="image-upload-url" data-url="{{ route('admin.review.image') }}"></div>
<div class="image-delete-url" data-url="{{ route('admin.review.image.delete') }}"></div>