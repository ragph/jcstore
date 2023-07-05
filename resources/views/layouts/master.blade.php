<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>JC Store</title>
  <link rel="stylesheet" href="{{asset('public/css/app.css')}}">
  <link rel="stylesheet" href="{{asset('public/app.css')}}">
  <link rel="stylesheet" href="{{asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/bower_components/multiselect/vue-multiselect.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/bower_components/icheck/icheck-bootstrap.min.css')}}">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
</head>
<body>
<div class="wrapper" id="app">
 <header-bar></header-bar>
    <div class="container-fluid">
        <div class="content" style="margin-top:30px;">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
<!-- <footer class="row">
@include('includes.footer')
</footer> -->
</div>
@auth
    <script>
        window.user = @json(auth()->user())
    </script>
 @endauth
<script src="{{asset('js/app.js')}}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>