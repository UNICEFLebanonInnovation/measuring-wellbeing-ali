@extends('admin.layout.login_app')

@section('title',"Login")


@section('content')
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" >
		<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
			<div class="m-login__container">
				<div class="m-login__logo">
					<a href="#">
						<img width="400" height="300" src="{{ url('/public') }}/images/inter-agency-web-big-2.JPG" />
					</a>
				</div>
				<div class="m-login__signin">
					<div class="m-login__head">
						<h3 class="m-login__title">Sign In To Admin</h3>
					</div>
					<form class="m-login__form m-form" id="login" action="{{ url('login-post') }}" method="post">
					@include('admin.layout.flash')
						@csrf
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Email" value="{{ old('email') }}" name="email" autocomplete="off">
							@if ($errors->has('email'))
			                  	<span class="m-form__help">{{ $errors->first('email') }}</span>
			              	@endif
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
							@if ($errors->has('password'))
			                  	<span class="m-form__help">{{ $errors->first('password') }}</span>
			              	@endif
						</div>
						<div class="row m-login__form-sub">
							<div class="col m--align-left m-login__form-left">
								<label class="m-checkbox  m-checkbox--light">
									<input type="checkbox" name="remember" value="1"> Remember me
									<span></span>
								</label>
							</div>
							<div class="col m--align-right m-login__form-right">
								<a href="{{ url('forgot-password') }}" class="m-link">Forget Password ?</a>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign In</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
<script type="text/javascript">
   $(document).ready(function(){
      $("#login").validate({
         rules:{
            email:{
               required:true,
               email:true,
            },
            password:{
               required:true,
            },
         },
         messages:{
            password:{
               required:"Please enter your password",
            },
            email:{
               required:"Please enter your email",
               email:"Please enter your valid email",
            },
         }
      })
   });
</script>
@endsection