@extends('vendor.layout')

@section('content')

    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Vendor Profile</h3>
    </div>
    <!-- bradcam_area_end -->

    <!--================Blog Area =================-->

        <div class="testimonial_area " style="background: #fff;padding: 5px;padding-top: 65px;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 blog_right_sidebar">
                            <ul class="section_title mb-60 post_category_widget text-center" style="display: ruby-text;">
                                <li> <a href="{{route('vendor.profile')}}" class='widget_title' >General</a> </li>
                                <li> / </li>
                                <a href="{{route('vendor.meals')}}" class='widget_title  section-active' >Meals</a> </li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-lg-4">
                    <div class='text-center'>
                        <a class="boxed-btn5" href="{{route('vendor.create')}}" style="padding: 16px 100px; margin-bottom: 15px;"> 
                            Create New Meal
                        </a>
                        <br>
                        <a class="boxed-btn5" href="{{route('vendor.categories.create')}}" style="padding: 16px 100px; margin-bottom: 15px;"> 
                            Create Category
                        </a>
                        <br>
                        <a class="boxed-btn5" href="{{route('vendor.posts.create')}}" style="padding: 16px 100px;"> 
                            Create Post
                        </a>
                    </div>

                    <div class="blog_right_sidebar" style=" padding-top: 30px;">
                        <aside class="single_sidebar_widget post_category_widget">
                            <h3 class="widget_title">Categories</h3>
                            <ul class="list">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="#{{ $category->id }}" class="category-filter" data-category="{{ $category->id }}">
                                            {{ $category->name }}
                                            <span class="badge badge-primary">{{ $category->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                </div>

                <div class="col-lg-8 mb-5 mb-lg-0">

                    <aside class="single_sidebar_widget search_widget">
                        <form action="{{ route('vendor.meals') }}" method="GET" id="searchForm">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input id="searchInput" name="search" type="text" class="form-control" 
                                           placeholder='Search Meals' value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn">
                                Search
                            </button>
                        </form>
                    </aside>

                    <!--================Blog Area =================-->
                    <div class="best_burgers_area">
                        <div class="container">
                            <div id="searchResults" class="row">
                                @if(request('search'))
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4>Search Results for "{{ request('search') }}"</h4>
                                            <a href="{{ route('vendor.meals') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="fa-solid fa-times me-1"></i>Clear Search
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @foreach ($items as $item)
                                    <div class="col-12 mb-4">
                                        <div class="single_delicious d-flex align-items-center">
                                            <div class="thumb">
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                                                     style="width: 236px; height: 236px; object-fit: cover; border-radius: 26%;">
                                            </div>
                                            <div class="info" style="width: 100%;">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h3>{{ $item->name }}</h3>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="category-badge">
                                                                    {{ $item->productCategory->name ?? 'Uncategorized' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <span class="price">Price: {{ number_format($item->price, 2) }} EGP</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container mt-3">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class='description'>{{ $item->description }}</p>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <a class="boxed-btn5" href="{{ route('vendor.meals.show', ['id' => $item->id]) }}" 
                                                               style="padding: 16px 20px;" title="Edit">
                                                                <i class="fa-solid fa-pen-to-square" aria-hidden="true" style="font-size: 22px;"></i>
                                                            </a>
                                                            <a class="boxed-btn5" href="{{ route('vendor.meals.remove', ['id' => $item->id]) }}" 
                                                               style="padding: 16px 20px;" title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this meal?')">
                                                                <i class="fa-solid fa-trash-can" aria-hidden="true" style="font-size: 22px;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <nav class="blog-pagination justify-content-center d-flex">
                        {{ $items->links() }}
                    </nav>

                    </div>
                </div>
            </div>
        </div>

        <style>
            .single_delicious {
                background: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 15px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
            }
            .single_delicious:hover {
                transform: translateY(-5px);
            }
            .badge {
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 0.8em;
            }
            .badge-info {
                background-color: #17a2b8;
                color: white;
            }
            .price {
                font-size: 1.2em;
                color: #e74c3c;
                font-weight: bold;
            }
            .description {
                color: #666;
                margin-bottom: 0;
            }
            .category-filter {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }
            .category-filter:hover {
                color: #e74c3c;
                text-decoration: none;
            }
            .category-badge {
                display: inline-flex;
                align-items: center;
                background-color: #f8f9fa;
                color: #6c757d;
                padding: 4px 8px;
                border-radius: 12px;
                font-size: 0.8rem;
                font-weight: 500;
                border: 1px solid #dee2e6;
                transition: all 0.2s ease;
                font-size: 12px !important;
            }
            .category-badge:hover {
                background-color: #e9ecef;
                border-color: #ced4da;
            }
            .category-badge i {
                font-size: 0.7rem;
                color: #6c757d;
            }
        </style>

        <script>
            $(document).ready(function() {
                // Remove the old AJAX search functionality since we're using GET requests now
                
                // Category filter functionality
                $('.category-filter').click(function(e) {
                    e.preventDefault();
                    var categoryId = $(this).data('category');
                    
                    // Add your category filtering logic here
                    // You can either reload the page with a category parameter
                    // or use AJAX to filter the meals
                });
            });
        </script>
    <!--================Blog Area =================-->
@endsection