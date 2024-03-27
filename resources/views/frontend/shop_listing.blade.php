@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Models\Category::find($category_id)->meta_title;
        $meta_description = \App\Models\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Models\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Models\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

    <section class="mb-4 pt-4">
        <div class="container sm-px-0 pt-2">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">

                    <!-- Sidebar Filters -->
                    <div class="col-xl-3">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>

                                <!-- Categories -->
                                <div class="bg-white border mb-3">
                                    <div class="fs-16 fw-700 p-3">
                                        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Categories')}}
                                        </a>
                                    </div>
                                    <div class="collapse show" id="collapse_1">
                                        <ul class="p-3 mb-0 list-unstyled">
                                            @if (!isset($category_id))
                                                @foreach (\App\Models\Category::where('level', 0)->get() as $category)
                                                    <li class="mb-3 text-dark">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('sellersByCategory', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="mb-3">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('search') }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ translate('All Categories')}}
                                                    </a>
                                                </li>
                                                @if (\App\Models\Category::find($category_id)->parent_id != 0)
                                                    <li class="mb-3">
                                                        <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('sellersByCategory', \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->slug) }}">
                                                            <i class="las la-angle-left"></i>
                                                            {{ \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="mb-3">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('sellersByCategory', \App\Models\Category::find($category_id)->slug) }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                                                    </a>
                                                </li>
                                                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                    <li class="ml-4 mb-3">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('sellersByCategory', \App\Models\Category::find($id)->slug) }}">{{ \App\Models\Category::find($id)->getTranslation('name') }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contents -->
                    <div class="col-xl-9">

                        <!-- Breadcrumb -->
                        <ul class="breadcrumb bg-transparent py-0 px-1">
                            <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                            </li>
                            <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">{{ translate('Sellers')}}</a>
                            </li>
                            @if(!isset($category_id))
                                <li class="breadcrumb-item fw-700  text-dark">
                                    "{{ translate('All Categories')}}"
                                </li>
                            @else
                                <li class="breadcrumb-item opacity-50 hov-opacity-100">
                                    <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a>
                                </li>
                            @endif
                            @if(isset($category_id))
                                <li class="text-dark fw-600 breadcrumb-item">
                                    "{{ \App\Models\Category::find($category_id)->getTranslation('name') }}"
                                </li>
                            @endif
                        </ul>

                        <!-- Top Filters -->
                        <div class="text-left">
                            <div class="row gutters-5 flex-wrap align-items-center">
                                <div class="col-lg col-10">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                                        @if(isset($category_id))
                                            {{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                                        @else
                                            {{ translate('All Sellers') }}
                                        @endif
                                    </h1>
                                    <input type="hidden" name="keyword" value="{{ $query }}">
                                </div>
                                <div class="col-2 col-lg-auto d-xl-none mb-lg-3 text-right">
                                    <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                        <i class="la la-filter la-2x"></i>
                                    </button>
                                </div>
                                <!-- <div class="col-6 col-lg-auto mb-3 w-lg-200px">
                                    <select class="form-control form-control-sm aiz-selectpicker rounded-0" name="sort_by" onchange="filter()">
                                        <option value="">{{ translate('Sort by')}}</option>
                                        <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                        <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                        <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                        <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                    </select>
                                </div> -->
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="px-3">
                            <section class="mb-3 pb-3">
                                <div class="bg-white px-3">
                                    <div class="row row-cols-xl-3 row-cols-md-3 row-cols-sm-2 row-cols-1 gutters-16 border-top border-left">
                                        @foreach ($shops as $key => $shop)
                                            @if ($shop->user != null)
                                                <div class="col text-center border-right border-bottom has-transition hov-shadow-out z-1">
                                                    <div class="position-relative px-3" style="padding-top: 2rem; padding-bottom:2rem;">
                                                        <!-- Shop logo & Verification Status -->
                                                        <div class="position-relative mx-auto size-100px size-md-120px">
                                                            <a href="{{ route('shop.visit.type', ['slug'=>$shop->slug,'type'=>'all-products']) }}" class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img" tabindex="0" style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                    data-src="{{ uploaded_asset($shop->logo) }}"
                                                                    alt="{{ $shop->name }}"
                                                                    class="img-fit lazyload has-transition"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                            </a>
                                                            <div class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                                @if ($shop->verification_status == 1)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24" viewBox="0 0 24.001 24">
                                                                        <g id="Group_25929" data-name="Group 25929" transform="translate(-480 -345)">
                                                                            <circle id="Ellipse_637" data-name="Ellipse 637" cx="12" cy="12" r="12" transform="translate(480 345)" fill="#fff"/>
                                                                            <g id="Group_25927" data-name="Group 25927" transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5" d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z" transform="translate(0 0)" fill="#3490f3"/>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24" viewBox="0 0 24.001 24">
                                                                        <g id="Group_25929" data-name="Group 25929" transform="translate(-480 -345)">
                                                                            <circle id="Ellipse_637" data-name="Ellipse 637" cx="12" cy="12" r="12" transform="translate(480 345)" fill="#fff"/>
                                                                            <g id="Group_25927" data-name="Group 25927" transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5" d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z" transform="translate(0 0)" fill="red"/>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- Shop name -->
                                                        <h2 class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-4 mb-3">
                                                            <a href="{{ route('shop.visit.type', ['slug'=>$shop->slug,'type'=>'all-products']) }}" class="h6 text-reset hov-text-primary" tabindex="0">
                                                                {{ $shop->name }}
                                                                <br>
                                                                <span class="fs-12 fw-200"> {{ $shop->city->name }}@if($shop->district), {{ $shop->district->name }} @endif</span>
                                                            </a>
                                                        </h2>
                                                        <!-- Shop Rating -->
                                                        <!-- <div class="rating rating-mr-1 text-dark mb-3">
                                                            {{ renderStarRating($shop->rating) }}
                                                            <span class="opacity-60 fs-14">({{ $shop->num_of_reviews }}
                                                                {{ translate('Reviews') }})</span>
                                                        </div> -->
                                                        <!-- Visit Button -->
                                                        <!-- <a href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'all-products']) }}" class="btn-visit">
                                                            <span class="circle" aria-hidden="true">
                                                                <span class="icon arrow"></span>
                                                            </span>
                                                            <span class="button-text">{{ translate('Visit Store') }}</span>
                                                        </a> -->
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- Pagination -->
                                    <div class="aiz-pagination aiz-pagination-center mt-4">
                                        {{ $shops->links() }}
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
@endsection

@section('content')
    <div class="position-relative">
        <div class="position-absolute" id="particles-js"></div>
        <div class="position-relative container">
            <!-- Breadcrumb -->
            <section class="pt-4 mb-3">
                <div class="row">
                    <div class="col-lg-6 text-center text-lg-left">
                        <h1 class="fw-700 fs-20 fs-md-24 text-dark">{{ translate('All Sellers') }}</h1>
                    </div>
                    <div class="col-lg-6">
                        <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                            <li class="breadcrumb-item has-transition opacity-60 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                            </li>
                            <li class="text-dark fw-600 breadcrumb-item">
                                "{{ translate('All Sellers') }}"
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- All Sellers -->
            <section class="mb-3 pb-3">
                <div class="bg-white px-3">
                    <div class="row row-cols-xl-3 row-cols-md-3 row-cols-sm-2 row-cols-1 gutters-16 border-top border-left">
                        @foreach ($shops as $key => $shop)
                            @if ($shop->user != null)
                                <div class="col text-center border-right border-bottom has-transition hov-shadow-out z-1">
                                    <div class="position-relative px-3" style="padding-top: 2rem; padding-bottom:2rem;">
                                        <!-- Shop logo & Verification Status -->
                                        <div class="position-relative mx-auto size-100px size-md-120px">
                                            <a href="{{ route('shop.visit.type', ['slug'=>$shop->slug,'type'=>'all-products']) }}" class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img" tabindex="0" style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                    data-src="{{ uploaded_asset($shop->logo) }}"
                                                    alt="{{ $shop->name }}"
                                                    class="img-fit lazyload has-transition"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                            </a>
                                            <div class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                @if ($shop->verification_status == 1)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24" viewBox="0 0 24.001 24">
                                                        <g id="Group_25929" data-name="Group 25929" transform="translate(-480 -345)">
                                                            <circle id="Ellipse_637" data-name="Ellipse 637" cx="12" cy="12" r="12" transform="translate(480 345)" fill="#fff"/>
                                                            <g id="Group_25927" data-name="Group 25927" transform="translate(480 345)">
                                                            <path id="Union_5" data-name="Union 5" d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z" transform="translate(0 0)" fill="#3490f3"/>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24" viewBox="0 0 24.001 24">
                                                        <g id="Group_25929" data-name="Group 25929" transform="translate(-480 -345)">
                                                            <circle id="Ellipse_637" data-name="Ellipse 637" cx="12" cy="12" r="12" transform="translate(480 345)" fill="#fff"/>
                                                            <g id="Group_25927" data-name="Group 25927" transform="translate(480 345)">
                                                            <path id="Union_5" data-name="Union 5" d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z" transform="translate(0 0)" fill="red"/>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Shop name -->
                                        <h2 class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-4 mb-3">
                                            <a href="{{ route('shop.visit.type', ['slug'=>$shop->slug,'type'=>'all-products']) }}" class="text-reset hov-text-primary" tabindex="0">
                                                {{ $shop->name }}
                                                <br>
                                                <span class="fs-12 fw-200"> {{ $shop->city->name }}@if($shop->district), {{ $shop->district->name }} @endif</span>
                                            </a>
                                        </h2>
                                        <!-- Shop Rating -->
                                        <!-- <div class="rating rating-mr-1 text-dark mb-3">
                                            {{ renderStarRating($shop->rating) }}
                                            <span class="opacity-60 fs-14">({{ $shop->num_of_reviews }}
                                                {{ translate('Reviews') }})</span>
                                        </div> -->
                                        <!-- Visit Button -->
                                        <!-- <a href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'all-products']) }}" class="btn-visit">
                                            <span class="circle" aria-hidden="true">
                                                <span class="icon arrow"></span>
                                            </span>
                                            <span class="button-text">{{ translate('Visit Store') }}</span>
                                        </a> -->
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="aiz-pagination aiz-pagination-center mt-4">
                        {{ $shops->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
