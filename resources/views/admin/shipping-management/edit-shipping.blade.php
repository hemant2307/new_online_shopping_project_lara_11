@extends('admin.layout.app')

@section('main')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit shipping Detail</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @if(Session::has('success'))
                    <p>{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                    <p>{{ Session::get('error') }}</p>
                    @endif

                    <a href="{{route('admin.shipping.list')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="" name="editshippingForm" id="editshippingForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">country</label>
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select country</option>
                                    @foreach ($countries as $country )
                                    <option {{($shipping_charge->country_id == $country->id) ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                    <option {{($shipping_charge->country_id == 'rest_of_world') ? 'selected' : ''}} value="rest_of_world">Rest Of The World</option>
                                </select>
                            </div>
                            <p class="error_country"></p>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">amount</label>
                                <input type="text" name="shipping_charge" id="shipping_charge" value="{{$shipping_charge->shipping_charge}}" class="form-control" placeholder="amount">
                            </div>
                            <p class="error_shipping_charge"></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
           </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>

@endsection

@section('custom.Js')
<script type="text/javascript">

$("#editshippingForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url : "{{route('admin.shipping.update',$shipping_charge->id)}}",
        type : "POST",
        data : $('#editshippingForm').serialize(),
        dataType : "json",
        success : function(response){
            if(response.status == true){
                window.location.href = "{{route('admin.shipping.list')}}";
            }else{
                var errors  = response.errors
                if(errors.country){
                    $(".error_country").html(errors.country[0]);
                }else{
                    $(".error_country").html('');
                }
                if(errors.shipping_charge){
                    $(".error_shipping_charge").html(errors.shipping_charge[0]);
                }else{
                    $(".error_shipping_charge").html('');
                }
            }
        } , error: function(jqXHR , exception){
            console.log("something went wrong");
        }
    });
});




</script>

@endsection
