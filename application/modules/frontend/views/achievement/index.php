<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa fa-desktop"></i><small> <?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('Achievement'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content quick-link">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'frontend', 'frontend')){ ?>
                   <a href="<?php echo site_url('frontend/index'); ?>"><?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('page'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'frontend', 'slider')){ ?>
                   | <a href="<?php echo site_url('frontend/slider/index'); ?>"><?php echo $this->lang->line('manage_slider'); ?> </a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'frontend', 'Achievement')){ ?>
                   | <a href="<?php echo site_url('frontend/Achievement/index'); ?>"><?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('Achievement'); ?></a>
                <?php } ?>
               
                <?php if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>   
                    <?php if(has_permission(VIEW, 'setting', 'setting')){ ?>                   
                       | <a href="<?php echo site_url('setting'); ?>"><?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('setting'); ?></a>
                    <?php } ?>
                <?php }else{ ?>
                       <?php if(has_permission(VIEW, 'administrator', 'school')){ ?>   
                          | <a href="<?php echo site_url('administrator/school'); ?>"> <?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('setting'); ?></a>
                        <?php } ?>
                <?php } ?>
                   
                <?php if(has_permission(VIEW, 'announcement', 'notice')){ ?>
                   | <a href="<?php echo site_url('announcement/notice/index'); ?>"><?php echo $this->lang->line('manage_notice'); ?></a>
                <?php } ?>    
                <?php if(has_permission(VIEW, 'announcement', 'news')){ ?>
                   | <a href="<?php echo site_url('announcement/news/index'); ?>"><?php echo $this->lang->line('manage_news'); ?></a>
                <?php } ?>    
                <?php if(has_permission(VIEW, 'announcement', 'holiday')){ ?>
                   | <a href="<?php echo site_url('announcement/holiday/index'); ?>"><?php echo $this->lang->line('manage_holiday'); ?></a>                    
                <?php } ?>
                <?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
                  | <a href="<?php echo site_url('teacher/index'); ?>"><?php echo $this->lang->line('manage_teacher'); ?> </a>                    
                <?php } ?>   
                <?php if(has_permission(VIEW, 'hrm', 'employee')){ ?>
                   | <a href="<?php echo site_url('hrm/employee'); ?>"><?php echo $this->lang->line('manage_employee'); ?> / <?php echo $this->lang->line('staff'); ?></a>
                <?php } ?>   
                
                
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">                    
                <!--    <ul  class="nav nav-tabs bordered">
                    <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>     
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_achievement_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('Achievement'); ?>  <?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                    <?php } ?>  
                    </ul> -->
                    <br/>
                            <div class="x_content">
                                         <br>
                        <h1 align="center"> Achievement Section </h1>
                        <?php $avStatus = $achievement->status;
                             ?>
                        <br>
                                <form action="<?php echo site_url('frontend/achievement/index/');?>" method="post">
                                    <div class="row">
                                        <div class="col-md-1 form-group"></div> 
                                        <div class="col-md-4 form-group">   
                                            <img src="<?php echo base_url('assets/images/yes.jpeg')?>" width="100px" height="100px">    
                                            <input type="radio" <?php if($avStatus==1) echo 'checked';?> name="status" value="1"  > Want Achievement Section    
                                        </div>
                                        <div class="col-md-1 form-group"> </div>
                                        <div class="col-md-5 form-group">
                                            <img src="<?php echo base_url('assets/images/no.png')?>"height="100px" width="100px">
                                            <input type="radio" name="status" <?php if($avStatus==0) echo 'checked';?> value="0"> Don't Want Achievement Section
                                        </div>
                                        <br>
                                        <div align="center">
                                            <button id="send" type="submit" class="btn btn-success">
                                                <?php echo $this->lang->line('submit'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div>


                            

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



 <link href="<?php echo VENDOR_URL; ?>editor/jquery-te-1.4.0.css" rel="stylesheet">
 <script type="text/javascript" src="<?php echo VENDOR_URL; ?>editor/jquery-te-1.4.0.min.js"></script>
 
  <style type="text/css">
      .jqte_editor{height: 250px;}
  </style>
  
      