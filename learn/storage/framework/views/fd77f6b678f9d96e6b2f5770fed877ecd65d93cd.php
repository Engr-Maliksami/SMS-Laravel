
<link href="<?php echo e(CSS); ?>bootstrap-datepicker.css" rel="stylesheet">	
<link rel="stylesheet" type="text/css" href="<?php echo e(CSS); ?>select2.css">

<style>
.select2-container--default .select2-selection--single {    border-color: #e1e8f8;
    border-radius: 0;
    box-shadow: none;
    font-size: 13px;
    min-height: 44px;
    padding-left: 12px;
    color: #353f4d;}
</style>

<?php $__env->startSection('content'); ?>

<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>

							<li><a href="<?php echo e(URL_QUIZZES); ?>"><?php echo e(getPhrase('quizzes')); ?></a></li>

							<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>

						</ol>

					</div>

				</div>

					<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

				<!-- /.row -->

				

				<div class="panel panel-custom" >

					<div class="panel-heading">

						<div class="pull-right messages-buttons">

							<a href="<?php echo e(URL_QUIZZES); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a>

						</div>

						

					<h1><?php echo e($title); ?>  </h1>

					</div>

					<div class="panel-body" >

					<?php $button_name = getPhrase('create'); ?>

					<?php if($record): ?>

					 <?php $button_name = getPhrase('update'); ?>

						<?php echo e(Form::model($record, 

						array('url' => URL_QUIZ_EDIT.'/'.$record->slug, 

						'method'=>'patch', 'files' => true, 'name'=>'formQuiz ', 'novalidate'=>'','files'=>TRUE))); ?>


					<?php else: ?>

						<?php echo Form::open(array('url' => URL_QUIZ_ADD, 'method' => 'POST', 'files' => true, 'name'=>'formQuiz ', 'novalidate'=>'','files'=>TRUE)); ?>


					<?php endif; ?>

					



					 <?php echo $__env->make('exams.quiz.form_elements', 

					 array('button_name'=> $button_name),

					 array(	'categories' 		=> $categories,

					 		'instructions' 		=> $instructions,

					 		'record'			=> $record,
					 		
					 		'exam_types'			=> $exam_types

					 		), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

					 		

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
 
<script src="<?php echo e(JS); ?>datepicker.min.js"></script>
 <script src="<?php echo e(JS); ?>select2.js"></script>

  

 <script>
 	  $('.input-daterange').datepicker({
        autoclose: true,
        startDate: "0d",
         format: '<?php echo e(getDateFormat()); ?>',
    });

 	   $('.select2').select2({
       placeholder: "Select",
    });
 </script>

<?php $__env->stopSection(); ?>

 

 
<?php echo $__env->make('layouts.admin.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>