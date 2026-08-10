<!DOCTYPE html>
@php
  use Illuminate\Support\Str;
  use App\Helpers\Helpers;

  $menuFixed =
      $configData['layout'] === 'vertical'
          ? $menuFixed ?? ''
          : ($configData['layout'] === 'front'
              ? ''
              : $configData['headerType']);
  $navbarType =
      $configData['layout'] === 'vertical'
          ? $configData['navbarType']
          : ($configData['layout'] === 'front'
              ? 'layout-navbar-fixed'
              : '');
  $isFront = ($isFront ?? '') == true ? 'Front' : '';
  $contentLayout = isset($container) ? ($container === 'container-xxl' ? 'layout-compact' : 'layout-wide') : '';

  // Get skin name from configData - only applies to admin layouts
  $isAdminLayout = !Str::contains($configData['layout'] ?? '', 'front');
  $skinName = $isAdminLayout ? $configData['skinName'] ?? 'default' : 'default';

  // Get semiDark value from configData - only applies to admin layouts
  $semiDarkEnabled = $isAdminLayout && filter_var($configData['semiDark'] ?? false, FILTER_VALIDATE_BOOLEAN);

  // Generate primary color CSS if color is set
  $primaryColorCSS = '';
  if (isset($configData['color']) && $configData['color']) {
      $primaryColorCSS = Helpers::generatePrimaryColorCSS($configData['color']);
  }

@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
  class="{{ $navbarType ?? '' }} {{ $contentLayout ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
  dir="{{ $configData['textDirection'] }}" data-skin="{{ $skinName }}" data-assets-path="{{ asset('/assets') . '/' }}"
  data-base-url="{{ url('/') }}" data-framework="laravel" data-template="{{ $configData['layout'] }}-menu-template"
  data-bs-theme="{{ $configData['theme'] }}" @if ($isAdminLayout && $semiDarkEnabled) data-semidark-menu="true" @endif>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#060913" />

  <title>@yield('title', config('variables.templateName') . ' - ' . config('variables.templateSuffix'))</title>
  <meta name="description" content="@yield('meta_description', config('variables.templateDescription'))" />
  <meta name="keywords" content="@yield('meta_keywords', config('variables.templateKeyword'))" />
  <meta name="author" content="{{ config('variables.creatorName') }}" />
  <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')" />

  <!-- Local SEO Geo Meta Tags -->
  <meta name="geo.region" content="BD-58" />
  <meta name="geo.placename" content="Ranisankail, Thakurgaon" />
  <meta name="geo.position" content="25.8858;88.2678" />
  <meta name="ICBM" content="25.8858, 88.2678" />

  <!-- Open Graph / Facebook / WhatsApp -->
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:title" content="@yield('og_title', config('variables.ogTitle'))" />
  <meta property="og:description" content="@yield('og_description', config('variables.templateDescription'))" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:image" content="@yield('og_image', config('variables.ogImage'))" />
  <meta property="og:site_name" content="{{ config('variables.creatorName') }}" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="@yield('og_title', config('variables.ogTitle'))" />
  <meta name="twitter:description" content="@yield('og_description', config('variables.templateDescription'))" />
  <meta name="twitter:image" content="@yield('og_image', config('variables.ogImage'))" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ url()->current() }}" />

  <!-- Preconnect for CDNs and Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Favicon Icons for All Devices -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/branding/logo-light-icon.png') }}?v=2" />
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/branding/logo-light-icon.png') }}?v=2" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/branding/logo-light-icon.png') }}?v=2" />
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/branding/logo-light-icon.png') }}?v=2" />

  <!-- Include Styles -->
  @include('layouts/sections/styles' . $isFront)

  @if (
      $primaryColorCSS &&
          (config('custom.custom.primaryColor') ||
              isset($_COOKIE['admin-primaryColor']) ||
              isset($_COOKIE['front-primaryColor'])))
    <!-- Primary Color Style -->
    <style id="primary-color-style">
      {!! $primaryColorCSS !!}
    </style>
  @endif

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes' . $isFront)

  @yield('head_extra')
</head>

<body>
  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  @include('layouts/sections/scripts' . $isFront)
</body>

</html>
