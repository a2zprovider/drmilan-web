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
                        {{ Form::text('title', '', ['class' => 'form-control bootstrap-maxlength-example', 'placeholder'=>'Title', 'id'=>'title', 'maxlength'=>'70', 'required'] )}}
                        <div class="invalid-feedback"> Please enter title. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('address', 'Address',['class' => 'form-label']) }}
                        {{ Form::text('address', '', ['class' => 'form-control', 'placeholder'=>'Address', 'id'=>'address', 'required'] )}}
                        <div class="invalid-feedback"> Please enter address. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('date', 'Date',['class' => 'form-label']) }}
                        {{ Form::date('date', '', ['class' => 'form-control', 'placeholder'=>'Date', 'id'=>'date'] )}}
                        <div class="invalid-feedback"> Please enter date. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{ Form::label('time', 'Time',['class' => 'form-label']) }}
                        {{ Form::text('time', '', ['class' => 'form-control', 'placeholder'=>'Time', 'id'=>'time'] )}}
                        <div class="invalid-feedback"> Please enter time. </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        {{ Form::label('description', 'Description',['class' => 'form-label']) }}
                        {{ Form::textarea('description','', ['class'=>'form-control', 'placeholder'=>'Description', 'rows'=>'3' ,'id'=>'Description' ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="image-upload-url" data-url="{{ route('admin.event.image') }}"></div>
<div class="image-delete-url" data-url="{{ route('admin.event.image.delete') }}"></div>