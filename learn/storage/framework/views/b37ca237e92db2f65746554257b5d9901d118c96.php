	<input type="hidden" name="subject_id" value="<?php echo e($subject->id); ?>">
	<fieldset class="form-group ">
	<?php echo e(Form::label('topic_id', getphrase('topic'))); ?> <span class="text-red">*</span>
	
	<?php echo e(Form::select('topic_id', $topics, null, ['class'=>'form-control', "id"=>"topic_id"])); ?>

	</fieldset>

	<fieldset class="form-group">
		<?php echo e(Form::label('question', getphrase('question'))); ?> 
		<span class="text-red">*</span>
		
		<?php echo e(Form::textarea('question', $value = null , $attributes = array('class'=>'form-control ckeditor', 'placeholder' => 'Your question', 'rows' => '5',
		'ng-model'=>'question', 
		
		'ng-class'=>'{"has-error": formQuestionBank.question.$touched && formQuestionBank.question.$invalid}',
		'ng-minlength' => '4',
		 
		))); ?>

	<div class="validation-error" ng-messages="formQuestionBank.question.$error" >
		<?php echo getValidationMessage(); ?>

		<?php echo getValidationMessage('minlength'); ?>

	</div>
	</fieldset>

	<fieldset class="form-group">
		<?php echo e(Form::label('question_l2', getphrase('question_2nd_language'))); ?> 
		
		<?php echo e(Form::textarea('question_l2', $value = null , $attributes = array('class'=>'form-control ckeditor', 'placeholder' => 'Your question', 'rows' => '5',
		'ng-model'=>'question_l2', 
		'id'=>'question_l2',
		
		))); ?>

	
	</fieldset>

	<?php 
		$settingsObj 			= new App\GeneralSettings();
		$question_types 		= $settingsObj->getQuestionTypes();	
		$exam_max_options 		= $settingsObj->getExamMaxOptions();	
		$exam_difficulty_levels = $settingsObj->getDifficultyLevels();	


		?>
	<fieldset class="form-group ">
	<?php echo e(Form::label('question_type', getphrase('question_type'))); ?>

	<span class="text-red">*</span>
	<?php 
	$readonly = "";
	if($record)
	$readonly = "disabled";
	?>
	<?php echo e(Form::select('question_type',$question_types , null, ['class'=>'form-control', "id"=>"question_type", "ng-model"=>"question_type" ,
	 	'required'=> 'true', 
		'ng-class'=>'{"has-error": formQuestionBank.question_type.$touched && formQuestionBank.question_type.$invalid}',
		$readonly
	])); ?>

	<?php if($readonly) { ?>
	<input type="hidden" name="question_type" value="<?php echo e($record->question_type); ?>" >
	<?php } ?>
	<div class="validation-error" ng-messages="formQuestionBank.question_type.$error" >
		<?php echo getValidationMessage(); ?>

	 
	</div>
	</fieldset>



	<div  class="row">
	 <div class="col-md-6">
	 <fieldset class="form-group" >
         <?php echo e(Form::label('question_file', getPhrase('upload') )); ?> 
         {{question_type}} 
         <span ng-if="question_type=='video'"><?php echo e(getPhrase('supported_formats are')); ?> .mp4
         </span>
		 <span ng-if="question_type=='audio'"><?php echo e(getPhrase('supported_formats are')); ?> .mp3
         </span>

         <span ng-if="question_type!='audio' && question_type!='video'">(<?php echo e(getPhrase('supported_formats are')); ?>.jpeg, .jpg, .png)
         </span>
	

        <?php echo e(Form::file('question_file', $attributes = array('class'=>'form-control'))); ?>

        
    </fieldset>
	</div> 

<div class="col-md-6">
	<?php if($record): ?>
        <?php if($record->question_file): ?>  
    		<?php echo $__env->make('exams.questionbank.question_partial_image_preview', array('record'=>$record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    	<?php endif; ?>
    <?php endif; ?>
</div>
</div>
		
	<fieldset class="form-group ">
	<?php echo e(Form::label('difficulty_level', getphrase('difficulty_level'))); ?>

	<span class="text-red">*</span>

	<?php echo e(Form::select('difficulty_level',$exam_difficulty_levels , null, ['class'=>'form-control', "id"=>"difficulty_level" ])); ?>

	</fieldset>
	<fieldset class="form-group">
		<?php echo e(Form::label('hint', getphrase('hint'))); ?> 
		<?php echo e(Form::text('hint', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Hint for the question'))); ?>

	</fieldset>

	<fieldset class="form-group">
		<?php echo e(Form::label('explanation', getphrase('explanation'))); ?> 
		<?php echo e(Form::textarea('explanation', $value = null , $attributes = array('class'=>'form-control ckeditor', 'placeholder' => 'Your explanation', 'rows' => '5'))); ?>

	</fieldset>
	
	<fieldset class="form-group">
		<?php echo e(Form::label('explanation_l2', getphrase('explanation_2nd_language'))); ?> 
		<?php echo e(Form::textarea('explanation_l2', $value = null , $attributes = array('class'=>'form-control ckeditor', 'placeholder' => 'Your explanation_l2', 'rows' => '5','id'=>'explanation_l2'))); ?>

	</fieldset>



	<fieldset class="form-group">
		<?php echo e(Form::label('marks', getphrase('marks'))); ?> 
		<span class="text-red">*</span>
		<?php echo e(Form::number('marks', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '1',
			'min'=>'1',
		'ng-model'=>'marks', 
		'required'=> 'true', 
		'ng-class'=>'{"has-error": formQuestionBank.marks.$touched && formQuestionBank.marks.$invalid}',
		))); ?>

	<div class="validation-error" ng-messages="formQuestionBank.marks.$error" >
		<?php echo getValidationMessage(); ?>

		
	</div>
	</fieldset>
 

	<fieldset class="form-group">
		<?php echo e(Form::label('time_to_spend', getphrase('time_to_spend'))); ?> 
		<span class="text-red">*</span>
		<?php echo e(Form::number('time_to_spend', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('in_seconds'),
			'min'=>'1',
		'ng-model'=>'time_to_spend', 
		'required'=> 'true', 
		'ng-class'=>'{"has-error": formQuestionBank.time_to_spend.$touched && formQuestionBank.time_to_spend.$invalid}',
		))); ?>

	<div class="validation-error" ng-messages="formQuestionBank.time_to_spend.$error" >
		<?php echo getValidationMessage(); ?>

		
	</div>
	</fieldset>

	 
	
	<!-- Load the files start as independent -->
	<?php	

	 $image_path = ($record) ? PREFIX.(new ImageSettings())->getExamImagePath(): ''; ?>
	<?php echo $__env->make('exams.questionbank.form_elements_radio', array('image_path'=>$image_path), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('exams.questionbank.form_elements_checkbox', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('exams.questionbank.form_elements_blanks', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('exams.questionbank.form_elements_match', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php 
$show = TRUE;
	if($record) {
		if($record->question_type=='match')
			$show = FALSE;
		} 
		?>
		<?php if($show): ?>
	<?php echo $__env->make('exams.questionbank.form_elements_para', array('record'=>$record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
	

	<!-- Load the files end as independent -->
        <?php if(!$record): ?>
		<div class="buttons text-center">
			<button class="btn btn-lg btn-success button"
			ng-disabled='!formQuestionBank.$valid'><?php echo e($button_name); ?></button>
		</div>
		<?php else: ?>

		<div class="buttons text-center">
			<button class="btn btn-lg btn-success button"><?php echo e($button_name); ?></button>
		</div>
		<?php endif; ?>
 