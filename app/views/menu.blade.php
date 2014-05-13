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
				<li class="{{{ (Request::is('account') ? 'active' : '') }}}"><a href="{{{ URL::to('account') }}}">Inicio</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-avatar pull-right" style="padding-right:30px;">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span>{{{ Auth::user()->name }}}</span>
						<b class="caret hidden-xs-only"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{{ URL::to('account') }}}">Configuracion</a></li>
						<li><a href="{{{ URL::to('account') }}}">Perfil</a></li>
						<li class="divider"></li>
						<li><a href="{{{ URL::to('account/logout') }}}">Cerrar sesión</a></li>
					</ul>
				</li>
			</ul>
		@else
			<ul class="nav navbar-nav">
				<li class="active"><a href="{{{ URL::to('') }}}">Inicio</a></li>
			</ul>
			<ul class="nav navbar-nav pull-right" style="padding-right:30px;">
				<li><a class="{{{ (Request::is('account/register') ? 'active' : '') }}}" href="{{{ URL::to('account/register') }}}">Registrate!</a></li>
				<li class="divider"></li>
				<li><a class="{{{ (Request::is('account/login') ? 'active' : '') }}}" href="{{{ URL::to('account/login') }}}">Iniciar sesión</a></li>
			</ul>
		@endif
	</div>
</nav>