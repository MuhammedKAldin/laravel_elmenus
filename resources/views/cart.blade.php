@extends('layout')

@section('content')

    <!-- video_area_start -->
       <div class="video_area video_bg overlay">
        <div class="video_area_inner text-center">
            <h3>Shopping Cart</h3>
            <span>Review your order</span>
        </div>
    </div>
    <!-- video_area_end -->
    
    <!--================Blog Area =================-->
    <div class="best_burgers_area">

      <div class="container">
         @if (session('success'))
            <div class="alert alert-success">
               {{ session('success') }}
            </div>

            <script>
               document.addEventListener('DOMContentLoaded', function() 
               {
                  // Update cart display after clearing
                  localStorage.removeItem('cart');
                  displayCart(); 
               });
           </script>
         @endif

         @if (session('message'))
            <div class="alert alert-warning">
               {{ session('message') }}
            </div>
         @endif
      </div>

      <div class="container">
          <div id="cartItems" class="row">
              <!-- Cart items will be dynamically inserted here -->
          </div>

          <div class="cart-summary">
              <div class="col-12 blog_right_sidebar">
                  <h3 class="widget_title">SubTotal: <span id="subtotal">0</span> EGP</h3>
              </div>

              <form action="{{ route('checkout') }}" method="POST" class="checkout-form">
                  @csrf
                  <input type="hidden" name="total_amount" id="total_amount" value="0">
                  <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">
                     <i class="fas fa-credit-card me-2"></i> Pay with Credit Card
                  </button>
              </form>

              <button id="clearCartBtn" class="button rounded-0 secondary-bg text-white w-100 btn_1 boxed-btn" type="button">
                  <i class="fas fa-trash-alt me-2"></i> Clear Cart
              </button>
          </div>
      </div>
     </div>
     
   <style>
      .cart-item {
          background: white;
          border-radius: 10px;
          box-shadow: 0 2px 15px rgba(0,0,0,0.1);
          margin-bottom: 20px;
          transition: all 0.3s ease;
          overflow: hidden;
      }

      .cart-item:hover {
          transform: translateY(-5px);
          box-shadow: 0 5px 20px rgba(0,0,0,0.15);
      }

      .cart-item-content {
          padding: 20px;
      }

      .cart-item-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 15px;
      }

      .cart-item-title {
          font-size: 1.2em;
          font-weight: bold;
          color: #333;
          margin: 0;
      }

      .cart-item-price {
          color: #e74c3c;
          font-weight: bold;
          font-size: 1.1em;
      }

      .cart-item-quantity {
          display: flex;
          align-items: center;
          gap: 10px;
          margin: 10px 0;
      }

      .quantity-btn {
          background: #f8f9fa;
          border: none;
          width: 30px;
          height: 30px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          transition: all 0.3s ease;
      }

      .quantity-btn:hover {
          background: #e9ecef;
      }

      .remove-item-btn {
          color: #dc3545;
          background: none;
          border: none;
          padding: 5px 10px;
          cursor: pointer;
          transition: all 0.3s ease;
          display: flex;
          align-items: center;
          gap: 5px;
      }

      .remove-item-btn:hover {
          color: #c82333;
          transform: scale(1.05);
      }

      .cart-summary {
          background: white;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 2px 15px rgba(0,0,0,0.1);
          margin-top: 30px;
      }

      .checkout-form {
          margin: 20px 0;
      }

      .secondary-bg {
          background: #e74c3c;
          
      }

      .secondary-bg:hover {
          background: #c0392b;
      }

      #clearCartBtn {
          background: white;
          color: #e74c3c;
          font-weight: bold;
          transition: all 0.3s ease;
          border: 2px solid #e74c3c;
      }

      #clearCartBtn:hover {
          background: #e74c3c;
          color: white;
          transform: translateY(-2px);
          box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      }

      @keyframes fadeOut {
          from {
              opacity: 1;
              transform: translateY(0);
          }
          to {
              opacity: 0;
              transform: translateY(-20px);
          }
      }

      .cart-item.removing {
          animation: fadeOut 0.3s ease-out forwards;
      }
  </style>

  <script>
     document.addEventListener('DOMContentLoaded', function() {
         // Function to get cart from localStorage
         function getCart() {
             return JSON.parse(localStorage.getItem('cart')) || [];
         }

         // Function to save cart to localStorage
         function saveCart(cart) {
             localStorage.setItem('cart', JSON.stringify(cart));
         }

         // Function to display cart items and calculate subtotal
         function displayCart() {
             const cart = getCart();
             const cartItemsContainer = document.getElementById('cartItems');
             const subtotalElement = document.getElementById('subtotal');
             const totalAmountInput = document.getElementById('total_amount');
             let subtotal = 0;

             cartItemsContainer.innerHTML = '';

             if (cart.length === 0) {
                 cartItemsContainer.innerHTML = `
                     <div class="col-12 text-center">
                         <div class="empty-cart">
                             <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                             <h3>Your cart is empty</h3>
                             <p>Add some delicious items to your cart!</p>
                         </div>
                     </div>
                 `;
                 subtotalElement.textContent = '0.00';
                 totalAmountInput.value = '0.00';
                 return;
             }

             // Sort cart items by addedAt timestamp
             cart.sort((a, b) => new Date(b.addedAt) - new Date(a.addedAt));

             cart.forEach(item => {
                 const itemHtml = `
                     <div class="col-12">
                         <div class="cart-item" data-id="${item.id}">
                             <div class="cart-item-content">
                                 <div class="row">
                                     <div class="col-md-2">
                                         <img src="{{ asset('storage') }}/${item.image}" 
                                              alt="${item.name}" 
                                              class="img-fluid rounded"
                                              style="width: 100%; height: 150px; object-fit: cover;">
                                     </div>
                                     <div class="col-md-10">
                                         <div class="cart-item-header">
                                             <h3 class="cart-item-title">${item.name}</h3>
                                             <span class="cart-item-price">${item.price} EGP</span>
                                         </div>
                                         <p class="text-muted">${item.description}</p>
                                         <div class="cart-item-quantity">
                                             <button class="quantity-btn decrease-quantity" data-id="${item.id}">
                                                 <i class="fa-solid fa-minus"></i>
                                             </button>
                                             <span>${item.quantity}</span>
                                             <button class="quantity-btn increase-quantity" data-id="${item.id}">
                                                 <i class="fa-solid fa-plus"></i>
                                             </button>
                                         </div>
                                         <button class="remove-item-btn" data-id="${item.id}">
                                             <i class="fas fa-trash-alt"></i>
                                             Remove
                                         </button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 `;
                 cartItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                 subtotal += item.price * item.quantity;
             });

             subtotalElement.textContent = subtotal.toFixed(2);
             totalAmountInput.value = subtotal.toFixed(2);
         }

         // Function to handle quantity changes
         function handleQuantityChange(event) {
             const button = event.target.closest('.quantity-btn');
             if (!button) return;

             const id = button.dataset.id.toString(); // Convert to string to ensure consistent type
             const isIncrease = button.classList.contains('increase-quantity');
             let cart = getCart();
             const itemIndex = cart.findIndex(item => item.id === id);

             if (itemIndex !== -1) {
                 if (isIncrease) {
                     cart[itemIndex].quantity += 1;
                 } else {
                     if (cart[itemIndex].quantity > 1) {
                         cart[itemIndex].quantity -= 1;
                     } else {
                         // If quantity would become 0, remove the item
                         cart.splice(itemIndex, 1);
                     }
                 }
                 saveCart(cart);
                 displayCart();
             }
         }

         // Function to handle item removal
         function handleRemoveItem(event) {
             const button = event.target.closest('.remove-item-btn');
             if (!button) return;

             const id = button.dataset.id.toString(); // Convert to string to ensure consistent type
             let cart = getCart();
             const itemIndex = cart.findIndex(item => item.id === id);

             if (itemIndex !== -1) {
                 // Remove the item from the cart array
                 cart.splice(itemIndex, 1);
                 // Save the updated cart to localStorage
                 saveCart(cart);
                 // Update the display
                 displayCart();
             }
         }

         // Attach event listeners
         document.addEventListener('click', handleQuantityChange);
         document.addEventListener('click', handleRemoveItem);

         // Clear cart
         document.getElementById('clearCartBtn').addEventListener('click', function() {
             if (confirm('Are you sure you want to clear your cart?')) {
                 localStorage.removeItem('cart');
                 displayCart();
             }
         });

         // Initial display of cart items
         displayCart();
     });

  </script>
   <!--================ Blog Area end =================-->

@endsection