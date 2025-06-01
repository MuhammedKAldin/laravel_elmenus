@extends('vendor.layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Edit Post</h3>
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
                        <li><a href="{{route('vendor.posts.index')}}" class='widget_title'>Posts</a></li>
                        <li>/</li>
                        <li><a href="#" class='widget_title section-active'>Edit Post</a></li>
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
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Edit Post</h2>
                        
                        <form action="{{ route('vendor.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Post Title</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $post->title) }}" 
                                       placeholder="Enter post title"
                                       required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" 
                                          name="content" 
                                          rows="6" 
                                          placeholder="Write your post content here..."
                                          required>{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="image" class="form-label">Featured Image</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image"
                                               accept="image/*">
                                        <small class="text-muted">Recommended size: 800x600px. Max file size: 2MB</small>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="image-preview-container text-center">
                                            <div class="preview-wrapper" style="border: 2px dashed #ddd; border-radius: 8px; padding: 10px; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                                <img id="imagePreview" 
                                                     src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder.png') }}" 
                                                     class="img-fluid rounded" 
                                                     alt="Post preview"
                                                     style="max-height: 200px; width: auto; object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="button button-contactForm boxed-btn">Update Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewWrapper = document.querySelector('.preview-wrapper');
    
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Check file size (2MB limit)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size should not exceed 2MB');
                        imageInput.value = '';
                        return;
                    }

                    // Check file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please upload an image file');
                        imageInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewWrapper.style.border = '2px solid #28a745';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '{{ $post->image ? asset("storage/" . $post->image) : asset("img/placeholder.png") }}';
                    previewWrapper.style.border = '2px dashed #ddd';
                }
            });

            // Add drag and drop functionality
            previewWrapper.addEventListener('dragover', function(e) {
                e.preventDefault();
                previewWrapper.style.border = '2px dashed #28a745';
            });

            previewWrapper.addEventListener('dragleave', function(e) {
                e.preventDefault();
                previewWrapper.style.border = '2px dashed #ddd';
            });

            previewWrapper.addEventListener('drop', function(e) {
                e.preventDefault();
                previewWrapper.style.border = '2px dashed #ddd';
                
                const file = e.dataTransfer.files[0];
                if (file) {
                    imageInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            });
        });
    </script>
@endsection 