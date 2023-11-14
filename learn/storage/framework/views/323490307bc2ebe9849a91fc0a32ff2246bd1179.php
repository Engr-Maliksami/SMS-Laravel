
<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="<?php echo e(URL_EXAM_TYPES); ?>"><?php echo e(getPhrase('exam_types')); ?></a> </li>
							<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>
						</ol>
					</div>
				</div>
				<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
				<div class="panel panel-custom col-lg-9 col-md-offset-2">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="<?php echo e(URL_EXAM_TYPES); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('exam_types')); ?></a>
						</div>
					<h1><?php echo e($title); ?>  </h1>
					</div>
					<div class="panel-body  form-auth-style" >
					
				     <?php echo e(Form::model($record, array('url' => URL_UPDATE_EXAM_TYPE.$record->code, 
						'method'=>'post', 'novalidate'=>'','name'=>'formCategories'))); ?>


					  <fieldset class="form-group col-md-6">
						
						<?php echo e(Form::label('title', getphrase('category_name'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_category_name'),
							'ng-model'=>'title', 
							'ng-pattern' => getRegexPattern('name'),
							'ng-minlength' => '2',
							'ng-maxlength' => '60',
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formCategories.title.$touched && formCategories.title.$invalid}',
							 
							))); ?>

							<div class="validation-error" ng-messages="formCategories.title.$error" >
	    					<?php echo getValidationMessage(); ?>

	    					<?php echo getValidationMessage('minlength'); ?>

	    					<?php echo getValidationMessage('maxlength'); ?>

	    					<?php echo getValidationMessage('pattern'); ?>

						</div>
					</fieldset>

					 <?php

                   $options  = array('1'=>'Yes',
                                     '0'=>'No');

                   ?>


					<fieldset class="form-group col-md-6" >
						<?php echo e(Form::label('status', getPhrase('is_active'))); ?>

						<span class="text-red">*</span>
						<?php echo e(Form::select('status', $options, null, ['placeholder' => getPhrase('select'),'class'=>'form-control', 
						'ng-model'=>'status',
							'required'=> 'true', 
							'ng-pattern' => getRegexPattern("name"),
							'ng-minlength' => '2',
							'ng-maxlength' => '20',
							'ng-class'=>'{"has-error": formCategories.status.$touched && formCategories.status.$invalid}',

						])); ?>

						<div class="validation-error" ng-messages="formCategories.status.$error" >
	    					<?php echo getValidationMessage(); ?>

						</div>


					</fieldset>

						<fieldset class="form-group col-md-12">
						
						<?php echo e(Form::label('description', getphrase('description'))); ?>

						
						<?php echo e(Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Description'))); ?>

					  </fieldset>

					  <div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formCategories.$valid'><?php echo e(getPhrase('update')); ?></button>
						</div>
				

					
					<?php echo Form::close(); ?>

					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
<?php $__env->stopSection(); ?>

 <?php $__env->startSection('footer_scripts'); ?>

  <?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>