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
                    <div class="col-md-6 mb-3">
                        {{ Form::label('category', 'Category',['class' => 'form-label']) }}
                        {{ Form::select('category_id[]', $categoryArr,'0', ['class'=>'selectpicker w-100', 'data-style'=>'btn-default', 'data-icon-base'=>'bx', 'data-tick-icon'=>'bx-check text-primary', 'id'=>'category ','multiple']) }}
                        <div class="invalid-feedback"> Please select category </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('tag', 'Tag',['class' => 'form-label']) }}
                        {{ Form::select('tags[]', $tagArr,'0', ['class'=>'selectpicker w-100', 'data-style'=>'btn-default', 'data-icon-base'=>'bx', 'data-tick-icon'=>'bx-check text-primary', 'id'=>'tag ','multiple']) }}
                        <div class="invalid-feedback"> Please select tag </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('short-description', 'Short Description',['class' => 'form-label']) }}
                        {{ Form::textarea('short_description','', ['class'=>'form-control bootstrap-maxlength-example', 'placeholder'=>'Short Description', 'rows'=>'3' ,'id'=>'short-description','maxlength'=>'300' ]) }}
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
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-description" role="tab" aria-selected="false">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-image" role="tab" aria-selected="false">Image</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="form-tabs-description" role="tabpanel">

                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        {{ Form::label('description', 'Description',['class' => 'form-label']) }}
                        {{ Form::textarea('description','', ['class'=>'form-control editor', 'placeholder'=>'Description', 'rows'=>'10' ,'id'=>'description']) }}
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="form-tabs-image" role="tabpanel">
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

<div class="row">
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