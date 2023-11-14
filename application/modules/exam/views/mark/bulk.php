<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_mark'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>   
            
              
            <div class="x_content quick-link">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'exam', 'mark')){ ?>
                    <a href="<?php echo site_url('exam/mark/bulk'); ?>"><?php echo $this->lang->line('manage_mark'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'examresult')){ ?>
                   | <a href="<?php echo site_url('exam/examresult/index'); ?>"><?php echo $this->lang->line('exam_term'); ?> <?php echo $this->lang->line('result'); ?></a>                 
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'finalresult')){ ?>
                   | <a href="<?php echo site_url('exam/finalresult/index'); ?>"><?php echo $this->lang->line('exam_final_result'); ?></a>                 
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'meritlist')){ ?>    
                   | <a href="<?php echo site_url('exam/meritlist/index'); ?>"><?php echo $this->lang->line('merit_list'); ?></a>                 
                <?php } ?>   
                <?php if(has_permission(VIEW, 'exam', 'marksheet')){ ?>     
                   | <a href="<?php echo site_url('exam/marksheet/index'); ?>"><?php echo $this->lang->line('mark_sheet'); ?></a>
                <?php } ?>
                 <?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
                   | <a href="<?php echo site_url('exam/resultcard/index'); ?>"><?php echo $this->lang->line('result_card'); ?></a>
                <?php } ?>   
                <?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
                   | <a href="<?php echo site_url('exam/resultcard/all'); ?>"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('result_card'); ?></a>
                <?php } ?>     
                <?php if(has_permission(VIEW, 'exam', 'mail')){ ?>
                   | <a href="<?php echo site_url('exam/mail/index'); ?>"><?php echo $this->lang->line('mark_send_by_email'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'text')){ ?>
                   | <a href="<?php echo site_url('exam/text/index'); ?>"><?php echo $this->lang->line('mark_send_by_sms'); ?></a>                  
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'resultemail')){ ?>
                   | <a href="<?php echo site_url('exam/resultemail/index'); ?>"> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('email'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'exam', 'resultsms')){ ?>
                   | <a href="<?php echo site_url('exam/resultsms/index'); ?>"> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('sms'); ?></a>                  
                <?php } ?>
            </div>      
            
            
            <div class="x_content"> 

                <?php echo form_open_multipart(site_url('exam/mark/bulk'), array('name' => 'mark', 'id' => 'mark', 'class' => 'form-horizontal form-label-left'), ''); ?>

                <div class="row">
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <?php $this->load->view('layout/school_list_filter'); ?>   
                        
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('exam'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($exams) && !empty($exams)) { ?>
                                    <?php foreach ($exams as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($exam_id) && $exam_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_subject_by_class(this.value,'','');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if (is_array($classes) || is_object($classes))
                                   {
                                      foreach ($classes as $obj) { ?>
                                    <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue; } ?>   
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                 <?php }
                                   }
                                ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('subject'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="subject_id" id="subject_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="get_data_send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                      </div>
                    </div>
                    <div class = "row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12"><br/>
                            <!-- <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button> -->
                        <?php if($exam_type){ ?>
                            <a id = "generate_csv_id" href="<?php echo ASSET_URL; ?>csv/bulk_marks.csv"  class="btn btn-success btn-md"><?php echo $this->lang->line('generate_csv'); ?></a>

                        </div>
                        
                        <?php } else { ?>
                            <a id = "generate_csv_id" href="<?php echo ASSET_URL; ?>csv/bulk_marks.csv"  class="btn btn-success btn-md inactiveLink"><?php echo $this->lang->line('generate_csv'); ?></a>

                        </div>
                    <?php } ?>
                    </div>
                </div>
                </div>
                <?php echo form_close(); ?>
             
            <?php if($exam_type){ ?>
                <?php echo form_open_multipart(site_url('exam/mark/bulk_add'), array('name' => 'bulk_marks', 'id' => 'bulk_marks', 'class'=>'form-horizontal form-label-left'), ''); ?>
                <input class="form-control" type="hidden" name="final_school_id" id="final_school_id">
                <input class="form-control" type="hidden" name="final_class_id" id="final_class_id">
                <input class="form-control" type="hidden" name="final_exam_id" id="final_exam_id">
                <input class="form-control" type="hidden" name="final_section_id" id="final_section_id">
                <input class="form-control" type="hidden" name="final_subject_id" id="final_subject_id">

                <div class = "row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class = "col-sm-6">    <label ><?php echo $this->lang->line('csv_file'); ?>&nbsp;</label>
                                            <div class="btn-file">
                                                <div class="btn btn-default"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?></div>
                                                <input  class="form-control col-md-7 col-xs-12"  name="bulk_marks"  id="bulk_marks" type="file" required="required">
                                            </div>
                            
                        
                </div>

            <div class="col-sm-6">
                <div class="form-group action_btns">
                    <a href="<?php echo site_url('exam/mark/bulk'); ?>" class="btn btn-primary">Cancel</a>
                    <button id="send" type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
            <?php echo form_close(); ?>		
	        <?php } ?> 		
			
	        <?php  $errors = $this->session->userdata('errors');		
	               if($errors) { ?>   		
			
	        <div class="col-md-12 col-sm-12 col-xs-12">		
	            <div class="errors"><strong>Errors: </strong> 		
	                <ol><br>		
	                    <?php foreach($errors as $upload_error){ ?>		
	                    <li><?php echo $upload_error ?></li>		
	                    <?php } ?>		
	                    <br>		
	                    NOTE : These particular entries were not added. Correct them and upload them again.                        		
	                </ol>
            </div>
            </div>		
			
	        <?php $this->session->unset_userdata('errors'); } 		
	        else { ?>     		
	            <div class="col-md-12 col-sm-12 col-xs-12">		
	            <div class="instructions"><strong>Instruction: </strong> 		
	                <ol>		
	                    <li>At first select the School, Exam, Class, Section and Subject</li>		
	                    <li>Generate CSV file</li>		
	                    <li>Open the downloaded CSV file and enter student's marks information with unique roll number</li>		
	                    <li>Then Student Name</li>		
	                    <li>Marks obtained in respectve exams</li>		
	                    <li>Example - Practical : 20</li>		
	                    <li>Save the edited CSV file</li>		
	                    <li>Upload again CSV file you just edited and submit</li>		
	                </ol>
            </div>

            </div>
        <?php } ?>    

          
                 
            
        </div>
    </div>
</div>
 
<!-- Super admin js START  -->
 <script type="text/javascript">
        
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>    
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var exam_id = '';
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            exam_id =  '<?php echo $exam_id; ?>';
            class_id =  '<?php echo $class_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_by_school'); ?>",
            data   : { school_id:school_id, exam_id:exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#exam_id').html(response);  
                   get_class_by_school(school_id,class_id); 
               }
            }
        });
    }); 

   function get_class_by_school(school_id, class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#class_id').html(response); 
               }
            }
        }); 
   }  
   
  </script>
<!-- Super admin js end -->

 <script type="text/javascript">     
  
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_section_subject_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>', '<?php echo $subject_id; ?>');
    <?php } ?>
    
    function get_section_subject_by_class(class_id, section_id, subject_id){       
        
        var school_id = $('#school_id').val();      
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        }); 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , subject_id: subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#subject_id').html(response);
               }
            }
        });         
    }
  
  $(document).ready(function(){
  
       $('#fn_total_mark').keyup(function(){         
            var student_id = $(this).attr('itemid');
          var written_mark       = $('#written_mark_'+student_id).val() ?  parseFloat($('#written_mark_'+student_id).val()) : 0;
          var written_obtain     = $('#written_obtain_'+student_id).val() ? parseFloat($('#written_obtain_'+student_id).val()) : 0;
          var tutorial_mark      = $('#tutorial_mark_'+student_id).val() ? parseFloat($('#tutorial_mark_'+student_id).val()) : 0;
          var tutorial_obtain    = $('#tutorial_obtain_'+student_id).val() ? parseFloat($('#tutorial_obtain_'+student_id).val()) : 0;
          var practical_mark     = $('#practical_mark_'+student_id).val() ? parseFloat($('#practical_mark_'+student_id).val()) : 0;
          var practical_obtain   = $('#practical_obtain_'+student_id).val() ? parseFloat($('#practical_obtain_'+student_id).val()) : 0;
          var viva_mark          = $('#viva_mark_'+student_id).val() ? parseFloat($('#viva_mark_'+student_id).val()) : 0;
          var viva_obtain        = $('#viva_obtain_'+student_id).val() ? parseFloat($('#viva_obtain_'+student_id).val()) : 0;
          
          $('#exam_total_mark_'+student_id).val(written_mark+tutorial_mark+practical_mark+viva_mark);
          $('#obtain_total_mark_'+student_id).val(written_obtain+tutorial_obtain+practical_obtain+viva_obtain);
                              
       }); 
      
  }); 
  
 $("#mark").validate();  
 $("#addmark").validate();  
</script>
<script>
</script>
<script type="text/javascript">
  $('#send').click(function() {

        var exam_id = $('#exam_id').val();
         $("#final_exam_id").val(exam_id);
        var subject_id = $('#subject_id').val();
         $("#final_subject_id").val(subject_id);
        var section_id = $('#section_id').val();
         $("#final_section_id").val(section_id);
        var class_id = $('#class_id').val();
         $("#final_class_id").val(class_id);
        var school_id = $('#school_id').val();
         $("#final_school_id").val(school_id);
    });
  $('#get_data_send').click(function() {

        <?php
            // open the file "demosaved.csv" for writing
            $file = fopen('assets/csv/bulk_marks.csv', 'w');
            $exam[0] = '*Roll No';
            $exam[1] = '*Student Name';
            $i=2;
         if (is_array($exam_type) || is_object($exam_type)){
                foreach($exam_type as $type){
                    $exam[$i] = "*".$type->exam_type_name."_obtained";$i ++;
                }
                fputcsv($file, $exam);
            }   
            // Close the file
            fclose($file);
        ?>

          

  });
</script>
<script type="text/javascript">      
    $("#bulk_marks").validate();     
</script>
<style>
#datatable-responsive label.error{display: none !important;}
.inactiveLink {
   pointer-events: none;
   cursor: default;
}
</style>



