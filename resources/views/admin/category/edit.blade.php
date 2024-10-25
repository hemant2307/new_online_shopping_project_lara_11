@extends('admin.layout.app')

@section('main')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @if(Session::has('success'))
                    <p>{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                    <p>{{ Session::get('error') }}</p>
                    @endif
                    <a href="{{route('admin.category.list')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="" name="categoryEditForm" id="categoryEditForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}" placeholder="Name">
                            </div>
                            <p class="error_name"></p>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{$category->name}}" placeholder="Slug">
                            </div>
                            <p class="error_slug"></p>
                        </div>

                         <!-- image dropzone here -->
                         <div class="col-md-6">
                          <div class="mb-3">
                            <input hidden type="text" name="image_id" id="image_id">
                          <label for="image">Image</label>
                       <div id="image" class="dropzone dz-clickable">
                    <div class="dz-message needsclick">
                        <br>Drop files here or click to upload.<br><br>
                    </div>
                        </div>
                        <div>
                            <img width="300" src="{{asset('uploads/category/'.$category->image)}}" alt="">
                         </div>
                             </div>
                                </div>
                         <!-- image dropzone end here -->



                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                               <select class="form-control" name="status" id="status">
                                <option value="1" {{($category->status == 1)? 'selected' : ''}}>Active</option>
                                <option value="0" {{($category->status == 0)? 'selected' : ''}}>Block</option>
                            </select>
                            </div>
                        </div>
                        <p class="error_status"></p>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Show home">Show Home Page</label>
                               <select class="form-control" name="showHome" id="showHome">
                               <option value="Yes" {{($category->showHome == 'Yes')? 'selected' : ''}}> Yes</option>
                               <option value="No" {{($category->showHome == 'No')? 'selected' : ''}}> No</option>
                            </select>
                            </div>
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

$("#categoryEditForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url : "{{ route('admin.category.update',$category->id) }}",
        type : "POST",
        data : $('#categoryEditForm').serialize(),
        dataType : "json",
        success : function(response){
            if(response.status == true){
                window.location.href = "{{ route('admin.category.list') }}";
            }else{
                var errors  = response.errors
                if(errors.name){
                    $(".error_name").html(errors.name[0]);
                }else{
                    $(".error_name").html('');
                }
                if(errors.slug){
                    $(".error_slug").html(errors.slug[0]);
                }else{
                    $(".error_slug").html('');
                }
                if(errors.status){
                    $(".error_status").html(errors.status[0]);
                }else{
                    $(".error_status").html('');
                }
            }
        } , error: function(jqXHR , exception){
            console.log("something went wrong");
        }
    });
});



// script for slug generate
$('#name').change(function(){
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
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url:  "{{ route('temp-images.create') }}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
    }, success: function(file, response){
        $("#image_id").val(response.image_id);
        //console.log(response)
    }
});


</script>

@endsection
