<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">
		<link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<!-- /.login-logo -->
			<div class="card card-outline card-primary">
			  	<div class="card-header text-center">
					<a href="#" class="h3">Register Administrative/User Panel</a>
                    @if(Session::has('success'))
                    <p>{{Session::get('success')}}</p>
                    @endif
                    @if(Session::has('error'))
                    <p>{{Session::get('error')}}</p>
                    @endif
			  	</div>
			  	<div class="card-body">
					<p class="login-box-msg">Sign Up to start your session</p>
					<form action="" name="registerForm" id="registerForm" method="">
                        @csrf
                    <div class="input-group mb-3">
							<input type="text" name="name" id="name" class="form-control" placeholder="name">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-envelope"></span>
					  			</div>
							</div>
				  		</div>
                          <p id="error_name"></p>
				  		<div class="input-group mb-3">
							<input type="email" name="email" id="email" class="form-control" placeholder="Email">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-envelope"></span>
					  			</div>
							</div>
				  		</div>
                          <p id="error_email"></p>
				  		<div class="input-group mb-3">
							<input type="password" name="password" id="password" class="form-control" placeholder="Password">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-lock"></span>
					  			</div>
							</div>
				  		</div>
                          <p id="error_password"></p>
                          <div class="input-group mb-3">
							<input type="Password" name="confirm_password" id="confirm_password" class="form-control" placeholder="confirm Password">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-lock"></span>
					  			</div>
							</div>
				  		</div>
                          <p id="error_confirm_password"></p>
				  		<div class="row">
							<!-- <div class="col-8">
					  			<div class="icheck-primary">
									<input type="checkbox" id="remember">
									<label for="remember">
						  				Remember Me
									</label>
					  			</div>
							</div> -->
							<!-- /.col -->
							<div class="col-4">
					  			<button type="submit" class="btn btn-primary btn-block">register</button>
                                  <button  class="btn btn-success btn-block"><a style="color: #ffff;" href="{{route('user.login')}}">logIn</a></button>
							</div>
							<!-- /.col -->
				  		</div>
					</form>
		  			<p class="mb-1 mt-3">
				  		<a href="forgot-password.html">I forgot my password</a>
					</p>
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{asset('admin-assets/js/demo.js')}}"></script>

        <script type="text/javascript">
            $("#registerForm").submit(function(e){
                e.preventDefault();

                $.ajax({

                    url : "{{route('user.saveUser')}}",
                    type : "POST",
                    data : $(this).serializeArray(),
                    dataType : "json",
                    success : function(response){
                        if(response.status == true){
                            window.location.href = '{{route("user.register")}}';
                        }else{
                            var errors = response.errors;
                            if(errors.name){
                            $("#error_name").html(errors.name[0]);
                            }else{
                                $("#error_name").html('');
                            }
                            if(errors.email){
                                $("#error_email").html(errors.email[0]);
                            }else{
                                $("#error_email").html('');
                            }
                            if(errors.password){
                                $("#error_password").html(errors.password[0]);
                            }else{
                                $("#error_password").html('');
                            }
                            if(errors.confirm_password){
                                $("#error_confirm_password").html(errors.confirm_password[0]);
                            }else{
                                $("#error_confirm_password").html('');
                            }

                        }
                    }

                })
            })



        </script>
	</body>
</html>
