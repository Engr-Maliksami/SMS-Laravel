@extends('layouts.sitelayout')

@section('content')
<?php 
 
    $current_theme = getDefaultTheme();
   
   $page_content  = getThemeSetting($key,$current_theme); 
    // dd($page_content);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div style="padding: 0 15px">
 {!! $page_content !!}
</div>
</div>
</div>
</div>
@stop