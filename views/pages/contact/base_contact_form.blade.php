<!DOCTYPE html>
<html>
<head>
  @section('head')
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
	<title>Contact form</title>
	 {!! HTML::script('packages/groovel/cmsgroovel/jquery/js/jquery-1.11.1.min.js') !!}
	 {!!HTML::style('packages/groovel/cmsgroovel/bootstrap/css/bootstrap.min.css')!!}
	 {!! HTML::script('packages/groovel/cmsgroovel/bootstrap/js/bootstrap.js') !!}
	 {!!HTML::style('packages/groovel/cmsgroovel/groovel/admin/css/dashboard.css')!!}
  @show
</head>
<body>
   @include('cmsgroovel.pages.contact.core_contact_form')

 
</body>
</html>

