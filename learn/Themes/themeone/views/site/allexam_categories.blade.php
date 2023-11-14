@extends('layouts.sitelayout')

@section('content')

   <div class="cs-gray-bg" style="margin-top: 101px;">
        <div class="container">
            <div class="row cs-row">
                <!-- Side Bar -->
                <div class="col-md-3">
                    <!-- Icon List  -->
                    <ul class="cs-icon-list">

                    @if(count($categories))

                         @foreach($categories as $category)

                          <li id={{$category->slug}}><a href="{{URL_VIEW_ALL_EXAM_CATEGORIES.'/'.$category->slug}}">{{$category->category}}</a></li>

                          @endforeach

	                   @else

	                     <h4>No Exams Are Available</h4> 

	               @endif 
                       
                    </ul>
                    <!-- /Icon List  -->
                </div>
                <!-- Main Section -->
            @if(count($quizzes))

                <div class="col-md-9">
                    <!-- Product Filter Bar -->
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="cs-filter-bar clearfix">
                                <li class="active"><a href="#">{{$title}} {{getPhrase('exams')}}</a></li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Products Grid -->
                    <div class="row">
                  
                    @foreach($quizzes as $quiz)	

                        <div class="col-md-4 col-sm-6">
                        <!-- Product Single Item -->
                       <div class="cs-product cs-animate">
                            <a href="{{URL_FRONTEND_START_EXAM.$quiz->slug}}">
                                <div class="cs-product-img">
                                    @if($quiz->image)
                                    <img src="{{IMAGE_PATH_EXAMS.$quiz->image}}" alt="exam" class="img-responsive">
                                    @else
                                    <img src="{{IMAGE_PATH_EXAMS_DEFAULT}}" alt="exam" class="img-responsive">
                                    @endif
                                </div>
                            </a>
                            <div class="cs-product-content">
                             <a href="{{URL_FRONTEND_START_EXAM.$quiz->slug}}" class="cs-product-title text-center">{{ucfirst($quiz->title)}}</a>





                              <ul class="cs-card-actions mt-0">
                                    <li>
                                        <a href="#">Marks : {{(int)$quiz->total_marks}}</a>
                                    </li>

                                    <li>  </li>

                                   
                                    <li class="cs-right">
                                        <a href="#">{{$quiz->dueration}} mins</a>

                                    </li>


                                </ul>
                                <div class="text-center mt-2">
                                     <a href="{{URL_FRONTEND_START_EXAM.$quiz->slug}}" class="btn btn-blue btn-sm btn-radius">Start Exam</a>
                                </div>
                            {{--   <a href="{{URL_FRONTEND_START_EXAM.$quiz->slug}}" class="cs-product-title pull-right">{{getPhrase('take_exam')}}</a> --}}
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
                                {{ $quizzes->links() }}
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
	var my_slug  = "{{$quiz_slug}}";

	if(!my_slug){

        $(".cs-icon-list li").first().addClass("active");
    }
    else{

    	$("#"+my_slug).addClass("active");
    }


    

</script>
 
 
 
@stop