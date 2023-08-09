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
                        {{ Form::label('name', 'Name',['class' => 'form-label']) }}
                        {{ Form::text('name', '', ['class' => 'form-control bootstrap-maxlength-example', 'placeholder'=>'Name', 'id'=>'name', 'maxlength'=>'70', 'required'] )}}
                        <div class="invalid-feedback"> Please enter name. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('hospital', 'Hospital',['class' => 'form-label']) }}
                        {{ Form::text('hospital', '', ['class' => 'form-control', 'placeholder'=>'Hospital', 'id'=>'hospital'] )}}
                        <div class="invalid-feedback"> Please enter hospital. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('mobile', 'Mobile',['class' => 'form-label']) }}
                        {{ Form::text('mobile', '', ['class' => 'form-control', 'placeholder'=>'Mobile', 'id'=>'mobile'] )}}
                        <div class="invalid-feedback"> Please enter mobile. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('email', 'Email',['class' => 'form-label']) }}
                        {{ Form::text('email', '', ['class' => 'form-control', 'placeholder'=>'Email', 'id'=>'email'] )}}
                        <div class="invalid-feedback"> Please enter email. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('fees', 'Fees',['class' => 'form-label']) }}
                        {{ Form::text('fees', '', ['class' => 'form-control', 'placeholder'=>'Fees', 'id'=>'fees'] )}}
                        <div class="invalid-feedback"> Please enter fees. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('working_time', 'Working Days & Time',['class' => 'form-label']) }}
                        {{ Form::text('working_time', '', ['class' => 'form-control', 'placeholder'=>'Working Days & Time', 'id'=>'working_time'] )}}
                        <div class="invalid-feedback"> Please enter working time. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('address', 'Address',['class' => 'form-label']) }}
                        {{ Form::text('address', '', ['class' => 'form-control', 'placeholder'=>'Address', 'id'=>'address'] )}}
                        <div class="invalid-feedback"> Please enter address. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('category', 'Category',['class' => 'form-label']) }}
                        {{ Form::select('category_id', $categoryArr,'0', ['class'=>'form-select', 'id'=>'category ']) }}
                        <div class="invalid-feedback"> Please select category </div>
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
            <!-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-description" role="tab" aria-selected="false">Description</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-specification" role="tab" aria-selected="true">Time Slots</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-image" role="tab" aria-selected="false">Image</a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- <div class="tab-pane fade" id="form-tabs-description" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        {{ Form::label('description', 'Description',['class' => 'form-label']) }}
                        {{ Form::textarea('description','', ['class'=>'form-control editor', 'placeholder'=>'Description', 'rows'=>'10' ,'id'=>'description']) }}
                    </div>
                </div>
            </div> -->
            <div class="tab-pane fade active show" id="form-tabs-specification" role="tabpanel">
                @if(!@$doctor->id)
                <div class="mt-3">
                    <div class="container1">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="form-label">From</label>
                                <input type="text" name="field[from][]" class="form-control" placeholder="from">
                                <div class="invalid-feedback"> Please enter field from. </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">To</label>
                                <input type="text" name="field[to][]" class="form-control" placeholder="To">
                                <div class="invalid-feedback"> Please enter field to. </div>
                            </div>
                            <div class="col-md-2 mt-1">
                                <a href="#" class="delete btn btn-label-danger mt-4">
                                    <i class="bx bx-x"></i>
                                    <span class="align-middle">Delete</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="add_form_field btn-primary btn" data-id="1">Add &nbsp;
                        <span style="font-size:16px; font-weight:bold;">+ </span>
                    </div>
                </div>
                @else
                <div class="mt-3">
                    <div class="container1">
                        @php
                        if($doctor->field == null) {
                        $doctor_field = [];
                        }else{
                        $doctor_field = json_decode($doctor->field);
                        }
                        $fields = $doctor_field;
                        @endphp
                        <div class="add_form_field btn-primary btn" data-id="{{ count($fields->to) }}">Add &nbsp;
                            <span style="font-size:16px; font-weight:bold;">+ </span>
                        </div>
                        <hr>
                        @foreach($fields->to as $key => $field)
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="form-label">From</label>
                                <input type="text" name="field[from][]" value="{{ $fields->from[$key] }}" class="form-control" placeholder="From" required>
                                <div class="invalid-feedback"> Please enter field from. </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">To</label>
                                <input type="text" name="field[to][]" value="{{ $field }}" class="form-control" placeholder="To" required>
                                <div class="invalid-feedback"> Please enter field to. </div>
                            </div>
                            <div class="col-md-2 mt-1">
                                <a href="#" class="delete btn btn-label-danger mt-4">
                                    <i class="bx bx-x"></i>
                                    <span class="align-middle">Delete</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="tab-pane fade" id="form-tabs-image" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        <h6 class="fw-semibold">Doctor Image</h6>
                        <hr class="mt-0" />
                        <div action="https://demos.themeselection.com/upload" class="dropzone needsclick" id="dropzone1-basic">
                            <div class="dz-message needsclick">
                                Drop files here or click to upload
                            </div>
                            <div class="fallback">
                                <input name="image" type="file" required />
                            </div>
                        </div>
                        <input name="image" data-validate="true" type="hidden" class="image_file" required />
                        <!-- {{ Form::text('image','', ['class'=>'form-control image_file', 'placeholder'=>'Image','required']) }} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="image-upload-url" data-url="{{ route('admin.doctor.image') }}"></div>
<div class="image-delete-url" data-url="{{ route('admin.doctor.image.delete') }}"></div>
<div class="images-upload-url" data-url="{{ route('admin.doctor.multi.image') }}"></div>
<div class="images-delete-url" data-url="{{ route('admin.doctor.multi.image.delete') }}"></div>