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
                    <div class="col-md-6 mb-3">
                        {{ Form::label('title', 'Title',['class' => 'form-label']) }}
                        {{ Form::text('title', '', ['class' => 'form-control', 'placeholder'=>'Title', 'id'=>'title', 'required'] )}}
                        <div class="invalid-feedback"> Please enter title. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('slug', 'Slug',['class' => 'form-label']) }}
                        {{ Form::text('slug', '', ['class' => 'form-control', 'placeholder'=>'Slug', 'id'=>'slug'] )}}
                        <div class="invalid-feedback"> Please enter slug. </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('short-description', 'Short Description',['class' => 'form-label']) }}
                        {{ Form::textarea('short_description','', ['class'=>'form-control bootstrap-maxlength-example', 'placeholder'=>'Short Description', 'rows'=>'3' ,'id'=>'short-description','maxlength'=>'300' ]) }}
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('description', 'Description',['class' => 'form-label']) }}
                        {{ Form::textarea('description','', ['class'=>'form-control', 'placeholder'=>'Description', 'rows'=>'3' ,'id'=>'description']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <h6 class="fw-semibold">Meta Details</h6>
                        <hr class="mt-0" />
                    </div>
                    <div class="col-md-12 mb-3"> 
                        {{ Form::label('seo-title', 'Seo Title',['class' => 'form-label']) }}
                        {{ Form::text('seo_title', '', ['class' => 'form-control bootstrap-maxlength-example', 'placeholder'=>'seo-title', 'id'=>'seo-title', 'maxlength'=>'70', 'required'] )}}
                        <div class="invalid-feedback"> Please enter seo title. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('seo_keywords', 'Seo Keywords',['class' => 'form-label']) }}
                        {{ Form::textarea('seo_keywords','', ['class'=>'form-control', 'placeholder'=>'Seo Keywords', 'rows'=>'3' ,'id'=>'seo_keywords', 'required']) }}
                        <div class="invalid-feedback"> Please enter seo keywords. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('seo_description', 'Seo Description',['class' => 'form-label']) }}
                        {{ Form::textarea('seo_description','', ['class'=>'form-control bootstrap-maxlength-example', 'placeholder'=>'Seo Description', 'rows'=>'3', 'required', 'maxlength'=>'250', 'id'=>'seo_description']) }}
                        <div class="invalid-feedback"> Please enter seo description. </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>