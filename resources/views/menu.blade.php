@extends('layout')

@section('content')
    <section class="blog_area single-post-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="feature-img">
                            <img class="img-fluid" src="{{ asset('storage/stores/'.$store->cover_image) }}" alt="">
                        </div>
                        <div class="blog_details">
                            <h2>{{ $store->name }}</h2>
                            <p class="excert">{{ $store->description }}</p>
                            <p><i class="fa fa-map-marker"></i> {{ $store->address }}</p>
                            <p><i class="fa fa-phone"></i> {{ $store->phone }}</p>
                        </div>
                    </div>

                    @foreach($store->categories as $category)
                    <div class="single-post">
                        <div class="blog_details">
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $category->description }}</p>
                            
                            <div class="row">
                                @foreach($category->products as $product)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        @if($product->image)
                                        <img src="{{ asset('storage/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ $product->description }}</p>
                                            <p class="card-text">
                                                <strong>Price: ${{ number_format($product->price, 2) }}</strong>
                                            </p>
                                            @if($product->is_available)
                                            <span class="badge badge-success">Available</span>
                                            @else
                                            <span class="badge badge-danger">Not Available</span>
                                            @endif
                                            @if($product->is_featured)
                                            <span class="badge badge-primary">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Categories</h4>
                            <ul class="list cat-list">
                                @foreach($store->categories as $category)
                                <li>
                                    <a href="#{{ Str::slug($category->name) }}" class="d-flex">
                                        <p>{{ $category->name }}</p>
                                        <p>({{ $category->products->count() }})</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection