
<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="<?php echo e(PREFIX); ?>"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="<?php echo e(URL_QUIZ_QUESTIONBANK); ?>"><?php echo e(getPhrase('question_subjects')); ?></a></li>
							<li><a href="<?php echo e(URL_QUESTIONBANK_VIEW.$subject->slug); ?>"><?php echo e($subject->subject_title); ?></a></li>
							<li><?php echo e($title); ?></li>
						</ol>
					</div>
				</div>
					<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<!-- /.row -->
				<?php $settings = ($record) ? $settings : ''; ?>
				<div class="panel panel-custom  col-lg-12" ng-init="initAngData('<?php echo e($settings); ?>');"
				 ng-controller="questionsController">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="<?php echo e(URL_QUIZ_QUESTIONBANK); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a>
						</div>
					<h1><?php echo e($title); ?>  </h1>
					</div>
					<div class="panel-body" id="app">
					<?php $button_name = getPhrase('create'); ?>
					<?php if($record): ?>
					 <?php $button_name = getPhrase('update'); ?>
						<?php echo e(Form::model($record, 
						array('url' => URL_QUESTIONBANK_EDIT.'/'.$record->slug, 
						'method'=>'patch', 'files' => TRUE, 'name'=>'formQuestionBank ', 'novalidate'=>'',  'class'=>'validation-align'))); ?>

					<?php else: ?>
						<?php echo Form::open(array('url' => URL_QUESTIONBANK_ADD, 'method' => 'POST', 'files' => TRUE, 'name'=>'formQuestionBank ', 'novalidate'=>'', 'class'=>'validation-align')); ?>

					<?php endif; ?>

					 <?php echo $__env->make('exams.questionbank.form_elements', 
					 array('button_name'=> $button_name),
					 array('topics' => $topics, 'subject' => $subject, 'record'=>$record), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					 
					<?php echo Form::close(); ?>

					 

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
	<?php echo $__env->make('exams.questionbank.scripts.js-scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('common.validations', array('isLoaded'=>TRUE), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('common.editor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php if($record): ?>
		<?php if($record->question_type=='video'): ?>
			<?php echo $__env->make('common.video-scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	 	<?php endif; ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>