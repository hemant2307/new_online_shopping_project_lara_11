@extends('front.layout.app')


@section('content')

@if(Session::has('success'))
<div class=" text-center alert alert-success">
    {{Session::get('success')}}
</div>

@endif

<h1 class="text-center mt-5 p-4"><u>Thank-You..!</u></h5>
<h3 class="text-center mt-2 p-2">Your Order ID is: {{$id}}</h3>

<!-- <script>
var orderid = response.orderId;
document.getElementById("orderId").innerHTML = "Your Order ID is: "+orderid;

</script>

 -->

@endsection
