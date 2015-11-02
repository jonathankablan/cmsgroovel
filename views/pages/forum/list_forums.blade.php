@section('menu')
@include('cmsgroovel.layouts.groovel_admin_default')
@show
@section('content')
<div id='forums' style='margin-left:150px;margin-top:150px'>
     
@include('cmsgroovel.pages.forum.section.section_list_forums')
</div>