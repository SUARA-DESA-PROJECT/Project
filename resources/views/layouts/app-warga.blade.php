<!doctype html>
<html lang="en">
  <head>
  	<title>@yield('title', 'Suara Desa')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        #content {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin: 15px;
            padding: 25px;
        }
    </style>
    @yield('styles')
  </head>
  <body>
		<div class="wrapper d-flex align-items-stretch">
			@include('components.sidebar-warga')

			<!-- Page Content -->
			<div id="content" class="p-4 p-md-5 pt-5">
                @yield('content')
			</div>
		</div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
  </body>
</html> 