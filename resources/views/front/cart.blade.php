<!-- Gloudemans/Shoppingcart/Facades/cart; -->
@extends('front.layout.app')

@section('content')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                               @if(!empty($cartContent))
                               @foreach ( $cartContent as $item )
                               <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-space-between">
                                    @if(!empty($item->options->productImage->image))
                                    <img class="card-img-top" src="{{asset('uploads/products/small/'.$item->options->productImage->image)}}" alt="">
                                    @else
                                    <img class="card-img-top" src="{{asset('front-assets/images/cat-2.jpg')}}" alt="">
                                    @endif
                                            <h2>{{$item->name}}</h2>
                                        </div>
                                    </td>
                                    <td>${{$item->price}}</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub" data-id="{{$item->rowId}}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{$item->qty}}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add" data-id="{{$item->rowId}}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        ${{$item->price*$item->qty}}
                                    </td>
                                    <td>
                                        <!-- <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button> -->
                                        <button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="deleteCartItem('{{$item->rowId}}')" >Remove</button>
                                    </td>
                                </tr>
                                @endforeach
                               @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <!-- <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div> -->
                        <div class="card-body">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div>
                            <!-- <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{Cart::subtotal()}}</div>
                            </div> -->
                            <!-- <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>$0</div>
                            </div> -->
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{Cart::subtotal()}}</div>
                            </div>
                            <div class="pt-5">
                                @if(Cart::count() > 0)
                                <a href="{{route('shop.checkout')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                                @else
                                <a href="#" class="btn-dark btn btn-block msg w-100"  >Proceed to Checkout</a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <!-- <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</main>

@endsection


@section('customJs')

<script type="text/javascript">

    // cart button "add" and "sub"

$(".add").click(function(){
    var qtyElement = $(this).parent().prev();
    var qtyValue = parseInt(qtyElement.val());
    // var newQtyValue = qtyValue + 1;
    if(qtyValue < 10){
        qtyElement.val(qtyValue + 1);

        var rowId = $(this).data('id')
        var newQty = qtyElement.val();
        updateCart(rowId,newQty);
    }
});



$(".sub").click(function(){
    var qtyElement = $(this).parent().next();
    var qtyValue = parseInt(qtyElement.val());
    // var newQtyValue = qtyValue + 1;
    if(qtyValue > 1){
        qtyElement.val(qtyValue - 1);

        var rowId = $(this).data('id')
        var newQty = qtyElement.val();
        updateCart(rowId,newQty);
    }
});


// update cart
function updateCart(rowId,qty){

    $.ajax({
        url: "{{route('shop.updateCart')}}",
        type: 'POST',
        data: { rowId:rowId , qty:qty},
        dataType: "json",
        success: function(response){
            window.location.href = "{{route('shop.cart')}}";
        }
    });

}

// remove cart item or row
function deleteCartItem(rowId){
    if(confirm("are you sure you want to remove this item from your cart")){
        $.ajax({
        url: "{{route('shop.deleteCartItem')}}",
        type: 'GET',
        data: { rowId:rowId},
        dataType: "json",
        success: function(response){
            window.location.href = "{{route('shop.cart')}}";
        }
    });
  }
}


// function warning(){
// alert("there is no item in your cart.");
// }


$(".msg").click(function(){
    alert("there is no item in your cart.");
});


</script>

@endsection
