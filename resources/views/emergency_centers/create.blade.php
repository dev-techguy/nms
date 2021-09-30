@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Emergency Care Centers</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="col-md-12">
                <div class="card">
                        <div class="card-header">
                            <a class="btn btn-success float-right btn-sm" href="{{route('emergency_centers.index')}}">
                                <i class="fa fa-list-ol"></i>
                                Emergency Care Center List
                            </a>
                            <h3>Add Emergency Care Center </h3>

                        </div>
                        <div class="card-body">
                            <form action="{{route("emergency_centers.store")}}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-11" {{ $errors->has('name') ? 'has-error' : '' }}>
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" class="form-control" placeholder="Name" required>
                                        @if($errors->has('name'))
                                            <p class="help-block">
                                                {{ $errors->first('name') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-1" style="padding-top: 30px;">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </section>
        </div>

    </div>
</section>

</div>
@endsection
