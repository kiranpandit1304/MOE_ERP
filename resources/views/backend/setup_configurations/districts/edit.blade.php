@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('District Information')}}</h5>
</div>

<div class="row">
  <div class="col-lg-8 mx-auto">
      <div class="card">
          <div class="card-body p-0">
              <ul class="nav nav-tabs nav-fill border-light">
    				@foreach (\App\Models\Language::all() as $key => $language)
    					<li class="nav-item">
    						<a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('districts.edit', ['id'=>$district->id, 'lang'=> $language->code] ) }}">
    							<img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
    							<span>{{ $language->name }}</span>
    						</a>
    					</li>
  	            @endforeach
    			</ul>
              <form class="p-4" action="{{ route('districts.update', $district->id) }}" method="POST" enctype="multipart/form-data">
                  <input name="_method" type="hidden" value="PATCH">
                  <input type="hidden" name="lang" value="{{ $lang }}">
                  @csrf
                  <div class="form-group mb-3">
                      <label for="name">{{translate('Name')}}</label>
                      <input type="text" placeholder="{{translate('Name')}}" value="{{ $district->getTranslation('name', $lang) }}" name="name" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label for="city_id">{{translate('City')}}</label>
                      <select class="select2 form-control aiz-selectpicker" name="city_id" data-selected="{{ $district->city_id }}" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                          @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="form-group mb-3">
                      <label for="name">{{translate('Cost')}}</label>
                      <input type="number" min="0" step="0.01" placeholder="{{translate('Cost')}}" name="cost" class="form-control" value="{{ $district->cost }}" required>
                  </div>


                  <div class="form-group mb-3 text-right">
                      <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

@endsection
