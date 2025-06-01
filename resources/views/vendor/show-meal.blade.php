@extends('vendor.layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Edit Meal</h3>
    </div>
    <!-- bradcam_area_end -->

    <div class="testimonial_area" style="background: #fff; padding: 20px 0;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <ul class="section_title mb-4 post_category_widget text-center" style="display: ruby-text;">
                        <li><a href="{{route('vendor.profile')}}" class='widget_title'>General</a></li>
                        <li>/</li>
                        <li><a href="{{route('vendor.meals')}}" class='widget_title'>Meals</a></li>
                    </ul>
                </div>

                @if (session('success'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
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
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="text-center mb-0">Edit Meal Details</h2>
                                <p class="text-center text-muted">Update your meal information below</p>
                            </div>
                        </div>
                        
                        <form enctype="multipart/form-data" class="form-contact contact_form" action="{{route('vendor.meals.update', $item->id)}}" method="post" id="contactForm" novalidate="novalidate">
                            @method('PUT')
                            @csrf
                            
                            <div class="row">
                                <!-- Left Column - Basic Information -->
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Basic Information</h5>
                                            
                                            <div class="mb-3">
                                                <label for="meal_name" class="form-label">Meal Name</label>
                                                <input class="form-control" name="meal_name" id="meal_name" type="text" value="{{$item->meal_name}}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="meal_price" class="form-label">Meal Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input class="form-control" name="meal_price" id="meal_price" type="number" step="0.01" value="{{$item->meal_price}}" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="meal_category" class="form-label">Category</label>
                                                <select name="meal_category" id="meal_category" class="form-select" required>
                                                    <option value="{{$item->meal_category}}" selected>{{ucfirst($item->meal_category)}}</option>
                                                    <option value="grill">Grill</option>
                                                    <option value="fried chicken">Fried Chicken</option>
                                                    <option value="pizza">Pizza</option>
                                                    <option value="burger">Burger</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Image and Description -->
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Meal Image</h5>
                                            <div class="text-center mb-3">
                                                <div class="position-relative d-inline-block">
                                                    <img id='imagePreview' 
                                                         src="{{asset('storage/meals/'.$item->meal_image)}}" 
                                                         alt="Meal Image" 
                                                         class="img-fluid rounded shadow-sm" 
                                                         style="max-width: 200px; height: 200px; object-fit: cover;">
                                                    <div class="position-absolute bottom-0 end-0 p-2">
                                                        <label for="mealImageInput" class="btn btn-sm btn-primary rounded-circle">
                                                            <i class="fas fa-camera"></i>
                                                        </label>
                                                        <input id='mealImageInput' 
                                                               name="meal_image" 
                                                               type="file" 
                                                               class="d-none" 
                                                               accept="image/*"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Full Width - Description -->
                                <div class="col-12">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Meal Description</h5>
                                            <div class="mb-3">
                                                <textarea class="form-control" 
                                                          name="meal_desc" 
                                                          id="meal_desc" 
                                                          rows="4" 
                                                          placeholder="Describe your meal in detail..."
                                                          required>{{$item->meal_desc}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="button button-contactForm boxed-btn px-5">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .form-control:focus, .form-select:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        }
        .button-contactForm {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .button-contactForm:hover {
            background: #ff5252;
            transform: translateY(-2px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('mealImageInput');
            const imagePreview = document.getElementById('imagePreview');
    
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.add('fade-in');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection