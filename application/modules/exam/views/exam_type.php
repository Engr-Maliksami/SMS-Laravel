
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-graduation-cap"></i><small> <?php echo $this->lang->line('exam_type'); ?> </small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_exam_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('exam_type'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'exam', 'exam')){ ?>
                            
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('exam/exam_type_add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?>
                                <?php echo $this->lang->line('exam_type'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_exam"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('exam_type'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_exam"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('exam'); ?></a> </li>                          
                        <?php } ?> 
                            
                         <!-- <li class="li-class-list">
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?> 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_exam_by_school(this.value);">                                  
                                    <option value="">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>                                            
                                </select>
                            <?php } ?> 
                        </li>      -->
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
                                        
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?></th>   
                                                                             
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($exam_types) && !empty($exam_types)){ ?>
                                        <?php foreach($exam_types as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                
                                            <?php } ?>
                                            <td><?php echo $obj->name; ?></td>
                                            
                                            <td class="displayOneLine">
                                                <?php if(has_permission(EDIT, 'exam', 'exam')){ ?>
                                                    <a href="<?php echo site_url('exam/exam_type_edit/'.$obj->id); ?>"><i class="changeFaColor fa fa-pencil-square-o"></i> </a>
                                                <?php } ?>                                               
                                                <?php if(has_permission(DELETE, 'exam', 'exam')){ ?>
                                                    <a href="<?php echo site_url('exam/exam_type_delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('conirm_alert'); ?>');"><i class="changeFaColor fa fa-trash-o"></i></a>
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
                               <?php echo form_open(site_url('exam/exam_type_add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                        
                               <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('exam_type'); ?> <?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($post['title']) ?  $post['title'] : ''; ?>" placeholder="<?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('exam_type'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_exam">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('exam/exam_type_edit/'.$edit_exam_type[0]->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('exam_type'); ?> <?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($edit_exam_type[0]->name) ?  $edit_exam_type[0]->name : ''; ?>" placeholder="<?php echo $this->lang->line('exam_type'); ?> <?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="" name="id" />
                                        <a href="<?php echo site_url('exam/exam_type'); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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
     
  $('#add_start_date').datepicker();
  $('#edit_start_date').datepicker();
  
  </script> 
  
    <script type="text/javascript">
        // $(document).ready(function() {
        //   $('#datatable-responsive').DataTable( {
        //       dom: 'Bfrtip',
        //       iDisplayLength: 15,
        //       buttons: [
        //           'copyHtml5',
        //           'excelHtml5',
        //           'csvHtml5',
        //           'pdfHtml5',
        //           'pageLength'
        //       ],
        //       search: true,              
        //       responsive: true
        //   });
        // });
        
    function get_exam_by_school(school_id){          
        if(school_id){           
            window.location.href = '<?php echo site_url('exam/index/'); ?>'+school_id; 
        }else{
             window.location.href = '<?php echo site_url('exam/index'); ?>';
        }
    } 

    function get_class_by_school(school_id){
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
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
             data   : {school_id:school_id, class_id : class_id,  subject_id : subject_id},               
             async  : false,
             success: function(response){   
                                                                
                if(response)
                {                  
                    <?php if(isset($edit)){ ?>                
                          $('#edit_subject_id').html(response);
                    <?php }else{ ?> 
                          $('#treeview-checkbox').html(response);
                    <?php } ?> 
                }
             }
         });

         $('#edit_exam_type').show(); 
         $.ajax({       
             type   : "POST",
             url    : "<?php echo site_url('ajax/get_subject_by_class_school'); ?>",
             data   : {school_id:school_id, class_id : class_id,  subject_id : subject_id},               
             async  : false,
             success: function(response){   
                                                                
                if(response)
                {                  
                    $('#edit-treeview-checkbox').html(response);
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
<!-- // To be change by sarvesh -->

<style>
   .child-check{
 margin-left: 15px;
 display: none;
}.child-check.active{
 display: block;
 
}
#label_exam_type {
     display:none;
 }</style>