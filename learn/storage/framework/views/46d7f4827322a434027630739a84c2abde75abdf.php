
<link href="<?php echo e(CSS); ?>bootstrap-datepicker.css" rel="stylesheet">	
<?php $__env->startSection('content'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="<?php echo e(URL_EXAM_SERIES); ?>"><?php echo e(getPhrase('exam_series')); ?></a></li>
							<li class="active"><?php echo e(isset($title) ? $title : ''); ?></li>
						</ol>
					</div>
				</div>
					<?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<!-- /.row -->
				
				<div class="panel panel-custom col-lg-8  col-lg-offset-2" >
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="<?php echo e(URL_EXAM_SERIES); ?>" class="btn  btn-primary button" ><?php echo e(getPhrase('list')); ?></a>
						</div>
					<h1><?php echo e($title); ?>  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
					<?php if($record): ?>
					 <?php $button_name = getPhrase('update'); ?>
						<?php echo e(Form::model($record, 
						array('url' => URL_EXAM_SERIES_EDIT.$record->slug, 
						'method'=>'patch', 'files' => true, 'name'=>'formQuiz ', 'novalidate'=>''))); ?>

					<?php else: ?>
						<?php echo Form::open(array('url' => URL_EXAM_SERIES_ADD, 'method' => 'POST', 'files' => true, 'name'=>'formQuiz ', 'novalidate'=>'')); ?>

					<?php endif; ?>
					

					 <?php echo $__env->make('exams.examseries.form_elements', 
					 array('button_name'=> $button_name),
					 array('record'=>$record, 'categories' => $categories), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					 		
					<?php echo Form::close(); ?>

					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
 <?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
 <?php echo $__env->make('common.editor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
 <?php echo $__env->make('common.alertify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 <script src="<?php echo e(JS); ?>datepicker.min.js"></script>
    <script>
 	var file = document.getElementById('image_input');

file.onchange = function(e){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'jpg':
        case 'jpeg':
        case 'png':
            break;
        default:
            alertify.error("<?php echo e(getPhrase('file_type_not_allowed')); ?>");
            this.value='';
    }
};

 $('.input-daterange').datepicker({
        autoclose: true,
        startDate: "0d",
         format: '<?php echo e(getDateFormat()); ?>',
    });
 </script>
<?php $__env->stopSection(); ?>
 
 
<?php echo $__env->make('layouts.admin.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>