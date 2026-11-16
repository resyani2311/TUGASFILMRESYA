<!DOCTYPE html>
<html lang="id">

@include('templates.component.head')

<body>
<!-- header -->
@include('templates.component.header')
<!-- nav -->
@include('templates.component.navbar')
<!-- flash -->
@include('partials.flash')
@yield('content')
<!-- footer -->
@include('templates.component.footer')
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
<script>
	$(document).ready(function(){
		$(".movies_nav .dropdown").hover(
			function() {
				$('.dropdown-menu', this).stop( true, true ).slideDown("fast");
				$(this).addClass('open');
			},
			function() {
				$('.dropdown-menu', this).stop( true, true ).slideUp("fast");
				$(this).removeClass('open');
			}
		);
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
	});
</script>
@stack('scripts')
</body>
</html>
