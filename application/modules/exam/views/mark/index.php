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
                    <a href="<?php echo site_url('exam/mark/index'); ?>"><?php echo $this->lang->line('manage_mark'); ?></a>
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
                <?php echo form_open_multipart(site_url('exam/mark/index'), array('name' => 'mark', 'id' => 'mark', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                    
                    <div class="col-md-10 col-sm-10 col-xs-12">
                    
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
                            <div><?php echo $this->lang->line('section'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('subject'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="subject_id" id="subject_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                        </div>
                    </div>
                    </div>
                
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="find" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

           <?php  if (isset($students) && !empty($students)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-4  col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('exam_mark'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                 <?php echo form_open(site_url('exam/mark/add'), array('name' => 'addmark', 'id' => 'addmark', 'class'=>'form-horizontal form-label-left'), ''); ?>
               
                
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2"><?php echo $this->lang->line('roll_no'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('name'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('photo'); ?></th>
                            <?php if(isset($exam_types) && !empty($exam_types)) { 
                                
                                 ?>
                            
                                    <?php foreach ($exam_types as $obj) { ?>
                                      <th colspan="2"><?php echo $obj->exam_type_name; ?></th>
                                      <input type="hidden" name = "exam[]" value ="<?php echo str_replace(' ', '_', $obj->exam_type_name); ?>" >
                                      <input type="hidden" name = "exam_type_id[]" value ="<?php echo $obj->exam_type_id; ?>" >
                                      <input type="hidden" name = "max_marks[]" value ="<?php echo $obj->max_marks; ?>" >
                                    <?php } ?>

                                    <?php foreach ($marks_details as $details_data) { ?>
                                      
                                      <input type="hidden" name = "marks_details[]" value ="<?php echo $details_data->id; ?>" >
                                    <?php } ?>

                                <?php } else{  ?>
                                    <th colspan="2"><?php echo $this->lang->line('written'); ?></th>                                            
                                    <th colspan="2"><?php echo $this->lang->line('tutorial'); ?></th>                                            
                                    <th colspan="2"><?php echo $this->lang->line('practical'); ?></th>                                            
                                    <th colspan="2"><?php echo $this->lang->line('viva'); ?></th>
                                <?php }?>
                                                                         
                            <th colspan="2"><?php echo $this->lang->line('total'); ?></th>                                            
                            <th rowspan="2"><?php echo $this->lang->line('grade'); ?></th>                                            
                            <th rowspan="2"><?php echo $this->lang->line('comment'); ?></th>                                            
                        </tr>
                        <tr>                           
                          
                            <?php if(isset($exam_types) && !empty($exam_types)) { ?>
                                    <?php foreach ($exam_types as $obj) { ?>
                                        <th><?php echo $this->lang->line('mark'); ?></th>
                                        <th><?php echo $this->lang->line('obtain'); ?></th>    
                                    <?php } ?>
                                <?php } else{ ?>
                                    <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                    <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                    <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                    <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                    <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                    <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                    <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                    <th><?php echo $this->lang->line('obtain'); ?></th>

                                <?php } ?>
                                                                    
                            <th><?php echo $this->lang->line('mark'); ?></th>                                            
                            <th><?php echo $this->lang->line('obtain'); ?></th>                                           
                                                                      
                        </tr>
                    </thead>
                    <tbody id="fn_mark">   
                        <?php
                        $count = 1;
                        //echo '<pre>';print_r($exam_types);die();
                        if (isset($students) && !empty($students) && !empty($exam_types) ) {
                            ?>

                            <?php foreach ($students as $key=>$obj) { ?>
                            <?php  $mark = get_exam_mark($school_id, $obj->student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id); ?>
                            <?php  $attendance = get_exam_attendance($school_id, $obj->student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id); ?>
                                <tr>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td><?php echo ucfirst($obj->student_name); ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="40" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="40" /> 
                                        <?php } ?>
                                    </td>  
                                    <?php //echo '<pre>';print_r($exam_details);die();  
                                         foreach ($exam_details as $details) { 
                                                  if($details->student_id == $obj->student_id){ 
                                                     //echo $marks_obtained[$key];
                                                     // echo $key;
                                                    $details->exam_type_name = str_replace(' ', '_', $details->exam_type_name);
                                                      ?>
                                                          <!-- ------------- -->
                                    <td> 
                                        <input disabled type="number" id="<?php echo $details->exam_type_name.'_'.$obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>" value="<?php if(!empty($details->max_marks) && $details->max_marks > 0){ echo $details->max_marks; }else{ echo '';} ?>"
                                        min = "<?php if(!empty($details->max_marks) && $details->max_marks > 0){ echo $details->max_marks; }else{ echo '';} ?>" max = "<?php if(!empty($details->max_marks) && $details->max_marks > 0){ echo $details->max_marks; }else{ echo '';} ?>"  name="[<?php echo $details->exam_type_name.'_'.$obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total get_vals" required="required"  autocomplete="off"/>
                                    </td>
                             
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="<?php echo $details->exam_type_name.'_'.$obj->student_id; ?>"  itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($details->marks_obtained) && $details->marks_obtained > 0 ){ echo $details->marks_obtained; }else{ echo ''; } ?>" max = "<?php if(!empty($details->max_marks) && $details->max_marks > 0){ echo $details->max_marks; }else{ echo '';} ?>" min="0" name=<?php echo $details->exam_type_name; ?>[<?php echo $obj->student_id; ?>] class="form-control form-mark col-md-7 col-xs-12 mark_obtain fn_mark_total"   autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="[<?php echo $details->exam_type_name.'_'.$obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" />
                                        <?php } ?>
                                    </td>
                                                          <!-- ------------- -->
                                                  <?php } ?>
                                                
                                    <?php }  ?>
                                    
                                    <td>
                                    <input type="hidden" value="<?php echo $obj->student_id; ?>"  name="students[]" /> 
                                    <input type="hidden" value="<?php echo $mark->id; ?>"  name="marks_id[]" />
                                        <input type="number"   id="exam_total_mark_<?php echo $obj->student_id; ?>" value="<?php if($total){ echo $total; }else{ echo '';} ?>"  name="exam_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark remove"  autocomplete="off" />
                                    </td>
                                    <td> 
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"   id="obtain_total_mark_<?php echo $obj->student_id; ?>" value="<?php echo $marks_obtained[$key]; ?>"  name="obtain_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_obtain  remove"  autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="<?php echo $marks[$key]; ?>"  name="obtain_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_obtain" required="required"  autocomplete="off"/>
                                        <?php } ?>
                                    </td>                                    
                                    <td>
                                        <select  class="form-control col-md-7 col-xs-12" name="grade_id[<?php echo $obj->student_id; ?>]"  required="required">                                
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             <?php foreach ($grades as $grade) { ?>
                                            <option value="<?php echo $grade->id; ?>" <?php if(isset($mark) && $mark->grade_id == $grade->id){ echo 'selected="selected"';} ?>><?php echo $grade->name; ?> [<?php echo $grade->point; ?>]</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="text"  id="remark_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->remark != '' ){ echo $mark->remark; }else{ echo ''; } ?>"  name="remark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="text" value=""  name="remark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"   autocomplete="off"/>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="15" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>

                
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <?php  if (isset($students) && !empty($students)) { ?>
                            <input type="hidden" value="<?php echo $school_id; ?>"  name="school_id" />
                            <input type="hidden" value="<?php echo $exam_id; ?>"  name="exam_id" />
                            <input type="hidden" value="<?php echo $class_id; ?>"  name="class_id" />
                            <input type="hidden" value="<?php echo $section_id; ?>"  name="section_id" />
                            <input type="hidden" value="<?php echo $subject_id; ?>"  name="subject_id" />                        
                            <a href="<?php echo site_url('exam/mark'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                           <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('exam_mark_instruction'); ?></div>
                </div>
            </div> 
            
        </div>
    </div>
</div>
 
<!-- Super admin js START  -->
 <script type="text/javascript">
        
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>               
            $(".fn_school_id").trigger('change');
            $(".remove").css("pointer-events","none");
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
<script type="text/javascript">
			
			$('.mark_obtain').on('change', function() {
			  var data = $(this);
			  var itemid = $(this).attr('itemid')
			  var id = $(this).attr('id')
			  var class_id_obtain = 0;
			  var total_obtain = 0;
			
			   for (var i = 0; i < data.length;  i++) {
			        class_id_obtain = data[i].getAttribute('itemid');
			        total_obtain += parseFloat(data[i].value);
			    }
			
			  var all_data = document.getElementsByClassName("mark_obtain");
			
			  for(j = 0 ; j < all_data.length ; j++) {
			
			    var item_id = $(all_data[j]).attr('itemid')
			
			    if(item_id == itemid && all_data[j].id != id )
			        {   total_obtain += parseFloat($(all_data[j]).val());  }
			  }
			
			  $('#obtain_total_mark_'+class_id_obtain).val(total_obtain);   
			
			});
			
			
			//$('.get_vals').on('change', function() {
			$('.get_vals').click(function() { 
			  var data = $(this);
			  var itemid = $(this).attr('itemid')
			  var id = $(this).attr('id')
			  var class_id_obtain = 0;
			  var total_obtain = 0;
			
			   for (var i = 0; i < data.length;  i++) {
			        class_id_obtain = data[i].getAttribute('itemid');
			        total_obtain += parseFloat(data[i].value);
			    }
			
			  var all_data = document.getElementsByClassName("get_vals");
			
			  for(j = 0 ; j < all_data.length ; j++) {
			
			    var item_id = $(all_data[j]).attr('itemid')
			
			    if(item_id == itemid && all_data[j].id != id )
			        {   total_obtain += parseFloat($(all_data[j]).val());  }
			  }
			
			  $('#exam_total_mark_'+class_id_obtain).val(total_obtain);   
			
			});
			
			</script>
<style>
#datatable-responsive label.error{display: none !important;}
</style>



