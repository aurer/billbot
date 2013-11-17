<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0">
	<title>{{ Config::get('application.name') }} / @yield('pagetitle')</title>
	{{ HTML::style('assets/css/main.css'); }}
	{{ HTML::style('assets/plugins/font-awesome/css/font-awesome.min.css'); }}
	@yield('head')
</head>