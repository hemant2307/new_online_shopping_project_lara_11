
@extends('front.layout.app')


@section('content')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">{{$product->title}}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @if($product->product_images)
                            @foreach ($product->product_images as $key => $productImage)
                            <div class="carousel-item {{($key == 0)? 'active' : ''}}">
                                <img class="w-100 h-100" src="{{asset('uploads/products/small/'.$productImage->image)}}" alt="Image">
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1> {!! $product->description !!}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>

                        @if($product->compair_price > 0)
                        <h2 class="price ">{{$product->compair_price}}</h2>
                        @endif
                        <h2 class="price text-secondary"><del>{{$product->price}}</del></h2>

                        {!! $product->description !!}
                        <a href="javaScript:void(0)" onclick="addToCart('{{$product->id}}')" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            {!! $product->short_description !!}
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            {!! $product->shipping_return !!}
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($relatedProducts))
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                    @foreach ( $relatedProducts as $relatedProduct )
                    @php
                        $relatedProductImage = $relatedProduct->product_images->first();
                    @endphp

                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{route('shop.product',$relatedProduct->slug)}}" class="product-img">
                            @if($relatedProductImage != '')
                                <img class="card-img-top" src="{{asset('uploads/products/small/'.$relatedProductImage->image)}}" alt="">
                            @else
                            <img class="card-img-top" src="{{asset('front-assets/images/cat-2.jpg')}}" alt="">
                            @endif
                             </a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark"  href="javaScript:void(0)" onclick="addToCart('{{$relatedProduct->id}}')" >
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">{{$relatedProduct->title}}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>${{$relatedProduct->price}}</strong></span>
                                @if($relatedProduct->compair_price > 0)
                                <span class="h6 text-underline"><del>${{$relatedProduct->compair_price}}</del></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
<!-- if there is no related product in database then it will fatch random product from DB. -->
    @else
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                    @foreach ( $randomProducts as $randomProduct )
                    @php
                        $randomProductImage = $randomProduct->product_images->first();
                    @endphp

                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{route('shop.product',$randomProduct->slug)}}" class="product-img">
                            @if($randomProductImage != '')
                                <img class="card-img-top" src="{{asset('uploads/products/small/'.$randomProductImage->image)}}" alt="">
                            @else
                            <img class="card-img-top" src="{{asset('front-assets/images/cat-2.jpg')}}" alt="">
                            @endif
                             </a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark"  href="javaScript:void(0)" onclick="addToCart('{{$randomProduct->id}}')">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">{{$randomProduct->title}}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>${{$randomProduct->price}}</strong></span>
                                @if($randomProduct->compair_price > 0)
                                <span class="h6 text-underline"><del>${{$randomProduct->compair_price}}</del></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    @endif
</main>
@endsection


@section('customJs')

<script type="text/javascript">
// this function is on app.blade.php of front

//     function addToCart(id){
//             // alert(id);
//      $.ajax({
//         url: '{{route("shop.addToCart")}}',
//         type: 'POST',
//         data: { id:id },
//         dataType: 'json',
//         success: function(response){
//             if(response.status == true){
//                 window.location.href = "{{route('shop.cart')}}";
//             }else{
//                 alert(response.message);
//             }
//         }
//      });
// }


</script>

@endsection
