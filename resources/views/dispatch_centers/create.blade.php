@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dispatch Centers</h1>
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
                                <a class="btn btn-success float-right btn-sm" href="{{route('dispatch_centers.index')}}">
                                    <i class="fa fa-list-ol"></i>
                                    Dispatch Centers List
                                </a>
                                <h3>Add Dispatch Center </h3>

                            </div>
                            <div class="card-body">
                                <form action="{{route("dispatch_centers.store")}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4" {{ $errors->has('emergency_center_id') ? 'has-error' : '' }}>
                                            <label for="emergency_center_id">Emergency Care Center</label>
                                            <select class="form-control select2" id="emergency_center_id" name="emergency_center_id" required>
                                                <option value="">-- Select Emergency Care Center --</option>
                                                @foreach($data as $key => $ecc)
                                                <option value="{{$ecc->id}}">{{$ecc->name}}</option>
                                                @endforeach

                                            </select>
                                            @if($errors->has('emergency_center_id'))
                                                <p class="help-block">
                                                    {{ $errors->first('emergency_center_id') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('contact') ? 'has-error' : '' }}>
                                            <label for="contact">Contact</label>
                                            <input id="contact" name="contact" type="text" class="form-control" required>
                                            @if($errors->has('contact'))
                                                <p class="help-block">
                                                    {{ $errors->first('contact') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('open_whole_day') ? 'has-error' : '' }}>
                                            <label for="open_whole_day">Open whole day</label>
                                            <select class="form-control" id="open_whole_day" name="open_whole_day" required>
                                                <option value="">-- Select --</option>
                                                <option value="Yes" >Yes</option>
                                                <option value="No" >No</option>
                                            </select>
                                            @if($errors->has('open_whole_day'))
                                                <p class="help-block">
                                                    {{ $errors->first('open_whole_day') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('open_late_night') ? 'has-error' : '' }}>
                                            <label for="open_late_night">Open late night</label>
                                            <select class="form-control" id="open_late_night" name="open_late_night" required>
                                                <option value="">-- Select --</option>
                                                <option value="Yes" >Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            @if($errors->has('open_late_night'))
                                                <p class="help-block">
                                                    {{ $errors->first('open_late_night') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('open_weekends') ? 'has-error' : '' }}>
                                            <label for="open_weekends">Open on weekends</label>
                                            <select class="form-control" id="open_weekends" name="open_weekends" required>
                                                <option value="">-- Select --</option>
                                                <option value="Yes" >Yes</option>
                                                <option value="No" >No</option>
                                            </select>
                                            @if($errors->has('open_weekends'))
                                                <p class="help-block">
                                                    {{ $errors->first('open_weekends') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('open_public_holiday') ? 'has-error' : '' }}>
                                            <label for="open_public_holiday">Open on public holiday</label>
                                            <select class="form-control" id="open_public_holiday" name="open_public_holiday" required>
                                                <option value="">-- Select --</option>
                                                <option value="Yes" >Yes</option>
                                                <option value="No" >No</option>
                                            </select>
                                            @if($errors->has('open_public_holiday'))
                                                <p class="help-block">
                                                    {{ $errors->first('open_public_holiday') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('county') ? 'has-error' : '' }}>
                                            <label for="county">County</label>
                                            <input id="county" name="county" type="text" class="form-control"  required>
                                            @if($errors->has('county'))
                                                <p class="help-block">
                                                    {{ $errors->first('county') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('sub_county') ? 'has-error' : '' }}>
                                            <label for="sub_county">Sub County</label>
                                            <input id="sub_county" name="sub_county" type="text" class="form-control"  required>
                                            @if($errors->has('sub_county'))
                                                <p class="help-block">
                                                    {{ $errors->first('sub_county') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('constituency') ? 'has-error' : '' }}>
                                            <label for="constituency">Constituency</label>
                                            <input id="constituency" name="constituency" type="text" class="form-control"  required>
                                            @if($errors->has('constituency'))
                                                <p class="help-block">
                                                    {{ $errors->first('constituency') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4" {{ $errors->has('ward') ? 'has-error' : '' }}>
                                            <label for="ward">Ward</label>
                                            <input id="ward" name="ward" type="text" class="form-control"  required>
                                            @if($errors->has('ward'))
                                                <p class="help-block">
                                                    {{ $errors->first('ward') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-5" {{ $errors->has('location') ? 'has-error' : '' }}>
                                            <label for="location map-input">Physical Address</label>
                                            <input id="location" name="location" type="text" class="form-control" required>
                                            
                                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') ?? '0' }}"/>
                                            
                                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') ?? '0' }}"/>
                                            @if($errors->has('location'))
                                                <p class="help-block">
                                                    {{ $errors->first('location') }}
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

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>
    <script src="{{ asset('js/mapInput.js')}}"></script>
@endsection

