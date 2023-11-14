
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-graduation-cap"></i><small> <?php echo $this->lang->line('exam_term'); ?> </small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'exam', 'grade')){ ?>
                    <a href="<?php echo site_url('exam/grade/'); ?>"><?php echo $this->lang->line('exam_grade'); ?></a>
                <?php } ?> 
                <?php if(has_permission(VIEW, 'exam', 'exam')){ ?>
                   | <a href="<?php echo site_url('exam/index'); ?>"><?php echo $this->lang->line('exam_term'); ?></a>
                <?php } ?> 
                <?php if(has_permission(VIEW, 'exam', 'schedule')){ ?>
                   | <a href="<?php echo site_url('exam/schedule/index'); ?>"><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('schedule'); ?></a>
                <?php } ?> 
                <?php if(has_permission(VIEW, 'exam', 'suggestion')){ ?>
                   | <a href="<?php echo site_url('exam/suggestion/index'); ?>"><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('suggestion'); ?> </a>
                <?php } ?> 
                <?php if(has_permission(VIEW, 'exam', 'attendance')){ ?>
                   | <a href="<?php echo site_url('exam/attendance/'); ?>"><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('attendance'); ?></a>                    
                <?php } ?> 
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_exam_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'exam', 'exam')){ ?>
                            
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('exam/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('exam'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_exam"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('exam'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_exam"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('exam'); ?></a> </li>                          
                        <?php } ?> 
                            
                         <li class="li-class-list" style="display:none">
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?> 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_exam_by_school(this.value);">                                  
                                    <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>                                            
                                </select>
                            <?php } ?> 
                        </li>     
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_exam_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?></th>
                                        <th><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('date'); ?></th>                                       
                                        <th><?php echo $this->lang->line('academic_year'); ?></th>                                       
                                        <th><?php echo $this->lang->line('note'); ?></th>                                       
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($exams) && !empty($exams)){ ?>
                                        <?php foreach($exams as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->title; ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->start_date)); ?></td>
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->note; ?></td>
                                            <td class="displayOneLine">
                                                <!-- <?php if(has_permission(EDIT, 'exam', 'exam')){ ?>
                                                    <a href="<?php echo site_url('exam/edit/'.$obj->id); ?>" ><i class="changeFaColor fa fa-pencil-square-o"></i>  </a>
                                                <?php } ?>  -->                                              
                                                <?php if(has_permission(DELETE, 'exam', 'exam')){ ?>
                                                    <a href="<?php echo site_url('exam/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('conirm_alert'); ?>');"><i class="changeFaColor fa fa-trash-o"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_exam">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('exam/add'), array('onSubmit'=> 'return add_checkform()','name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                

				<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                               <div class="item form-group"> 
                               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> <?php echo $this->lang->line('school'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">     
                               <select  class="form-control col-md-7 col-xs-12" onchange="get_class_by_school(this.value);" id="add_school_id" name="school_id" >                                  
                                    <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>                                            
                                </select>
				</div>
			       </div>
				<?php } ?>
                                
                               <div class="item form-group"> 
                               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> <?php echo $this->lang->line('class'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">     
                               <select  class="form-control col-md-7 col-xs-12 class_id" onchange="get_subject_by_class(this.value);"  id="class_id" name="class_id" >                                  
                                    <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('class'); ?>--</option> 
                                                                            
                                </select>
                                </div>
 
                               </div>
                               <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($post['title']) ?  $post['title'] : ''; ?>" placeholder="<?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>                                
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date"><?php echo $this->lang->line('start_date'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="start_date"  id="add_start_date" value="<?php echo isset($post['start_date']) ?  $post['start_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('start_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('start_date'); ?></div>
                                    </div>
                                </div>                  
                                
                                <!-- New dropdown start -->
                                
                                
                                <div  class="item form-group">
                                   <div id="label_exam_type" style:>
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date"><?php echo $this->lang->line('exam_type'); ?> <span class="required">*</span>
                                    </label>
                                   </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                       <div class="treeview-checkbox">

                                       </div>
                                   <div class="help-block"><?php echo form_error('subjects'); ?></div>      
 
                                    </div> 
                                </div>

                                <!-- New dropdown end -->

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('exam'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_exam">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('exam/edit/'.$exam->id), array('onSubmit'=> 'return edit_checkform()','name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                <div class="item form-group"> 
                               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> <?php echo $this->lang->line('school'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">     
                               <select  class="form-control col-md-7 col-xs-12" onchange="get_class_by_school(this.value);" id="edit_school_id" name="school_id" >                                  
                                    <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>                                            
                                </select>
                                </div>
 
                               </div>
                                
                               <div class="item form-group"> 
                               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"> <?php echo $this->lang->line('class'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">     
                               <select  class="form-control col-md-7 col-xs-12 class_id" onchange="get_subject_by_class(this.value);"   id="class_id" name="class_id" >                                  
                                    <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('class'); ?>--</option> 
                                    <?php foreach($classes as $class ){ ?>
                                        <option value="<?php echo $class->id; ?>" <?php if(isset($filter_class_id) && $filter_school_id == $class->id){ echo 'selected="selected"';} ?> > <?php echo $class->name; ?></option>
                                    <?php } ?> 
                                                                            
                                </select>
                                </div>
 
                               </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($exam->title) ?  $exam->title : ''; ?>" placeholder="<?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date"><?php echo $this->lang->line('start_date'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="start_date"  id="edit_start_date" value="<?php echo isset($exam->start_date) ?  date('d-m-Y', strtotime($exam->start_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('start_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('start_date'); ?></div>
                                    </div>
                                </div>
                                
                                <div  class="item form-group">
                                   <div id="label_exam_type" style:>
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date"><?php echo $this->lang->line('exam_type'); ?> <span class="required">*</span>
                                    </label>
                                   </div> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                       <div class="treeview-checkbox">
           
                                       </div>
      
 
                                    </div> 
                                </div>
                                                                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($exam->note) ?  $exam->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($exam) ? $exam->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('exam'); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet"> 
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">
     
  $('#add_start_date').datepicker({    
      startDate: new Date()
  });
  $('#edit_start_date').datepicker({   
      startDate: new Date()
  });
  
  function add_checkform(){
        var startDate = $('#add_date_from').val();
        var endDate = $('#add_date_to').val();
        var NewstartDate = startDate.split("-").reverse().join("-");
        var NewendDate = endDate.split("-").reverse().join("-");
     
         if (NewstartDate > NewendDate){
           swal({
                title: "Exam",
                text: "From Data should be less than To Date",
                type: "error",
                confirmButtonText: "OK"
            });
           return false;
         }
         return true;
    }

    function edit_checkform(){
        var startDate = $('#edit_date_from').val();
        var endDate = $('#edit_date_to').val();
        var NewstartDate = startDate.split("-").reverse().join("-");
        var NewendDate = endDate.split("-").reverse().join("-");
     
         if (NewstartDate > NewendDate){
            swal({
                title: "Exam",
                text: "From Data should be less than To Date",
                type: "error",
                confirmButtonText: "OK"
            });  
           return false;
         }
         return true;
    }
  </script> 
  
    <script type="text/javascript">
        $(document).ready(function() {
           
                <?php if(isset($edit)){?> 
            get_class_by_school('<?php echo $school_id; ?>','<?php echo $filter_class_id; ?>');
            get_subject_by_class('<?php echo $filter_class_id; ?>');
            <?php } ?>
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
        
    function get_exam_by_school(school_id){          
        if(school_id){           
            window.location.href = '<?php echo site_url('exam/index/'); ?>'+school_id; 
        }else{
             window.location.href = '<?php echo site_url('exam/index'); ?>';
        }
    } 

    function get_class_by_school(school_id,class_id){
        //alert(school_id);
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id <?php if(isset($edit)) { ?> ,class_id:class_id,type: school_id <?php }?> },               
            async  : false, 
            success: function(response){                                                   
               if(response)
               {  
                    $('.class_id').html(response);                     
               }
            }
        });
   }
 
   
    function get_sms_template_by_role(school_id, role_id){
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_sms_template_by_role'); ?>",
            data   : {school_id:school_id, role_id : role_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#fn_template').html(response); 
               }
            }
        }); 
   }


   function get_subject_by_class(class_id, subject_id){   
         var school_id = '';
        
         <?php if(isset($edit)){ ?>                   
             school_id = $('#edit_school_id').val();
          <?php }else{ ?> 
             school_id = $('#add_school_id').val();
          <?php } ?> 
              
         if(!school_id){
            toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
            return false;
         } 
          
         $('#label_exam_type').show(); 
         $.ajax({       
             type   : "POST",
             url    : "<?php echo site_url('ajax/get_subject_by_class_school'); ?>",
             data   : {school_id:school_id, class_id : class_id,  subject_id : subject_id<?php if(isset($edit)) { ?> ,exam_id: <?php  echo $exam_id;  }?> },               
             async  : false,
             success: function(response){   
                if(response)
                {                  
                    <?php if(isset($edit)){ ?>   
                          $('.treeview-checkbox').html(response);
                    <?php }else{ ?> 
                          $('.treeview-checkbox').html(response);
                    <?php } ?> 
                }
             }
         }); 
    }


    function get_exam_type_by_school(school_id){          
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_types_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                    $('#class_id').html(response);                     
               }
            }
        });
    }       
        
    $("#add").validate();     
    $("#edit").validate(); 
</script>
<!-- // To be change by  -->

<style>
   .child-check{
 margin-left: 15px;
 display: none;
}.child-check.active{
 display: block;
 
}
#label_exam_type {
   <?php if($edit){ ?>
        display:block;
  <?php }else {?> 
     display:none;
 <?php } ?>
 }
 
 
 </style>
