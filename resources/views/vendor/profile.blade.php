@extends('vendor.layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-white mb-0"><i class="fas fa-store me-2"></i>Store Profile</h3>
                    <p class="text-white-50 mb-0">Manage your store's information and appearance</p>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end -->

    <div class="testimonial_area" style="background: #fff; padding: 20px 0;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <ul class="section_title mb-4 post_category_widget text-center" style="display: ruby-text;">
                        <li><a href="{{route('vendor.profile')}}" class='widget_title section-active'><i class="fas fa-user-circle me-1"></i>General</a></li>
                        <li>/</li>
                        <li><a href="{{route('vendor.meals')}}" class='widget_title'><i class="fas fa-utensils me-1"></i>Meals</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Store Overview Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="store-avatar me-4">
                                        <img src="{{ asset('img/store-avatar.png') }}" alt="Store Avatar" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <h2 class="mb-1"><i class="fas fa-store me-2"></i>{{$store->name}}</h2>
                                        <p class="text-muted mb-0"><i class="fas fa-quote-left me-1"></i>{{$store->description}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="fas fa-map-marker-alt text-primary mb-2" style="font-size: 24px;"></i>
                                        <h5 class="card-title mb-1">Location</h5>
                                        <p class="card-text text-muted small">{{$store->address}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="fas fa-phone-alt text-primary mb-2" style="font-size: 24px;"></i>
                                        <h5 class="card-title mb-1">Contact</h5>
                                        <p class="card-text text-muted small">{{$store->phone}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="fas fa-envelope text-primary mb-2" style="font-size: 24px;"></i>
                                        <h5 class="card-title mb-1">Email</h5>
                                        <p class="card-text text-muted small">{{$store->email}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Edit Store Information</h4>
                                        <form class="form-contact contact_form" action="{{ route('vendor.profile.update') }}" method="POST" id="contactForm" novalidate="novalidate">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="name" class="form-label">Store Name</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-store"></i></span>
                                                        <input class="form-control" name="name" id="name" type="text" value="{{$store->name}}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                        <input class="form-control" name="email" id="email" type="email" value="{{$store->email}}" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="description" class="form-label">Welcome Message</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                                        <input class="form-control" name="description" id="description" type="text" value="{{$store->description}}" placeholder="Enter a welcoming message for your customers">
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="address" class="form-label">Store Address</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter your store's address">{{$store->address}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-center mt-4">
                                                <button type="submit" class="button button-contactForm boxed-btn px-5">
                                                    Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group .form-control:focus {
            border-left: none;
            border-color: #ced4da;
        }
        .section-active {
            color: #ff6b6b !important;
            font-weight: 600;
        }
        .widget_title {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .widget_title:hover {
            color: #ff6b6b;
        }
    </style>
@endsection