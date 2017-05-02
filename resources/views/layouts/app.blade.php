<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <link rel="shortcut icon" href="http://billing.expodigital.com.my/wp-content/themes/thetechyhub/images/favicon.png">
        <link rel="stylesheet" href="http://billing.expodigital.com.my/wp-content/themes/thetechyhub/style.css" type="text/css" />

        <link rel='dns-prefetch' href='//s.w.org' />
        <script type="text/javascript">
            window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/svg\/","svgExt":".svg","source":{"concatemoji":"http:\/\/billing.expodigital.com.my\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.7.3"}};
            !function(a,b,c){function d(a){var b,c,d,e,f=String.fromCharCode;if(!k||!k.fillText)return!1;switch(k.clearRect(0,0,j.width,j.height),k.textBaseline="top",k.font="600 32px Arial",a){case"flag":return k.fillText(f(55356,56826,55356,56819),0,0),!(j.toDataURL().length<3e3)&&(k.clearRect(0,0,j.width,j.height),k.fillText(f(55356,57331,65039,8205,55356,57096),0,0),b=j.toDataURL(),k.clearRect(0,0,j.width,j.height),k.fillText(f(55356,57331,55356,57096),0,0),c=j.toDataURL(),b!==c);case"emoji4":return k.fillText(f(55357,56425,55356,57341,8205,55357,56507),0,0),d=j.toDataURL(),k.clearRect(0,0,j.width,j.height),k.fillText(f(55357,56425,55356,57341,55357,56507),0,0),e=j.toDataURL(),d!==e}return!1}function e(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g,h,i,j=b.createElement("canvas"),k=j.getContext&&j.getContext("2d");for(i=Array("flag","emoji4"),c.supports={everything:!0,everythingExceptFlag:!0},h=0;h<i.length;h++)c.supports[i[h]]=d(i[h]),c.supports.everything=c.supports.everything&&c.supports[i[h]],"flag"!==i[h]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[i[h]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
        </script>
        <style type="text/css">
img.wp-smiley,
img.emoji {
    display: inline !important;
    border: none !important;
    box-shadow: none !important;
    height: 1em !important;
    width: 1em !important;
    margin: 0 .07em !important;
    vertical-align: -0.1em !important;
    background: none !important;
    padding: 0 !important;
}
</style>
<link rel='stylesheet' id='grid-css'  href='http://billing.expodigital.com.my/wp-content/themes/thetechyhub/css/grid.css' type='text/css' media='all' />
<link rel='stylesheet' id='print-css'  href='http://billing.expodigital.com.my/wp-content/themes/thetechyhub/css/print.css' type='text/css' media='print' />
<link rel='https://api.w.org/' href='http://billing.expodigital.com.my/wp-json/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://billing.expodigital.com.my/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://billing.expodigital.com.my/wp-includes/wlwmanifest.xml" /> 
<link rel='prev' title='Su Ann Designs' href='http://billing.expodigital.com.my/quotation/su-ann-designs/' />
<link rel='next' title='Thank You Cards' href='http://billing.expodigital.com.my/quotation/thank-you-cards/' />
<meta name="generator" content="WordPress 4.7.3" />
<link rel="canonical" href="http://billing.expodigital.com.my/quotation/test-ignore/" />
<link rel='shortlink' href='http://billing.expodigital.com.my/?p=68' />
<link rel="alternate" type="application/json+oembed" href="http://billing.expodigital.com.my/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fbilling.expodigital.com.my%2Fquotation%2Ftest-ignore%2F" />
<link rel="alternate" type="text/xml+oembed" href="http://billing.expodigital.com.my/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fbilling.expodigital.com.my%2Fquotation%2Ftest-ignore%2F&#038;format=xml" />
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
        @include('layouts.nav')

        @yield('content')
    </div>
    <div class="container ">
        <div class="row footer">
        Copyright © 2017 - Expo Digital
        </div>
    </div>

    <script type='text/javascript' src='http://billing.expodigital.com.my/wp-includes/js/wp-embed.min.js?ver=4.7.3'></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
