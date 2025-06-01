@extends('vendor.layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Posts</h3>
    </div>
    <!-- bradcam_area_end -->

    <div class="testimonial_area" style="background: #fff; padding: 5px; padding-top: 65px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <ul class="section_title mb-60 post_category_widget text-center" style="display: ruby-text;">
                        <li><a href="{{route('vendor.profile')}}" class='widget_title'>General</a></li>
                        <li>/</li>
                        <li><a href="{{route('vendor.meals')}}" class='widget_title'>Meals</a></li>
                        <li>/</li>
                        <li><a href="#" class='widget_title section-active'>Posts</a></li>
                    </ul>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="text-center">
                    <a href="{{ route('vendor.posts.create') }}" class="boxed-btn5" style="padding: 16px 100px;">
                        Create New Post
                    </a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4">Your Posts</h3>
                        
                        @if($posts->count() > 0)
                            <div class="row">
                                @foreach($posts as $post)
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100">
                                            @if($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" 
                                                     class="card-img-top" 
                                                     alt="{{ $post->title }}"
                                                     style="height: 200px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('img/placeholder.png') }}" 
                                                     class="card-img-top" 
                                                     alt="No image"
                                                     style="height: 200px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $post->title }}</h5>
                                                <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                                                    <div class="btn-group">
                                                        <a href="{{ route('vendor.posts.edit', $post) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('vendor.posts.destroy', $post) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No posts found. Create your first post!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 