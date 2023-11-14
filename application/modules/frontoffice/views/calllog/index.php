<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-tty"></i><small> <?php echo $this->lang->line('manage'); ?>  <?php echo $this->lang->line('call_log'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content quick-link">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'frontoffice', 'purpose')){ ?>   
                   <a href="<?php echo site_url('frontoffice/purpose/index'); ?>"><?php echo $this->lang->line('visitor'); ?> <?php echo $this->lang->line('purpose'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'frontoffice', 'visitor')){ ?>   
                   | <a href="<?php echo site_url('frontoffice/visitor/index'); ?>"><?php echo $this->lang->line('visitor_info'); ?></a>                         
                <?php } ?>                                 
                <?php if(has_permission(VIEW, 'frontoffice', 'calllog')){ ?>   
                   | <a href="<?php echo site_url('frontoffice/calllog/index'); ?>"><?php echo $this->lang->line('call_log'); ?></a>                         
                <?php } ?>                                 
                <?php if(has_permission(VIEW, 'frontoffice', 'dispatch')){ ?>   
                   | <a href="<?php echo site_url('frontoffice/dispatch/index'); ?>"><?php echo $this->lang->line('postal'); ?> <?php echo $this->lang->line('dispatch'); ?></a>                        
                <?php } ?>                                 
                <?php if(has_permission(VIEW, 'frontoffice', 'receive')){ ?>   
                   | <a href="<?php echo site_url('frontoffice/receive/index'); ?>"><?php echo $this->lang->line('postal'); ?> <?php echo $this->lang->line('receive'); ?></a>                        
                <?php } ?>              
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_calllog_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('call_log'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'frontoffice', 'calllog')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('frontoffice/calllog/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('call_log'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_calllog"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?>  <?php echo $this->lang->line('call_log'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_calllog"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('call_log'); ?></a> </li>                          
                        <?php } ?>
                            
                        <li class="li-class-list">
                          
                        </li>     
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_calllog_list" >
                            <div class="x_content">
                            <div class="row school-select-btn"><div class="col-md-10"></div><div class="col-md-2">
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_calllog_by_school(this.value);">
                                        <option value="<?php echo site_url('frontoffice/calllog/index'); ?>">--<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('frontoffice/calllog/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>  </div></div>

                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('call_type'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('call_duration'); ?></th>
                                        <th><?php echo $this->lang->line('call_date'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php  $count = 1; if(isset($calllogs) && !empty($calllogs)){ ?>
                                        <?php foreach($calllogs as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $this->lang->line($obj->call_type); ?></td>
                                            <td><?php echo $obj->name; ?></td>
                                            <td><?php echo $obj->phone; ?></td>
                                            <td><?php echo $obj->call_duration; ?></td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->call_date)); ?></td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'frontoffice', 'calllog')){ ?>
                                                    <a href="<?php echo site_url('frontoffice/calllog/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(VIEW, 'frontoffice', 'calllog')){ ?>
                                                    <a  onclick="get_calllog_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-calllog-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>    
                                                <?php if(has_permission(DELETE, 'frontoffice', 'calllog')){ ?>
                                                    <a href="<?php echo site_url('frontoffice/calllog/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_calllog">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('frontoffice/calllog/add'), array('onSubmit'=> 'return add_checkform()','name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                <?php $this->load->view('layout/school_list_form'); ?> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($name) ?  $name : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('name'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="phone" value="<?php echo isset($phone) ?  $phone : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('phone'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="call_duration"><?php echo $this->lang->line('call_duration'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="call_duration"  id="call_duration" value="<?php echo isset($call_duration) ?  $call_duration : ''; ?>" placeholder="<?php echo $this->lang->line('call_duration'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('call_duration'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="call_date"><?php echo $this->lang->line('call_date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="call_date"  id="add_call_date" value="<?php echo isset($call_date) ?  date('d-m-Y', strtotime($call_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('call_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('call_date'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="next_follow_up"><?php echo $this->lang->line('follow_up'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="next_follow_up"  id="add_next_follow_up" value="<?php echo isset($next_follow_up) ?  date('d-m-Y', strtotime($next_follow_up)) : ''; ?>" placeholder="<?php echo $this->lang->line('follow_up'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('next_follow_up'); ?></div>
                                    </div>
                                </div>  
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="call_type"><?php echo $this->lang->line('call_type'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <?php echo $this->lang->line('incoming'); ?>:<input type="radio"  name="call_type" id="genderM" value="incoming" checked="" required /> 
                                         <?php echo $this->lang->line('outgoing'); ?>:<input type="radio" name="call_type" id="genderF" value="outgoing" />
                                        <div class="help-block"><?php echo form_error('call_type'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"> <?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note"  placeholder="<?php echo $this->lang->line('note'); ?>"> <?php echo isset($note) ?  $note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a  href="<?php echo site_url('frontoffice/calllog/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" purpose="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_calllog">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('frontoffice/calllog/edit/'.$calllog->id), array('onSubmit'=> 'return edit_checkform()','name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($calllog) ? $calllog->name : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('name'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="phone" value="<?php echo isset($calllog) ? $calllog->phone : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="number" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('phone'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="call_duration"><?php echo $this->lang->line('call_duration'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="call_duration"  id="call_duration" value="<?php echo isset($calllog) ? $calllog->call_duration : ''; ?>" placeholder="<?php echo $this->lang->line('call_duration'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('call_duration'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="call_date"><?php echo $this->lang->line('call_date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="call_date"  id="edit_call_date" value="<?php echo isset($calllog) ?  date('d-m-Y', strtotime($calllog->call_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('call_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('call_date'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="next_follow_up"><?php echo $this->lang->line('follow_up'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="next_follow_up"  id="edit_next_follow_up" value="<?php echo isset($calllog) ?  date('d-m-Y', strtotime($calllog->next_follow_up)) : ''; ?>" placeholder="<?php echo $this->lang->line('follow_up'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('next_follow_up'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="call_type"><?php echo $this->lang->line('call_type'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <?php echo $this->lang->line('incoming'); ?>:<input type="radio" name="call_type" id="genderM" value="incoming" <?php if(isset($calllog) && $calllog->call_type == 'incoming'){ echo 'checked="checked"'; } ?> required="required" /> 
                                         <?php echo $this->lang->line('outgoing'); ?>:<input type="radio"  name="call_type" id="genderF" value="outgoing" <?php if(isset($calllog) && $calllog->call_type == 'outgoing'){ echo 'checked="checked"'; } ?>  required="required" />
                                        <div class="help-block"><?php echo form_error('call_type'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"> <?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note"  placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($calllog) ? $calllog->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>                                   
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($calllog) ? $calllog->id : ''; ?>" name="id" />
                                        <a href="<?php echo site_url('frontoffice/calllog/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" purpose="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
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


<div class="modal fade bs-calllog-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('call_log'); ?> <?php echo $this->lang->line('detail'); ?></h4>
        </div>
        <div class="modal-body fn_calllog_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_calllog_modal(calllog_id){
         
        $('.fn_calllog_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('frontoffice/calllog/get_single_calllog'); ?>",
          data   : {calllog_id : calllog_id},  
          success: function(response){                                                   
            if(response)
            {
               $('.fn_calllog_data').html(response);
            }
          }
       });
    }
</script>




<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
<script type="text/javascript">
     
  $('#add_call_date').datepicker({   
      startDate: new Date()
  });
  $('#edit_call_date').datepicker({   
      startDate: new Date()
  });
  $('#add_next_follow_up').datepicker({   
      startDate: new Date()
  });
  $('#edit_next_follow_up').datepicker({   
      startDate: new Date()
  });

  function setInputFilter(textbox, inputFilter) { 
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if(this.hasOwnProperty("oldValue") && this.value=='') {
                    this.value = this.value;
                }else
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    setInputFilter(document.getElementById("phone"), function(value) {
        return /^[\d\(\)\-+ _]+$/.test(value);
    });

    setInputFilter(document.getElementById("call_duration"), function(value) {
        return /^[\d\(\)\-+ _]+$/.test(value);
    });
    

  
  function edit_checkform(){
        var startDate = $('#edit_call_date').val();
        var endDate = $('#edit_next_follow_up').val();
        var NewstartDate = startDate.split("-").reverse().join("-");
        var NewendDate = endDate.split("-").reverse().join("-");
     
         if (NewstartDate > NewendDate){
           swal({
                title: "Call Log",
                text: "Call Date should be less than Follow up Date",
                type: "error",
                confirmButtonText: "OK"
            });
           return false;
         }
         return true;
    }

    function add_checkform(){
        var startDate = $('#add_call_date').val();
        var endDate = $('#add_next_follow_up').val();
        var NewstartDate = startDate.split("-").reverse().join("-");
        var NewendDate = endDate.split("-").reverse().join("-");
     
         if (NewstartDate > NewendDate){
           swal({
                title: "Call Log",
                text: "Call Date should be less than Follow up Date",
                type: "error",
                confirmButtonText: "OK"
            });
           return false;
         }
         return true;
    }
  
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
        
    $("#add").validate();     
    $("#edit").validate(); 
    
    function get_calllog_by_school(url){          
        if(url){
            window.location.href = url; 
        }
     }  
</script>