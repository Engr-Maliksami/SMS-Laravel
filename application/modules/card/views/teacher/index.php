<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-barcode"></i><small> <?php echo $this->lang->line('generate'); ?> <?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('id'); ?>  <?php echo $this->lang->line('card'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
              
            <div class="x_content quick-link no-print">
                <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                
                <?php if(has_permission(VIEW, 'card', 'idsetting')){ ?>
                     <a href="<?php echo site_url('card/idsetting/index'); ?>"><?php echo $this->lang->line('id'); ?> <?php echo $this->lang->line('card'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>    
                 <?php if(has_permission(VIEW, 'card', 'admitsetting')){ ?>
                      |  <a href="<?php echo site_url('card/admitsetting/index'); ?>"><?php echo $this->lang->line('admit'); ?> <?php echo $this->lang->line('card'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>  
                      
                <?php if(has_permission(VIEW, 'card', 'schoolidsetting')){ ?>
                    <a href="<?php echo site_url('card/schoolidsetting/index'); ?>"><?php echo $this->lang->line('id'); ?> <?php echo $this->lang->line('card'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>       
                <?php if(has_permission(VIEW, 'card', 'schooladmitsetting')){ ?>
                      | <a href="<?php echo site_url('card/schooladmitsetting/index'); ?>"><?php echo $this->lang->line('admit'); ?> <?php echo $this->lang->line('card'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>

                <?php if(has_permission(VIEW, 'card', 'teacher')){ ?>
                    | <a href="<?php echo site_url('card/teacher/index'); ?>"><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('id'); ?> <?php echo $this->lang->line('card'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'card', 'employee')){ ?>
                   | <a href="<?php echo site_url('card/employee/index'); ?>"><?php echo $this->lang->line('employee'); ?> <?php echo $this->lang->line('id'); ?> <?php echo $this->lang->line('card'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'card', 'student')){ ?>  
                   | <a href="<?php echo site_url('card/student/index'); ?>"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('id'); ?> <?php echo $this->lang->line('card'); ?></a>
                <?php } ?>  
                <?php if(has_permission(VIEW, 'card', 'admit')){ ?>  
                   | <a href="<?php echo site_url('card/admit/index'); ?>"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('admit'); ?> <?php echo $this->lang->line('card'); ?></a>
                <?php } ?>  
            </div>
            
            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('card/teacher/index'), array('name' => 'generate', 'id' => 'generate', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">

                    <?php $this->load->view('layout/school_list_filter'); ?>

                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('teacher'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12"  name="teacher_id"  id="teacher_id">
                                <option value="0"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('teacher'); ?></option>  
                                <?php if (isset($teachers) && !empty($teachers)) { ?>
                                    <?php foreach ($teachers as $obj) { ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if (isset($teacher_id) && $teacher_id == $obj->id) { echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
                                    <?php } ?> 
                                <?php } ?> 
                            </select>
                            <div class="help-block"><?php echo form_error('teacher_id'); ?></div>
                        </div>
                    </div>                
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('generate'); ?></button>
                        </div>
                    </div>

                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">                    
                    <ul  class="nav nav-tabs bordered no-print">                 
                        <li  class="active"><a href="#tab_teacher_list" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa fa-users"></i> <?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('list'); ?></a></li>                          
                    </ul>
                    <br/>
                    <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_teacher_list">
                            <div class="x_content">
                                
                               <div class="row">
                                   
                                   <?php if(isset($cards) && !empty($cards)){ ?>
                                        <?php foreach($cards as $obj){ ?>  

                                            <div class="card-block">
                                                <div class="card-top">
                                                    <div class="card-logo">
                                                        <?php  if($setting->school_logo != ''){ ?>
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->school_logo; ?>" alt="" /> 
                                                        <?php }else if($school->logo){ ?>
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                                                        <?php }else if($school->frontend_logo){ ?>
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                                                        <?php }else{ ?>                                                        
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                                                        <?php } ?>                                                          
                                                    </div>
                                                    <div class="card-school">
                                                        <h2><?php echo isset($setting->school_name) ? $setting->school_name : $school->school_name; ?></h2>
                                                        <p><?php echo isset($setting->school_address) && $setting->school_address != '' ? $setting->school_address : $school->address;; ?></p>
                                                        <p><?php echo $this->lang->line('phone'); ?>: <?php echo isset($setting->phone) && $setting->phone != '' ? $setting->phone : $school->phone;; ?></p>
                                                    </div>
                                                </div>
                                                <div class="std-id">
                                                    <h3><span><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('id'); ?>: <?php echo $obj->user_id; ?></span> </h3>
                                                </div>
                                                <div class="card-main">
                                                    <div class="card-photo">
                                                        <?php  if($obj->photo != ''){ ?>
                                                        <img src="<?php echo UPLOAD_PATH; ?>/teacher-photo/<?php echo $obj->photo; ?>" alt="" /> 
                                                        <?php }else{ ?>
                                                        <img src="<?php echo IMG_URL; ?>/default-user.png" alt=""  /> 
                                                        <?php } ?>
                                                    </div>
                                                    <div class="card-info">
                                                        <p><span class="card-title"><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('name'); ?></span><span class="card-value">: <?php echo $obj->name; ?></span></p>
                                                        <p><span class="card-title"><?php echo $this->lang->line('responsibility'); ?></span><span class="card-value">: <?php echo $obj->responsibility; ?></span></p>
                                                        <p><span class="card-title"><?php echo $this->lang->line('blood_group'); ?></span><span class="card-value">: <?php echo $this->lang->line($obj->blood_group); ?></span></p>
                                                        <p><span class="card-title"><?php echo $this->lang->line('birth_date'); ?></span><span class="card-value">: <?php echo date($this->global_setting->date_format, strtotime($obj->dob)); ?></span></p>
                                                        <p><span class="card-title"><?php echo $this->lang->line('join_date'); ?></span><span class="card-value">: <?php echo date($this->global_setting->date_format, strtotime($obj->joining_date)); ?></span></p>
                                                    </div>
                                                </div>
                                                <div class="card-bottom">
                                                    <p><?php echo isset($setting->bottom_text) ? $setting->bottom_text : ''; ?></p>
                                                </div>
                                            </div>

                                       <?php } ?>
                                   <?php } ?>
                                    
                               </div>
                                
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-print"></div>
            <div class="ln_solid no-print"></div>
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            
        </div>
    </div>
</div>

<link href="<?php echo CSS_URL; ?>card.css" rel="stylesheet">
<?php $this->load->view('layout/card'); ?>   
<!-- Super admin js START  -->
<script type="text/javascript">

    $("document").ready(function () {
        <?php if (isset($school_id) && !empty($school_id)) { ?>
            $("#school_id").trigger('change');
        <?php } ?>
    });

    $('#school_id').on('change', function () {

        var school_id = $(this).val();
        var teacher_id = '';
        <?php if (isset($school_id) && !empty($school_id)) { ?>
            teacher_id = '<?php echo $teacher_id; ?>';
        <?php } ?>

        if (!school_id) {
            toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
           return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/get_teacher_by_school'); ?>",
            data: {school_id: school_id, teacher_id: teacher_id, is_all:true},
            async: false,
            success: function (response) {
                if (response)
                {
                    $('#teacher_id').html(response);
                }
            }
        });
    });

</script>
<!-- Super admin js end -->


<script type="text/javascript">
    $("#generate").validate();
</script> 
