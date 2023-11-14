<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('bulk_student_attendance'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
              
            <div class="x_content quick-link">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'attendance', 'student')){ ?>
                    <a href="<?php echo site_url('attendance/student'); ?>"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('attendance'); ?></a>
                <?php } ?>
                 <?php if(has_permission(VIEW, 'attendance', 'teacher')){ ?>
                   | <a href="<?php echo site_url('attendance/teacher'); ?>"><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('attendance'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'attendance', 'employee')){ ?>
                   | <a href="<?php echo site_url('attendance/employee'); ?>"><?php echo $this->lang->line('employee'); ?> <?php echo $this->lang->line('attendance'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'attendance', 'absentemail')){ ?>
                   | <a href="<?php echo site_url('attendance/absentemail/index'); ?>"><?php echo $this->lang->line('absent'); ?> <?php echo $this->lang->line('email'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'attendance', 'absentsms')){ ?>
                   | <a href="<?php echo site_url('attendance/absentsms/index'); ?>"><?php echo $this->lang->line('absent'); ?> <?php echo $this->lang->line('sms'); ?></a>                    
                <?php } ?>
            </div>     
            
            
            <div class="x_content"> 

                <?php echo form_open_multipart(site_url('attendance/student/bulk'), array('name' => 'bulk_attendance', 'id' => 'bulk_attendance', 'class' => 'form-horizontal form-label-left'), ''); ?>

                <div class="row">
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <?php $this->load->view('layout/school_list_filter'); ?>   
                        
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_subject_by_class(this.value,'','');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue; } ?>   
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?><span class="required"> *</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
                
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group">  
                            <div><?php echo $this->lang->line('month'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="month_no" id="month_no" value="<?php $month_no ?>" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <option value="01"><?php echo $this->lang->line('january'); ?>
                                </option>
                                <option value="02"><?php echo $this->lang->line('february'); ?>
                                </option>
                                <option value="03"><?php echo $this->lang->line('march'); ?>
                                </option>
                                <option value="04"><?php echo $this->lang->line('april'); ?>
                                </option>
                                <option value="05"><?php echo $this->lang->line('may'); ?>
                                </option>
                                <option value="06"><?php echo $this->lang->line('june'); ?>
                                </option>
                                <option value="07"><?php echo $this->lang->line('july'); ?>
                                </option>
                                <option value="08"><?php echo $this->lang->line('august'); ?>
                                </option>
                                <option value="09"><?php echo $this->lang->line('september'); ?>
                                </option>
                                <option value="10"><?php echo $this->lang->line('october'); ?>
                                </option>
                                <option value="11"><?php echo $this->lang->line('november'); ?>
                                </option>
                                <option value="12"><?php echo $this->lang->line('december'); ?>
                                </option>
                            </select>
                            <div class="help-block"><?php echo form_error('month'); ?></div>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send_data" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                      </div>
                    </div>
                    <div class = "row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12"><br/>
                            <!-- <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button> -->
                        <?php if($school_id) { ?>
                            <a id = "generate_csv_id" href="<?php echo ASSET_URL; ?>csv/bulk_attendance.csv"  class="btn btn-success btn-md"><?php echo $this->lang->line('generate_csv'); ?></a>

                        </div>
                    <?php } else { ?>
                            <a id = "generate_csv_id" href="<?php echo ASSET_URL; ?>csv/bulk_marks.csv"  class="btn btn-success btn-md inactiveLink"><?php echo $this->lang->line('generate_csv'); ?></a>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                </div>
                <?php echo form_close(); ?>
             </div>
            <?php if($school_id){ ?>
                <?php echo form_open_multipart(site_url('attendance/student/add_bulk_attendance'), array('name' => 'bulk_attendance', 'id' => 'bulk_attendance', 'class'=>'form-horizontal form-label-left'), ''); ?>
                <input class="form-control" type="hidden" name="final_school_id" id="final_school_id">
                <input class="form-control" type="hidden" name="final_class_id" id="final_class_id">
                <input class="form-control" type="hidden" name="final_section_id" id="final_section_id">
                <input class="form-control" type="hidden" name="final_month_no" value="<?php echo $month_no; ?>" id="final_month_no">
                <input class="form-control" type="hidden" name="final_days" value="<?php if($days){echo $days;} else{ echo '';} ?>" id="final_days">

                <div class = "row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class = "col-md-2 col-sm-2 col-xs-12">    <label ><?php echo $this->lang->line('csv_file'); ?>&nbsp;</label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="bulk_attendance"  id="bulk_attendance" type="file" required="required">
                                            </div>
                            
                        </div>
                    </div>
                </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
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
                    <li>First select the School, Class, Section and Month</li>
                    <li>Generate CSV file</li>
                    <li>Open the downloaded CSV file and enter student's attendance information with unique roll number</li>
                    <li>Followed by Student Name</li>
                    <li>In third column enter P for Present, A for Absent, L for Late</li>
                    <li>Example - 01 Student_name P</li>
                    <li>Save the edited CSV file</li>
                    <li>Upload updated attendance CSV file you just edited and submit</li>
                </ol>
            </div>
        </div>
        <?php } ?>   
            
        </div>
    </div>
</div>

 <!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 
<!-- Super admin js START  -->
 <script type="text/javascript">
   
    $('#date').datepicker();

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
    }

</script>

<script type="text/javascript">
  $('#send').click(function() {

        var section_id = $('#section_id').val();
         $("#final_section_id").val(section_id);
        var class_id = $('#class_id').val();
         $("#final_class_id").val(class_id);
        var school_id = $('#school_id').val();
         $("#final_school_id").val(school_id);
    });

</script>
<style>
.inactiveLink {
   pointer-events: none;
   cursor: default;
}
</style>






