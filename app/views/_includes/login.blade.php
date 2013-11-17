@if( !Auth::check() )
	<form action="" class="login clearfix" method="post">
		<div class="field required clearfix">
			{{ Form::label('__username', 'Username') }}
			{{ Form::input('text', '__username', Input::old('__username')) }}
		</div>
		<div class="field required clearfix">
			{{ Form::label('__password', 'Password') }}
			{{ Form::password('__password') }}
		</div>
		@if( Session::get('login-message') )
			<div class="field">
				<p class="error clearfix">{{ Session::get('login-message') }}</p>
			</div>
		@endif
		<div class="submit">
			<button type="submit" class="btn"><i class="icon-">&#xf0a9;</i> Login</button>
		</div>
		<a class="btn btn-sub" href="/user/join">Sign up</a>
		<p><small><a class="small" href="/user/reset">Reset password</a></small></p>
	</form>
@else
	<p class="logged-in">
		<a class="icon user" title="Logged in" href="/user"><i class="icon-">&#xf013;</i>
			@if( Auth::user()->forename ) 
				{{ Auth::user()->forename }} {{ Auth::user()->surname }}
			@else
				{{ Auth::user()->username }}
			@endif
		</a>
		<a class="icon logout" href="?logout=true"><i class="icon-">&#xf08b;</i> Logout</a>
</p>
@endif