<nav id="header" class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{{ URL::to('') }}}">
			LaravelBase
		</a>
	</div>
	<div class="collapse navbar-collapse" id="bs-navbar-collapse">
		@if (Auth::check())
			<ul class="nav navbar-nav">
				<li class="{{{ (Request::is('auth') ? 'active' : '') }}}"><a href="{{{ URL::to('auth') }}}">Home</a></li>
				<li class="{{{ (Request::is('accounts') ? 'active' : '') }}}"><a href="{{{ URL::to('accounts') }}}">Accounts</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-avatar pull-right" style="padding-right:30px;">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span>{{{ Auth::user()->name }}}</span>
						<b class="caret hidden-xs-only"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{{ URL::to('auth') }}}">Setting</a></li>
						<li><a href="{{{ URL::to('auth') }}}">Profile</a></li>
						<li class="divider"></li>
						<li><a href="{{{ URL::to('auth/logout') }}}">Logout</a></li>
					</ul>
				</li>
			</ul>
		@else
			<ul class="nav navbar-nav">
				<li class="active"><a href="{{{ URL::to('') }}}">Home</a></li>
			</ul>
			<ul class="nav navbar-nav pull-right" style="padding-right:30px;">
				<li><a class="{{{ (Request::is('auth/login') ? 'active' : '') }}}" href="{{{ URL::to('auth/login') }}}">Login</a></li>
				<li class="divider"></li>
				<li><a class="{{{ (Request::is('auth/register') ? 'active' : '') }}}" href="{{{ URL::to('auth/register') }}}">Register</a></li>
			</ul>
		@endif
	</div>
</nav>