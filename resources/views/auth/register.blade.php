@extends('layouts.master')

@section('content')



<div class="container">

	<div class="row">
	<div class="col-md-4 col-md-offset-4">

	{{-- <button class="button social-login via-twitter"><i class="fa fa-twitter"></i> Log In With Twitter</button>
	<button class="button social-login via-gplus"><i class="fa fa-google-plus"></i> Log In With Google Plus</button>
	<button class="button social-login via-facebook"><i class="fa fa-facebook"></i> Log In With Facebook</button> --}}

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40">

		<ul class="tabs-nav">
			<li class=""><a href="#tab1">Register</a></li>

		</ul>

		<div class="tabs-container alt">

			<!-- Login -->
			<div class="tab-content" id="tab1" style="display: none;">
				     <form method="POST" class="register" action="{{ route('registerPost') }}">
                        @csrf
					
				<p class="form-row form-row-wide">
					<label for="username2">Full Name:
						<i class="im im-icon-Male"></i>
						<input type="text" required class="input-text @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}"  />
                        
					</label>
				</p>
					
				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="im im-icon-Mail"></i>
                        <input type="email" required  class="input-text @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}"  />
					</label>
				</p>



                <p class="form-row form-row-wide">
					<label for="email2">Phone Number:
						<i class="fa fa-phone"></i>
                          <input type="phone" required  class="input-text @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}"  />
                        
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password1">Password:
						<i class="im im-icon-Lock-2"></i>
						
                         <input type="password" required class="input-text @error('password') is-invalid @enderror" name="password" id="password"   />
					</label>
				</p>

				

				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
				</p>

				</form>
			</div>

			<!-- Register -->
			

		</div>
	</div>



	</div>
	</div>

</div>

 

@endsection
