@extends('vendor.layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Create Category</h3>
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
                        <li><a href="{{route('vendor.categories.index')}}" class='widget_title'>Categories</a></li>
                        <li>/</li>
                        <li><a href="#" class='widget_title section-active'>Create Category</a></li>
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
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Add New Category</h2>
                        
                        <form action="{{ route('vendor.categories.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter category name"
                                       required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Enter category description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="button button-contactForm boxed-btn">Create Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 