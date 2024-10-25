@extends('admin.layout.app')

@section('main')

<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Orders Detail</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{(route('admin.product.create'))}}" class="btn btn-primary">New Product</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="card">
						<form action="" name="searchForm" id="searchForm">
							<div class="card-header">
								<div class="card-tools">
									<div class="input-group input-group" style="width: 250px;">
										<input type="text" value="{{ Request::get('search') }}" name="search" id="search" class="form-control float-right" placeholder="Search">
										<div class="input-group-append">
										<button type="submit" class="btn btn-default">
											<i class="fas fa-search"></i>
										</button>
										<a href="{{ route('admin.product.list') }}" class="btn btn-primary ml-1">Clear</a>
										</div>
									</div>
								</div>
						</div>
							</form>
							<div class="card-body table-responsive p-0">
								<table class="table table-hover text-nowrap">
									<thead>
										<tr>
											<th width="60">ID</th>

											<th>user_id</th>
											<th>user_name</th>
											<th>subTotal</th>
											<th>shipping</th>
											<th>coupon code</th>
											<th>discount</th>
											<th>Grand Total</th>
											<th>first name</th>
											<th>Last name</th>
											<th>email</th>
											<th>country_id/Country</th>
											<th>Address</th>
											<th>Apartment</th>
											<th>City</th>
											<th>State</th>
											<th>Zip</th>
											<th>Mobile</th>
											<th>Order Note</th>
											<!-- <th width="100">Status</th> -->
											<th width="100">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @if($orders->isNotEmpty())
                                        @foreach ($orders as $order )

                                        <tr>
											<td>{{$order->id}}</td>
											<td>{{$order->user_id}}</td>
											<td>{{$order->users->name}}</td>
											<td>{{$order->subtotal}}</td>
											<td>{{$order->shipping}}</td>
											<!-- <td>{{$order->couponcode}}</td> -->
											<td>USSDBYTZ-200</td>
											<td>{{$order->discount}}</td>
											<td>{{$order->grand_total}}</td>
											<td>{{$order->first_name}}</td>
											<td>{{$order->last_name}}</td>
											<td>{{$order->email}}</td>
											<td>{{$order->country_id}} / {{$order->countries->name}}</td>
											<td>{{$order->address}}</td>
											<!-- <td>{{$order->apartment}}</td> -->
											<td>144dc</td>
											<td>{{$order->city}}</td>
											<td>{{$order->state}}</td>
											<td>{{$order->zip}}</td>
											<td>{{$order->mobile}}</td>
											<td>{{$order->order_note}}</td>

											<td>
												<a href="">
													<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
														<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
													</svg>
												</a>
												<a href="#"  class="text-danger w-4 h-4 mr-1">
													<svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
														<path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
												  	</svg>
												</a>
											</td>
										</tr>

                                        @endforeach
                                        @endif

									</tbody>
								</table>
							</div>

			<!-- ****************** orders link  here *************** -->
            {{$orders-> links()}}

						</div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>

@endsection

@section('custom.Js')
<script type="text/javascript">


</script>
@endsection
