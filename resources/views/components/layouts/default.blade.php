<!DOCTYPE html>
<html lang="en" data-theme="mintlify">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Performance and Security -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Trends">
  
  <!-- Dynamic Title -->
  <title>{{ isset($title) ? $title . ' • Trends' : 'Trends • Connect, Share, Trend' }}</title>
  
  <!-- Meta Description -->
  <meta name="description" content="{{ isset($description) ? $description : 'Join Trends - the modern social media platform where you can connect with friends, share your thoughts, and discover what\'s trending worldwide.' }}">
  
  <!-- Favicon and App Icons -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/Trends_Logo.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
  <link rel="icon" href="{{ asset('images/Trends_Logo.png') }}" type="image/png">
  
  <!-- PWA Manifest -->
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  
  <!-- Theme Color -->
  <meta name="theme-color" content="#6366f1">
  <meta name="msapplication-TileColor" content="#6366f1">
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="{{ isset($title) ? $title . ' • Trends' : 'Trends • Connect, Share, Trend' }}">
  <meta property="og:description" content="{{ isset($description) ? $description : 'Join Trends - the modern social media platform where you can connect with friends, share your thoughts, and discover what\'s trending worldwide.' }}">
  <meta property="og:image" content="{{ asset('images/Trends_Logo.png') }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Trends">
  
  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ isset($title) ? $title . ' • Trends' : 'Trends • Connect, Share, Trend' }}">
  <meta name="twitter:description" content="{{ isset($description) ? $description : 'Join Trends - the modern social media platform where you can connect with friends, share your thoughts, and discover what\'s trending worldwide.' }}">
  <meta name="twitter:image" content="{{ asset('images/Trends_Logo.png') }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="max-w-4xl mx-auto px-4">
  {{ $slot }}
</body>

</html>