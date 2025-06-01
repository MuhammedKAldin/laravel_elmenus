@extends('layout')

@section('content')
    <!-- video_area_start -->
    <div class="video_area video_bg overlay">
            <div class="video_area_inner text-center">
                <h3>ELMENUS </h3>
                <span>Find The Best Restaurants in Your Town!</span>
                <div class="video_payer">
                    <a href="https://www.youtube.com/watch?v=vLnPwxZdW4Y" class="video_btn popup-video">
                        <i class="fa fa-play"></i>
                    </a>
            </div>
        </div>
    </div>
    <!-- video_area_end -->
     
    <!-- restaurant_header_start -->
    <div class="restaurant_header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="restaurant_header_inner">
                        <div class="restaurant_header_img">
                            <img src="{{ asset('storage/' . $store->cover_image) }}" alt="{{ $store->name }}">
                        </div>
                        <div class="restaurant_header_content">
                            <h1>{{ $store->name }}</h1>
                            <p class="store-description">{{ $store->description }}</p>
                            @if($store->address)
                                <p class="store-address"><i class="fa fa-map-marker"></i> {{ $store->address }}</p>
                            @endif
                            @if($store->phone)
                                <p class="store-phone"><i class="fa fa-phone"></i> {{ $store->phone }}</p>
                            @endif
                            <div class="store-category">
                                <span class="badge badge-primary">{{ $store->category }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- restaurant_header_end -->

    <!-- menu_section_start -->
    <section class="menu_section">
        <div class="container">
            <div class="row">
                <!-- Left Sidebar - Categories and Recent Posts -->
                <div class="col-lg-3">
                    <!-- Categories Sidebar -->
                    <div class="menu_categories">
                        <h3><i class="fa-solid fa-list me-2"></i>Categories</h3>
                        <ul class="category-list">
                            @foreach($store->productCategories as $productCategory)
                                <li>
                                    <a href="#{{ Str::slug($productCategory->name) }}" class="category-link">
                                        <i class="fa-solid fa-utensils me-2"></i>
                                        {{ $productCategory->name }}
                                        <span class="item-count">({{ $productCategory->products->count() }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Posts Sidebar - Hidden on mobile -->
                    <div class="recent_posts d-none d-lg-block mt-4">
                        <h3><i class="fas fa-newspaper me-2"></i>Recent Posts</h3>
                        @if($store->posts->count() > 0)
                            @foreach($store->posts->take(5) as $post)
                                <div class="recent-post mb-3">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('posts.show', ['store' => $store, 'post' => $post]) }}">
                                                <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder.png') }}" 
                                                     class="img-fluid rounded" 
                                                     alt="{{ $post->title }}"
                                                     style="height: 60px; width: 100%; object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="col-8">
                                            <h6 class="mb-1">
                                                <a href="{{ route('posts.show', ['store' => $store, 'post' => $post]) }}" 
                                                   class="text-dark">
                                                    {{ Str::limit($post->title, 30) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                {{ $post->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No posts available.</p>
                        @endif
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-lg-9">
                    <!-- Recent Posts - Visible only on mobile -->
                    <div class="recent_posts_mobile d-lg-none mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-newspaper me-2"></i>Recent Posts</h3>
                                <div class="recent-posts-slider">
                                    @if($store->posts->count() > 0)
                                        @foreach($store->posts->take(5) as $post)
                                            <div class="recent-post-mobile">
                                                <div class="row align-items-center">
                                                    <div class="col-4">
                                                        <a href="{{ route('posts.show', ['store' => $store, 'post' => $post]) }}">
                                                            <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder.png') }}" 
                                                                 class="img-fluid rounded" 
                                                                 alt="{{ $post->title }}"
                                                                 style="height: 80px; width: 100%; object-fit: cover;">
                                                        </a>
                                                    </div>
                                                    <div class="col-8">
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('posts.show', ['store' => $store, 'post' => $post]) }}" 
                                                               class="text-dark">
                                                                {{ Str::limit($post->title, 30) }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ $post->created_at->format('M d, Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No posts available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    @if($store->productCategories->isEmpty())
                        <div class="alert alert-info">No menu items available at the moment.</div>
                    @else
                        @foreach($store->productCategories as $productCategory)
                            <div class="menu_category" id="{{ Str::slug($productCategory->name) }}">
                                <h2 class="category_title">{{ $productCategory->name }}</h2>
                                @if($productCategory->description)
                                    <p class="category-description">{{ $productCategory->description }}</p>
                                @endif
                                <div class="row">
                                    @foreach($productCategory->products as $product)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="menu_item">
                                                <div class="menu_item_img">
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                                    @if($product->is_featured)
                                                        <span class="featured-badge">Featured</span>
                                                    @endif
                                                </div>
                                                <div class="menu_item_content">
                                                    <h3>{{ $product->name }}</h3>
                                                    <p>{{ $product->description }}</p>
                                                    <div class="menu_item_footer">
                                                        <div class="menu_item_price">
                                                            <span class="price">{{ number_format($product->price, 2) }} EGP</span>
                                                        </div>
                                                        @if($product->is_available)
                                                            <button class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                                            </button>
                                                        @else
                                                            <span class="not-available-badge">Not Available</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- menu_section_end -->

    <style>
        .restaurant_header {
            padding: 50px 0;
            background: #f8f9fa;
            margin-bottom: 40px;
        }
        .restaurant_header_inner {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        .restaurant_header_img {
            width: 200px;
            height: 200px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .restaurant_header_img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .restaurant_header_content h1 {
            margin-bottom: 15px;
            color: #333;
            font-size: 2.5em;
        }
        .store-description {
            color: #666;
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        .store-address, .store-phone {
            color: #555;
            margin-bottom: 10px;
        }
        .store-address i, .store-phone i {
            margin-right: 8px;
            color: #e74c3c;
        }
        .store-category {
            margin-top: 15px;
        }
        .badge-primary {
            background-color: #e74c3c;
            padding: 8px 15px;
            font-size: 0.9em;
        }
        .menu_categories {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        .menu_categories h3 {
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .category-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .category-link:hover {
            color: #e74c3c;
        }
        .item-count {
            background: #f8f9fa;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
        }
        .menu_category {
            margin-bottom: 50px;
            scroll-margin-top: 20px;
        }
        .category_title {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            color: #333;
        }
        .category-description {
            color: #666;
            margin-bottom: 30px;
        }
        .menu_item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .menu_item:hover {
            transform: translateY(-5px);
        }
        .menu_item_img {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        .menu_item_img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .featured-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }
        .menu_item_content {
            padding: 20px;
        }
        .menu_item_content h3 {
            margin-bottom: 10px;
            color: #333;
        }
        .menu_item_content p {
            color: #666;
            margin-bottom: 15px;
            min-height: 40px;
        }
        .menu_item_footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        .menu_item_price {
            font-size: 1.2em;
            color: #e74c3c;
            font-weight: bold;
        }
        .add-to-cart-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .add-to-cart-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .add-to-cart-btn i {
            font-size: 1.1em;
        }
        .add-to-cart-btn:active {
            transform: translateY(0);
        }
        .not-available-badge {
            background: #95a5a6;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .recent_posts {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .recent_posts h3 {
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .recent-post {
            transition: transform 0.3s ease;
            padding: 10px;
            border-radius: 8px;
        }
        .recent-post:hover {
            transform: translateX(5px);
            background: #f8f9fa;
        }
        .recent-post a {
            text-decoration: none;
        }
        .recent-post a:hover {
            color: #e74c3c !important;
        }
        .recent_posts_mobile {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .recent_posts_mobile .card-title {
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .recent-post-mobile {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .recent-post-mobile:last-child {
            border-bottom: none;
        }
        .recent-post-mobile:hover {
            background: #f8f9fa;
        }
        @media (max-width: 991px) {
            .restaurant_header_inner {
                flex-direction: column;
                text-align: center;
            }
            .restaurant_header_img {
                margin: 0 auto 20px;
            }
            .menu_categories {
                position: static;
                margin-bottom: 20px;
            }
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            // Smooth scroll to category
            $('.category-link').click(function(e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 100
                }, 500);
            });

            // Add to cart functionality
            $('.add-to-cart-btn').click(function() {
                const productCard = $(this).closest('.menu_item');
                const productId = $(this).data('product-id').toString(); // Convert to string to ensure consistent type
                const productName = productCard.find('h3').text();
                const productPrice = parseFloat(productCard.find('.price').text().replace(' EGP', ''));
                const productImage = productCard.find('.menu_item_img img').attr('src').split('storage/').pop();
                const productDescription = productCard.find('p').text();

                // Get existing cart from localStorage
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Check if product already exists in cart
                const existingItemIndex = cart.findIndex(item => item.id === productId);

                if (existingItemIndex !== -1) {
                    // Increment quantity if item exists
                    cart[existingItemIndex].quantity += 1;
                } else {
                    // Add new item to cart
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        image: productImage,
                        description: productDescription,
                        quantity: 1,
                        addedAt: new Date().toISOString()
                    });
                }

                // Save updated cart to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));

                // Show success message with animation
                const successMessage = $('<div>')
                    .addClass('cart-success-message')
                    .text('Added to cart!')
                    .css({
                        'position': 'fixed',
                        'top': '20px',
                        'right': '20px',
                        'background': '#4CAF50',
                        'color': 'white',
                        'padding': '15px 25px',
                        'border-radius': '5px',
                        'z-index': '1000',
                        'box-shadow': '0 2px 5px rgba(0,0,0,0.2)',
                        'animation': 'slideIn 0.5s ease-out'
                    });

                $('body').append(successMessage);
                setTimeout(() => {
                    successMessage.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 2000);
            });
        });
    </script>
@endsection