<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', session()->get('locale', app()->getLocale())) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @routes
</head>
<body>
<div id="app">
</div>
<script type="text/javascript">
</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&libraries=places"
    defer
></script>

</body>
</html>
