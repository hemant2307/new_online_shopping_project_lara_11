@extends('front.layout.app')


@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
           <form action="" method="POST" name="address-form" id="address-form">
           <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{(!empty($customer_address))? $customer_address->first_name : ''}}" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="error_first_name"></div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" value="{{(!empty($customer_address))? $customer_address->last_name : ''}}" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="error_last_name"></div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" value="{{(!empty($customer_address))? $customer_address->email : ''}}" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="error_email"></div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select a Country</option>
                                            @foreach($countries as $country)
                                            <option {{(!empty($customer_address) && $customer_address->country_id == $country->id)? 'selected' : ''}} value="{{$country->id}}">{{$country->name}} - {{$country->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="error_country"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" value="{{(!empty($customer_address))? $customer_address->address : ''}}" class="form-control"></textarea>
                                    </div>
                                    <div class="error_address"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" id="apartment" class="form-control" value="{{(!empty($customer_address))? $customer_address->apartment : ''}}" placeholder="Apartment, suite, unit, etc. (optional)">
                                    </div>
                                </div>

                        <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" value="{{(!empty($customer_address))? $customer_address->city : ''}}" class="form-control" placeholder="City">
                                    </div>
                                    <div class="error_city"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" value="{{(!empty($customer_address))? $customer_address->state : ''}}" placeholder="State">
                                    </div>
                                    <div class="error_state"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" value="{{(!empty($customer_address))? $customer_address->zip : ''}}" placeholder="Zip">
                                    </div>
                                    <div class="error_zip"></div>
                                </div>
                            </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" value="{{(!empty($customer_address))? $customer_address->mobile : ''}}" placeholder="Mobile No.">
                                    </div>
                                </div>
                                <div class="error_mobile"></div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_note" id="order_note" cols="30" rows="2" value="{{(!empty($customer_address))? $customer_address->order_note : ''}}" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">

                            @foreach ( Cart::content()  as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                <div class="h6">${{Cart::subtotal()}}</div>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>

                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Discount</strong></div>
                                <div class="h6"><strong id="discount_value">${{$discount}}</strong></div>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="totalShipping">${{number_format($totalShipping,2)}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grand_total">${{number_format($grand_total,2)}}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control" name="discount_code" id="discount_code">
                        <button class="btn btn-dark" type="button" id="apply-discount">Apply Coupon</button>
                    </div>

                  <div id="discount-response-wrapper">
                  @if (Session::has('code'))
                    <div mt-4 id="discount-response">
                        <strong>{{ Session::get('code')->code}}</strong>
                        <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
                    </div>
                    @endif
                  </div>

                    <div class="card payment-form ">
                        <h3 class="card-title h5 mb-3">Payment Details</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="payment_method_one" class="mb-2">COD</label>
                                <input checked type="radio" name="payment_method" id="payment_method_one" value="cod"  class="form-check-label">
                            </div>
                            <div class="col-md-6">
                                <label for="payment_method_two" class="mb-2 ">Strip</label>
                                <input type="radio" name="payment_method" id="payment_method_two" value="strip"  class="form-check-label">
                            </div>
                        </div>
                        <div class="card-body p-0 d-none" id="card-payment-form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <!-- <a href="javascrpt:void(0)" type="submit" class="btn-dark btn btn-block w-100">Pay Now</a> -->
                            <button  type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>
                    </div>
                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </div>
           </form>
        </div>
    </section>
</main>
@endsection


@section('customJs')

<script>

$("#payment_method_one").click(function(){
    if( $(this).is(":checked") == true){
    $("#card-payment-form").addClass("d-none");
    }
});


$("#payment_method_two").click(function(){
    if( $(this).is(":checked") == true){
    $("#card-payment-form").removeClass("d-none");
    }
});



$("#address-form").submit(function(e){
        e.preventDefault();
            $.ajax({
                url: "{{route('shop.checkOutProcess')}}",
                type: "POST",
                data: $(this).serializeArray(),
                dataType : "json",
                success: function(response){
                if(response.status == false){
                    // alert(response.message);
                    var errors = response.errors;
                        if(errors.first_name){
                            $(".error_first_name").text(errors.first_name[0]);
                            }else{
                                $(".error_first_name").text("");
                                }
                        if(errors.last_name){
                            $(".error_last_name").text(errors.last_name[0]);
                            }else{
                                $(".error_last_name").text("");
                                }
                        if(errors.email){
                            $(".error_email").text(errors.email[0]);
                            }else{
                                $(".error_email").text("");
                                }
                        if(".error.country"){
                                $(".error_country").text(errors.country[0]);
                            }else{
                                $(".error_country").text("");
                                }
                        if(errors.address){
                            $(".error_address").text(errors.address[0]);
                            }else{
                                $(".error_address").text("");
                                }
                        if(errors.city){
                            $(".error_city").text(errors.city[0]);
                            }else{
                                $(".error_city").text("");
                                }
                        if(errors.state){
                            $(".error_state").text(errors.state[0]);
                            }else{
                                $(".error_state").text("");
                                }
                        if(errors.zip){
                            $(".error_zip").text(errors.zip[0]);
                            }else{
                                $(".error_zip").text("");
                                }
                        if(errors.mobile){
                            $(".error_mobile").text(errors.mobile[0]);
                            }else{
                                $(".error_mobile").text("");
                                }
                        }else{
                            window.location.href = "{{url('Thank-You/')}}/"+response.orderId;
                    }
                }
            });
        });



$("#country").change(function(){
    $.ajax({
        url: "{{route('shop.getOrderSummery')}}",
        type: "POST",
        data: {country_id : $(this).val()},
        dataType: "json",
        success: function(response){
            if(response.status == true){
                $("#totalShipping").html(response.totalShippingCharge);
                $("#grand_total").html(response.grand_total);
            }
        }
    });
});



// apply discount ajax here

$('#apply-discount').click(function(){
    $.ajax({
        url: "{{route('shop.apply-discount')}}",
        type: "POST",
        data: {code:$('#discount_code').val() , country_id:$('#country').val()},
        dataType: "json",
        success: function(response){
            if(response.status == true){
                $("#totalShipping").html('$'+response.totalShippingCharge);
                $("#grand_total").html('$'+response.grand_total);
                $("#discount_value").html('$'+response.discount);
                $("#discount-response-wrapper").html(response.discountString);
            }else{
                $("#discount-response-wrapper").html('<span class="text-danger">'+response.message+'</span>');
            }
        }
    });
});


// $('#remove-discount').click(function(){
    $('body').on('click',"#remove-discount",function(){
    $.ajax({
        url: "{{route('shop.removeCoupon')}}",
        type: "POST",
        data: {country_id:$('#country').val()},
        dataType: "json",
        success: function(response){
            if(response.status == true){
                $("#totalShipping").html('$'+response.totalShippingCharge);
                $("#grand_total").html('$'+response.grand_total);
                $("#discount_value").html('$'+response.discount);
                $("#discount-response").html('');
                $("#discount_code").val('');


            }
        }
    });
});



</script>

@endsection
