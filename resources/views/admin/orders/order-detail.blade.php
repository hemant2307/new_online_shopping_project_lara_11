@extends('admin.layout.app')

@section('main')

<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Order: {{$order->id}}</h1>
							</div>
							<div class="col-sm-6 text-right">
                                <a href="orders.html" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header pt-3">
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                            <h1 class="h5 mb-3">Shipping Address</h1>
                                            <address>
                                                <strong>{{$order->first_name}}  {{$order->last_name}}</strong><br>
                                                {{$order->address}}, Suite 600<br>
                                                City: {{$order->city}}, zip: {{$order->zip}}<br>
                                               Mobile: {{$order->mobile}}<br>
                                                Email: {{$order->email}}
                                                country : {{$order->countries->name}}
                                            </address>
                                            <strong>
                                            shipping Date:
                                                @if($order->shipped_date != '')
                                                {{Carbon\Carbon::parse($order->shipped_date)->format('Y-m-d')}}
                                                @else
                                                N/A
                                                @endif
                                            </strong>
                                            </div>
                                            <div class="col-sm-4 invoice-col">
                                                <!-- <b>Invoice #007612</b><br>
                                                <br> -->
                                                <b>Order ID:</b> {{$order->id}}<br>
                                                <b>Total:</b> ${{number_format($order->grand_total,2)}}<br>
                                                <b>Status:</b>
                                                @if($order->status == 'pending')
                                                <span class="badge bg-danger">pending</span>
                                                @elseif($order->status == 'shipped')
                                                <span class="badge bg-info">shipped</span>
                                                @elseif($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                                @else($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th width="100">Price</th>
                                                    <th width="100">Qty</th>
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if($products != '')
                                            @foreach ( $products as $product )
                                            <tr>
                                                    <td>{{$product->name}}</td>
                                                    <td>${{number_format($product->price,2)}}</td>
                                                    <td>{{$product->qty}}</td>
                                                    <td>${{number_format($product->price * $product->qty ,2)}}</td>
                                                </tr>

                                            @endforeach
                                            @endif

                                                <tr>
                                                    <th colspan="3" class="text-right">Subtotal:</th>
                                                    <td>${{number_format($order->subtotal,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Discount: @if($order->coupon_code != '') - {{$order->coupon_code}} @else '' @endif </th>
                                                    <td>${{number_format($order->discount,2)}}</td>
                                                </tr>

                                                <tr>
                                                    <th colspan="3" class="text-right">Shipping:</th>
                                                    <td>${{number_format($order->shipping,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Grand Total:</th>
                                                    <td>${{number_format($order->grand_total,2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                            <form action="" method="POST" name="changeOrderStatus" id="changeOrderStatus">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Order Status</h2>
                                        <div class="mb-3">
                                    <select name="status" id="status" class="form-control">

                                    <!-- this terniry operator is not working here *************** -->


                                        @if($order->status == 'pending')
                                        <option value="Pending" selected>Pending</option>
                                        <option value="shipped" >shipped</option>
                                        <option value="Delivered" >Delivered</option>
                                        <option value="cancelled" >Cancelled</option>

                                        @elseif($order->status == 'shipped')
                                        <option value="shipped" selected>shipped</option>
                                        <option value="Pending" >Pending</option>
                                        <option value="Delivered" >Delivered</option>
                                        <option value="cancelled" >Cancelled</option>

                                        @elseif($order->status == 'Delivered')
                                        <option value="Delivered" selected>Delivered</option>
                                        <option value="Pending" >Pending</option>
                                        <option value="shipped" >shipped</option>
                                        <option value="cancelled" >Cancelled</option>

                                        @else($order->status == 'cancelled')
                                        <option value="cancelled" selected>Cancelled</option>
                                        <option value="Delivered" >Delivered</option>
                                        <option value="Pending" >Pending</option>
                                        <option value="shipped" >shipped</option>
                                        @endif
                                </select>
                                    </div>
                                        <div class="mb-3">
                                            <label for="shipped_date">Shipped Date</label>
                                            <input type="text" name="shipped_date" id="shipped_date" class="form-control" value="{{(!empty($order->shipped_date)) ? $order->shipped_date : ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                            </form>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Send Inovice Email</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Customer</option>
                                                <option value="">Admin</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>

@endsection

@section('custom.Js')
<script type="text/javascript">

// date time picker

$(document).ready(function(){
            $('#shipped_date').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });


// change order status ajax here

$("#changeOrderStatus").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "{{route('admin.order.changeOrderStatus',$order->id)}}",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(data){
            if(data.status == true){
               window.location.href = "{{route('admin.order.detail',$order->id)}}";
            }

        }

    });

});


</script>
@endsection
