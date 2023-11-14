<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa fa-desktop"></i><small> <?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('about'); ?></small></h3>
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
                <?php if(has_permission(VIEW, 'frontend', 'about')){ ?>
                   | <a href="<?php echo site_url('frontend/about/index'); ?>"><?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('about'); ?></a>
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
             <h1> Do You want to show Achievement section in home page?? </h1>
              <br>
              <form method="post">
              <div class="row">
                <div class="col-md-6">
              <img height="100px" src="<?php echo base_url('assets/images/yes.jpg')?>">
              <input type="radio" name="yes" value="yes">Yes
              </div>
              <div class="col-md-6">
              <img height="100px" src="<?php echo base_url('assets/images/no.jpg')?>">
              <input type="radio" name="yes" value="no">No
              </div>
            </div>
          </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-frontend-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('about'); ?></h4>
        </div>
        <div class="modal-body fn_frontend_data">            
        </div>       
      </div>
    </div>
</div>

<script type="text/javascript">
         
    function get_frontend_modal(school_id){
         
        $('.fn_frontend_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('frontend/about/get_single_school'); ?>",
          data   : {school_id : school_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_frontend_data').html(response);
             }
          }
       });
    }
</script>


 <link href="<?php echo VENDOR_URL; ?>editor/jquery-te-1.4.0.css" rel="stylesheet">
 <script type="text/javascript" src="<?php echo VENDOR_URL; ?>editor/jquery-te-1.4.0.min.js"></script>
 <script type="text/javascript">
     
 $('#edit_about_text').jqte();
  
  $(document).ready(function() {
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
    
    $("#edit").validate();  
  </script> 
  
  <style type="text/css">
      .jqte_editor{height: 250px;}
  </style>
  
      