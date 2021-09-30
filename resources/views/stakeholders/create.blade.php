@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Stakeholders</h1>
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
                            <a class="btn btn-success float-right btn-sm" href="{{route('stakeholders.index')}}">
                                <i class="fa fa-list-ol"></i>
                                Stakeholder List
                            </a>
                            <h3>Add Stakeholder</h3>

                        </div>
                        <div class="card-body">
                            <form action="{{route("stakeholders.store")}}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6" {{ $errors->has('name') ? 'has-error' : '' }}>
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" class="form-control" placeholder="Name" required>
                                        @if($errors->has('name'))
                                            <p class="help-block">
                                                {{ $errors->first('name') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6" {{ $errors->has('email') ? 'has-error' : '' }}>
                                        <label for="email">Email</label>
                                            <input id="email" name="email" type="email" class="form-control" placeholder="Email" required autocomplete="email">
                                        @if($errors->has('email'))
                                            <p class="help-block">
                                                {{ $errors->first('email') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6" {{ $errors->has('contact') ? 'has-error' : '' }}>
                                        <label for="contact">Contact</label>
                                        <input id="contact" name="contact" type="text" class="form-control" placeholder="Contact" required>
                                        @if($errors->has('contact'))
                                            <p class="help-block">
                                                {{ $errors->first('contact') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6" {{ $errors->has('institution') ? 'has-error' : '' }}>
                                        <label for="institution">Institution</label>
                                        <input id="institution" name="institution"type="text" class="form-control" placeholder="Institution" required>
                                        @if($errors->has('institution'))
                                            <p class="help-block">
                                                {{ $errors->first('institution') }}
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
