@extends('layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>{{ $post->title }}</h3>
    </div>
    <!-- bradcam_area_end -->

    <div class="container mt-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             class="card-img-top" 
                             alt="{{ $post->title }}"
                             style="height: 400px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h1 class="card-title mb-4">{{ $post->title }}</h1>
                        <div class="post-meta mb-4">
                            <span class="text-muted">
                                <i class="fa fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
                            </span>
                            <span class="text-muted ml-3">
                                <i class="fa fa-store"></i> {{ $store->name }}
                            </span>
                        </div>
                        <div class="post-content">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">Recent Posts</h4>
                        @if($recentPosts->count() > 0)
                            @foreach($recentPosts as $recentPost)
                                <div class="recent-post mb-4">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ route('posts.show', ['store' => $store, 'post' => $recentPost]) }}">
                                                <img src="{{ $recentPost->image ? asset('storage/' . $recentPost->image) : asset('img/placeholder.png') }}" 
                                                     class="img-fluid rounded" 
                                                     alt="{{ $recentPost->title }}"
                                                     style="height: 80px; width: 100%; object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="col-8">
                                            <h6 class="mb-1">
                                                <a href="{{ route('posts.show', ['store' => $store, 'post' => $recentPost]) }}" 
                                                   class="text-dark">
                                                    {{ Str::limit($recentPost->title, 40) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                {{ $recentPost->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No recent posts available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .post-content {
            line-height: 1.8;
            font-size: 1.1em;
            color: #333;
        }
        .recent-post:hover {
            transform: translateX(5px);
            transition: transform 0.3s ease;
        }
        .recent-post a {
            text-decoration: none;
        }
        .recent-post a:hover {
            color: #e74c3c !important;
        }
    </style>
@endsection 