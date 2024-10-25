@extends('admin.layout.app')

@section('main')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Discount</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @if(Session::has('success'))
                    <p>{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                    <p>{{ Session::get('error') }}</p>
                    @endif

                    <a href="categories.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="" name="discountForm" id="discountForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                            </div>
                            <p class="error_name"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">code</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="code">
                            </div>
                            <p class="error_code"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_user">max_user</label>
                                <input type="text" name="max_user" id="max_user" class="form-control" placeholder="max_user">
                            </div>
                            <p class="error_max_user"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_uses_user">max_uses_user</label>
                                <input type="text" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="max_uses_user">
                            </div>
                            <p class="error_max_uses_user"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type">type</label>
                               <select class="form-control" name="type" id="type">
                                <option value="percentage">Percentage %</option>
                                <option value="fixed">Fixed</option>
                            </select>
                            </div>
                        </div>
                        <p class="error_type"></p>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_amount">discount_amount</label>
                                <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="discount_amount">
                            </div>
                            <p class="error_discount_amount"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="min_amount">min_amount</label>
                                <input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="min_amount">
                            </div>
                            <p class="error_min_amount"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                               <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">closed</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="starts_at">starts_at</label>
                                <input type="text" name="starts_at" id="starts_at" class="form-control" placeholder="starts_at">
                            </div>
                            <p class="error_starts_at"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expires_at">expires_at</label>
                                <input  name="expires_at" id="expires_at" class="form-control" placeholder="expires_at">
                            </div>
                            <p class="error_expires_at"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description">description</label>
                                <textarea  class="form-control" name="description" id="description"></textarea>
                            </div>
                            <p class="error_description"></p>
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

// date time picker

$(document).ready(function(){
            $('#starts_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });


$(document).ready(function(){
    $('#expires_at').datetimepicker({
        // options here
        format:'Y-m-d H:i:s',
    });
});



$("#discountForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url : "{{ route('admin.discount.store') }}",
        type : "POST",
        data : $('#discountForm').serialize(),
        dataType : "json",
        success : function(response){
            if(response.status == true){
                // window.location.href = "{{ url()->current(); }}";
                window.location.href = "{{ route('admin.discount.list') }}";
            }else{
                var errors  = response.errors
                if(errors.name){
                    $(".error_name").html(errors.name[0]);
                }else{
                    $(".error_name").html('');
                }
                if(errors.code){
                    $(".error_code").html(errors.code[0]);
                }else{
                    $(".error_code").html('');
                }
                if(errors.max_user){
                    $(".error_max_user").html(errors.max_user[0]);
                }else{
                    $(".error_max_user").html('');
                }
                if(errors.discount_amount){
                    $(".error_discount_amount").html(errors.discount_amount[0]);
                }else{
                    $(".error_discount_amount").html('');
                }
                if(errors.starts_at){
                    $(".error_starts_at").html(errors.starts_at[0]);
                }else{
                    $(".error_starts_at").html('');
                }
                if(errors.expires_at){
                    $(".error_expires_at").html(errors.expires_at[0]);
                }else{
                    $(".error_expires_at").html('');
                }
            }
        } , error: function(jqXHR , exception){
            console.log("something went wrong");
        }
    });
});


</script>

@endsection
