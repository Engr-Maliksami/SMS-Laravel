@extends('layouts.sitelayout')

@section('content')

   <div class="cs-gray-bg" style="margin-top: 101px;">
        <div class="container">
            <div class="row cs-row">
                <!-- Side Bar -->
                <div class="col-md-3">
                    <!-- Icon List  -->
                    <ul class="cs-icon-list">

                    @if(count($lms_cates))

                         @foreach($lms_cates as $category)

                          <li id={{$category->slug}}><a href="{{URL_VIEW_ALL_LMS_CATEGORIES.'/'.$category->slug}}">{{$category->category}}</a></li>

                          @endforeach

	                   @else

	                     <h4>{{getPhrase('no_categories_are_available')}}</h4> 

	               @endif 
                       
                    </ul>
                    <!-- /Icon List  -->
                </div>
                <!-- Main Section -->
                 @if(count($all_series))
                <div class="col-md-9">
                    <!-- Product Filter Bar -->
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="cs-filter-bar clearfix">
                                <li class="active"><a href="#">{{$title}} {{getPhrase('series')}}</a></li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Products Grid -->
                    <div class="row">
                
                    @foreach($all_series as $series)	
                        <div class="col-md-4 col-sm-6">
                        <!-- Product Single Item -->
                       <div class="cs-product cs-animate">
                            <a href="{{URL_VIEW_LMS_CONTENTS.$series->slug}}">
                                <div class="cs-product-img">
                                    @if($series->image)
                                    <img src="{{IMAGE_PATH_UPLOAD_LMS_SERIES.$series->image}}" alt="exam" class="img-responsive">
                                    @else
                                    <img src="{{IMAGE_PATH_EXAMS_DEFAULT}}" alt="exam" class="img-responsive">
                                    @endif
                                </div>
                            </a>
                            <div class="cs-product-content mt-0">
                             <a href="{{URL_VIEW_LMS_CONTENTS.$series->slug}}" class="cs-product-title">{{ucfirst($series->title)}}</a>

                               <div class="text-center mt-2">
                                 <a href="{{URL_VIEW_LMS_CONTENTS.$series->slug}}" class=" btn btn-blue btn-sm btn-radius">View </a>
                            </div>
                            </div>
                            
                        </div>
                        <!-- /Product Single Item -->
                    </div>
                     @endforeach   
                   
                       
                       
                    </div>
                    <!-- Pagination -->
              
                    <div class="row text-center">
                        <div class="col-sm-12">
                            <ul class="pagination cs-pagination ">
                                {{ $all_series->links() }}
                            </ul>
                        </div>
                    </div>
                    <!-- /Pagination -->
                    
                </div>
                 @endif
            </div>
        </div>
    </div>


  

@stop

@section('footer_scripts')

<script>
	var my_slug  = "{{$lms_cat_slug}}";

	if(!my_slug){

        $(".cs-icon-list li").first().addClass("active");
    }
    else{

    	$("#"+my_slug).addClass("active");
    }


    

</script>
 
 
 
@stop