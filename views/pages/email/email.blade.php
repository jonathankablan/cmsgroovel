<!--This is a blade template that goes in email message -->
<?php
$body=\Session::get('body');
$pseudo=\Session::get('pseudo');
$author=\Session::get('author');
?> 

<h1>Hi {!!$pseudo!!} </h1>

<p>
{!!$body!!}
</p>
<br/>
Yours
{!!$author!!}