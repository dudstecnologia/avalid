<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link href="{{ mix('/css/app.css') }}?v={{ time() }}" rel="stylesheet" />
		<script src="{{ mix('/js/app.js') }}?v={{ time() }}" defer></script>
	</head>
	<body>
		@inertia
	</body>
</html>
