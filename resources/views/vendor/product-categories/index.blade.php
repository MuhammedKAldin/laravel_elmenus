@extends('vendor.layout')

@section('content')
    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg">
        <h3>Product Categories</h3>
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
                        <li><a href="#" class='widget_title section-active'>Product Categories</a></li>
                    </ul>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="text-center">
                    <a href="{{ route('vendor.product-categories.create') }}" class="boxed-btn5" style="padding: 16px 100px;">
                        Create New Category
                    </a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4">Your Product Categories</h3>
                        
                        @if($categories->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Products</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ Str::limit($category->description, 50) }}</td>
                                                <td>{{ $category->products_count }}</td>
                                                <td>
                                                    <a href="{{ route('vendor.product-categories.edit', $category) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('vendor.product-categories.destroy', $category) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No product categories found. Create your first category!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 