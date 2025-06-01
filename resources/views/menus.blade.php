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
    
       <!--================Blog Area =================-->
       <section class="blog_area single-post-area section-padding">
           <div class="container">
             <div class="row">
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">

                       <aside class="single_sidebar_widget post_category_widget">
                          <h4 class="widget_title">Category</h4>
                          <ul class="list cat-list">
                             <li>
                                <a href="#" class="d-flex">
                                   <p>Grills </p>
                                   <p>(37)</p>
                                </a>
                             </li>
                             <li>
                                <a href="#" class="d-flex">
                                   <p>Fried Chicken</p>
                                   <p>(10)</p>
                                </a>
                             </li>
                             <li>
                                <a href="#" class="d-flex">
                                   <p>Pizza </p>
                                   <p>(03)</p>
                                </a>
                             </li>
                             <li>
                                <a href="#" class="d-flex">
                                   <p>Burgers</p>
                                   <p>(11)</p>
                                </a>
                             </li>
                             
                          </ul>
                       </aside>
                       
                    </div>
                 </div>

                <div class="col-lg-8 posts-list">
                    <div class="single_sidebar_widget search_widget">
                           <form action="{{ route('search') }}" method="GET">
                              <div class="form-group">
                                 <div class="input-group mb-3">
                                    <input name="query" type="text" class="form-control" placeholder='Search Keyword' value="{{ $searchTerm ?? '' }}">
                                    <div class="input-group-append">
                                       <button class="btn" type="submit"><i class="ti-search"></i></button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                    </div>

                    </br>
                    
                    <div id="searchResults">
                     @if($stores->isEmpty())
                        <div class="alert alert-info">No restaurants found matching your search.</div>
                     @else
                        @foreach ($stores as $store)
                        <div class="single-post">
                           <div class="Burger_President_area">
                              <div class="Burger_President_here"> 
                                 <div class="single_Burger_President" style="width:100%!important;">
                                       <div class="room_thumb">
                                          <img src="{{ asset('storage/' . $store->cover_image) }}" alt="{{ $store->name }}">
                                          <div class="room_heading d-flex justify-content-between align-items-center">
                                             <div class="room_heading_inner">
                                                   <span>{{ $store->name }}</span>
                                                   <p>{{ $store->description }}</p>
                                                   <a href="{{ route('openMenu', $store->slug) }}" class="boxed-btn3">Open Menu</a>
                                             </div>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        </br>
                        @endforeach
                     @endif
                    </div>
               </div>
           </div>
       </section>
       <!--================ Blog Area end =================-->

       <script>
         $(document).ready(function() {
             // Search on button click
             $('#searchButton').click(function(event) {
                 event.preventDefault();
                 var query = $('#searchInput').val().trim();
                 if (query) {
                     performSearch(query);
                 }
             });

             // Search on Enter key press
             $('#searchInput').keypress(function(event) {
                 if (event.which === 13) {
                     event.preventDefault();
                     var query = $(this).val().trim();
                     if (query) {
                         performSearch(query);
                     }
                 }
             });
         });
     </script>
     
    <!-- slider_area_end -->
@endsection