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
                        {{ Form::label('mobile', 'Mobile',['class' => 'form-label']) }}
                        {{ Form::tel('mobile', '', ['class' => 'form-control', 'placeholder'=>'Mobile', 'id'=>'mobile', 'required'] )}}
                        <div class="invalid-feedback"> Please enter mobile. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('email', 'Email',['class' => 'form-label']) }}
                        {{ Form::email('email', '', ['class' => 'form-control', 'placeholder'=>'Email', 'id'=>'email', 'required'] )}}
                        <div class="invalid-feedback"> Please enter email. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('address', 'Address',['class' => 'form-label']) }}
                        {{ Form::text('address', '', ['class' => 'form-control', 'placeholder'=>'Address', 'id'=>'address', 'required'] )}}
                        <div class="invalid-feedback"> Please enter address. </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('description', 'Description',['class' => 'form-label']) }}
                        {{ Form::textarea('description','', ['class'=>'form-control', 'placeholder'=>'Description', 'rows'=>'3' ,'id'=>'Description','maxlength'=>'300' ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="image-upload-url" data-url="{{ route('admin.lab.image') }}"></div>
<div class="image-delete-url" data-url="{{ route('admin.lab.image.delete') }}"></div>