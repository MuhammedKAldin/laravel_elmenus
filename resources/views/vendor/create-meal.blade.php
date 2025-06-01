@extends('vendor.layout')

@section('content')

    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Create New Meal</h3>
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
                                <a href="{{route('vendor.meals')}}" class='widget_title' >Meals</a> </li>
                                <li> / </li>
                                <a href="#" class='widget_title section-active'>Create Meal</a> </li>
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
                            <h2 class="text-center mb-4">Add New Meal</h2>
                            
                            <form class="form-contact" action="{{ route('vendor.create.process') }}" method="POST" enctype="multipart/form-data" id="contactForm" novalidate="novalidate">
                                @csrf
                                
                                <!-- Basic Information Section -->
                                <div class="form-section mb-4">
                                    <h4 class="section-title mb-3">Basic Information</h4>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="name" class="form-label">Meal Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" 
                                                   name="name" 
                                                   id="name" 
                                                   type="text" 
                                                   placeholder="Enter meal name"
                                                   value="{{ old('name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      name="description" 
                                                      id="description" 
                                                      rows="4" 
                                                      placeholder="Describe your meal...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing and Category Section -->
                                <div class="form-section mb-4">
                                    <h4 class="section-title mb-3">Pricing & Category</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input class="form-control @error('price') is-invalid @enderror" 
                                                       name="price" 
                                                       id="price" 
                                                       type="number" 
                                                       step="0.01" 
                                                       placeholder="0.00"
                                                       value="{{ old('price') }}">
                                            </div>
                                            @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    name="category_id" 
                                                    id="category_id">
                                                <option value="">Select a category</option>
                                                @foreach($store->categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload Section -->
                                <div class="form-section mb-4">
                                    <h4 class="section-title mb-3">Meal Image</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">Upload Image</label>
                                            <div class="image-upload-container">
                                                <input class="form-control @error('image') is-invalid @enderror" 
                                                       name="image" 
                                                       id="image" 
                                                       type="file"
                                                       accept="image/*">
                                                <small class="text-muted">Recommended size: 800x600px. Max file size: 2MB</small>
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image-preview-container text-center">
                                                <div class="preview-wrapper" style="border: 2px dashed #ddd; border-radius: 8px; padding: 10px; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                                    <img id="imagePreview" 
                                                         src="{{ asset('img/placeholder.png') }}" 
                                                         class="img-fluid rounded" 
                                                         alt="Meal preview"
                                                         style="max-height: 200px; width: auto; object-fit: contain;">
                                                </div>
                                                <div id="imageInfo" class="mt-2 text-muted small"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="button button-contactForm boxed-btn">Create Meal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--================Blog Area =================-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imageInfo = document.getElementById('imageInfo');
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
                        
                        // Display image info
                        const img = new Image();
                        img.onload = function() {
                            imageInfo.textContent = `Dimensions: ${img.width}x${img.height}px | Size: ${(file.size / 1024).toFixed(1)}KB`;
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '{{ asset("img/placeholder.png") }}';
                    previewWrapper.style.border = '2px dashed #ddd';
                    imageInfo.textContent = '';
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