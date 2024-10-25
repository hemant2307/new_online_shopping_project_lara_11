@extends('admin.layout.app')

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{route('admin.product.list')}}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                <form action="" method="" name="createProductForm" id="createProductForm">
					<div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                                </div>
                                                <p name="error_title" id="error_title"></p>
                                                <div class="mb-3">
                                                    <label for="title">slug</label>
                                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="slug">
                                                </div>
                                                <p name="error_slug" id="error_slug"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" cols="80" rows="8" class="summernote" placeholder="Description"></textarea>
                                                    <p name="error_description" id="error_description"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="short_description">Short description</label>
                                                    <textarea name="short_description" id="short_description" cols="80" rows="8" class="summernote" placeholder="short description"></textarea>
                                                    <p name="error_short_description" id="error_short_description"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="shipping_return">Shipping and Returns</label>
                                                    <textarea name="shipping_return" id="shipping_return" cols="80" rows="8" class="summernote" placeholder="shipping andreturn"></textarea>
                                                    <p name="error_shipping_return" id="error_shipping_return"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Media</h2>
                                        <div id="image" name="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.<br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <p name="error_image" id="error_image"></p>
                                </div>

                                <div class="row" id="product-gallery">


                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Pricing</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="price">Price</label>
                                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                                </div>
                                                <p name="error_price" id="error_price"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="compare_price">Compare at Price</label>
                                                    <input type="text" name="compair_price" id="compair_price" class="form-control" placeholder="Compare Price">
                                                    <p class="text-muted mt-3">
                                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                    </p>
                                                </div>
                                                <p name="error_compare_price" id="error_compare_price"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Inventory</h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                                    <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                                </div>
                                                <p name="error_sku" id="error_sku"></p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="barcode">Barcode</label>
                                                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                                </div>
                                                <p name="error_barcode" id="error_barcode"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="hidden" name="track_qty" value="no">
                                                        <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="yes" checked>
                                                        <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Related products</h2>
                                        <div class="mb-3">
                                            <select multiple class="related-product w-100" name="related_products[]" id="related_products" class="form-control">

                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="form-control">
                                            <option value="">Select category</option>
                                                @if($categories->isNotEmpty())
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <p name="error_category" id="error_category"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sub category">Sub category</label>
                                            <select name="sub_category" id="sub_category" class="form-control">
                                            <option value="">Select sub category</option>
                                                <option value="">Mobile</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
                                            <select name="brand" id="brand" class="form-control">
                                            <option value="">Select Brand</option>
                                                @if($brands->isNotEmpty())
                                                @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Featured product</h2>
                                        <div class="mb-3">
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option value="no">No</option>
                                                <option value="yes">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Create</button>
							<a href="{{route('admin.product.list')}}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
					</div>
					<!-- /.card -->
                </form>
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
		</div>


@endsection

@section('custom.Js')
<script type="text/javascript">

    // select2  code here
$(".related-product").select2({
    ajax: {
        url: '{{ route("admin.product.getproduct") }}',
        dataType: 'json',
        tags: true,
        multiple: true,
        minimumInputLength: 3,
        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    }
});


    $("#createProductForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            'url' : "{{route('admin.product.store')}}",
            'data' : $(this).serialize(),
            'type' : 'POST',
            'dataType' : 'json',
            'success' : function(response){
                // console.log(response);
                if(response.status == true){
                    window.location = "{{route('admin.product.list')}}";
                }else{
                var errors = response.errors;
                    if(errors.title){
                    $("#error_title").html(errors.title[0]);
                }else{
                    $("#error_title").html('');
                }
                if(errors.slug){
                    $("#error_slug").html(errors.slug[0]);
                }else{
                    $("#error_slug").html('');
                }
                if(errors.image){
                    $("#error_image").html(errors.image[0]);
                }else{
                    $("#error_image").html('');
                }
                if(errors.price){
                    $("#error_price").html(errors.price[0]);
                }else{
                    $("#error_price").html('');
                }
                if(errors.sku){
                    $("#error_sku").html(errors.sku[0]);
                }else{
                    $("#error_sku").html('');
                }
                if(errors.category){
                    $("#error_category").html(errors.category[0]);
                }else{
                    $("#error_category").html('');
                }

              }
            }
        });
    });


//  select the sub category auto script here
    $('body').on('change','#category',function(){
        var category_id = $(this).val();
        // console.log(category_id);
        $.ajax({
            url : "{{route('productSubCategory.index')}}",
            type : "get",
            data : {category_id:category_id},
            dataType : "json",
            success : function(response){
                // console.log(response);
                $("#sub_category").find("option").not(":first").remove();
                $.each(response["subCategories"],function(key,item){
                    $("#sub_category").append("<Option value='" +item.id +"'>" + item.name+ "</Option>")
                });
            },error : function(){
                console.log('something went wrong');
            }
        });
    });


// script for slug generate
    $('#title').change(function(){
    $.ajax({
        url : "{{route('getSlug')}}",
        type : "GET",
        data : {title : $(this).val()},
        dataType : "json",
        success : function(response){
            if(response.status == true){
                $('#slug').val(response.slug);
            }
        }
    });
});



// dropzone ajax here
Dropzone.autoDiscover = false;
const dropzone = $("#image").dropzone({
    url:  "{{ route('temp-images.create') }}",
    maxFiles: 10,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
    }, success: function(file, response){
        $("#image_id").val(response.image_id);
        //console.log(response)

        var html = `<div class="col-md-3" id="image-row-${response.image_id}">
                    <div class="card">
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                        <img src="${response.imagePath}" class="card-img-top" alt="">
                        <div class="card-body">
                            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>`;
            $("#product-gallery").append(html);
    },
    complete: function(file){
        $this.removeFile(file);
    }
});



function deleteImage(id){
    $("#image-row-"+id).remove();
}




</script>
@endsection

