<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" type="image/png" href="/img/icons/favicon.png" />

	@yield('styles')

	<title>@yield('title', config('app.name'))</title>
</head>

<body>
	<div class="wrapper">
		@yield('header')

		@yield('content')
	</div>
</body>

</html>