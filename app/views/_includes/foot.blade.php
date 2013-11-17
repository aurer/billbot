<div class="footer">
	<p class="copyright left">&copy; Phil Maurer {{ date('Y') }}</p>
	{{ HTML::script('assets/plugins/jquery/jquery-1.8.0.min.js'); }}
	@yield('scripts')
	@yield('footer')
</div>