<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-gears"></i><small> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if(has_permission(VIEW, 'administrator', 'setting')){ ?>
                    <a href="<?php echo site_url('administrator/setting'); ?>"><?php echo $this->lang->line('general'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'school')){ ?>
                   | <a href="<?php echo site_url('administrator/school'); ?>"><?php echo $this->lang->line('manage_school'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'payment')){ ?>
                    | <a href="<?php echo site_url('administrator/payment'); ?>"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'sms')){ ?>
                    | <a href="<?php echo site_url('administrator/sms'); ?>"><?php echo $this->lang->line('sms'); ?> <?php echo $this->lang->line('setting'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'year')){ ?>
                    | <a href="<?php echo site_url('administrator/year'); ?>"><?php echo $this->lang->line('academic_year'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'role')){ ?>
                   | <a href="<?php echo site_url('administrator/role'); ?>"><?php echo $this->lang->line('user_role'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'permission')){ ?>
                   | <a href="<?php echo site_url('administrator/permission'); ?>"><?php echo $this->lang->line('role_permission'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'superadmin')){ ?>
                   | <a href="<?php echo site_url('administrator/superadmin'); ?>"><?php echo $this->lang->line('super_admin'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'user')){ ?>
                   | <a href="<?php echo site_url('administrator/user'); ?>"><?php echo $this->lang->line('manage_user'); ?></a>
                <?php } ?>
                <?php if(has_permission(EDIT, 'administrator', 'password')){ ?>
                   | <a href="<?php echo site_url('administrator/password'); ?>"><?php echo $this->lang->line('reset_user_password'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'usercredential')){ ?>
                   | <a href="<?php echo site_url('administrator/usercredential/index'); ?>"> <?php echo $this->lang->line('user'); ?> <?php echo $this->lang->line('credential'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'activitylog')){ ?>
                   | <a href="<?php echo site_url('administrator/activitylog'); ?>"><?php echo $this->lang->line('activity_log'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'feedback')){ ?>
                   | <a href="<?php echo site_url('administrator/feedback'); ?>"><?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('feedback'); ?></a>
                <?php } ?>
                <?php if(has_permission(VIEW, 'administrator', 'backup')){ ?>
                   | <a href="<?php echo site_url('administrator/backup'); ?>"><?php echo $this->lang->line('backup'); ?> <?php echo $this->lang->line('database'); ?></a>
                <?php } ?>
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">

                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_payment_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'administrator', 'payment')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('administrator/payment/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_payment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?> </a> </li>
                             <?php } ?>
                        <?php } ?>

                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_payment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?> </a> </li>
                        <?php } ?>
                    </ul>
                    <br/>

                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_payment_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('school'); ?></th>
                                        <th><?php echo $this->lang->line('paypal'); ?></th>
                                        <th><?php echo $this->lang->line('payumoney'); ?></th>
                                        <th><?php echo $this->lang->line('ccavenue'); ?></th>
                                        <th><?php echo $this->lang->line('paytm'); ?></th>
                                        <th><?php echo $this->lang->line('pay_stack'); ?></th>
                                        <th><?php echo $this->lang->line('pesapal'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; if(isset($payment_settings) && !empty($payment_settings)){ ?>
                                        <?php foreach($payment_settings as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $obj->school_name; ?></td>
                                            <td><?php echo $obj->paypal_status ? $this->lang->line('yes') : $this->lang->line('no') ; ?></td>
                                            <td><?php echo $obj->payumoney_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td><?php echo $obj->ccavenue_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td><?php echo $obj->paytm_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td><?php echo $obj->stack_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td><?php echo $obj->pesapal_status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td class="displayOneLine">
                                                <?php if(has_permission(VIEW, 'administrator', 'payment')){ ?>
                                                    <a  onclick="get_payment_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-payment-modal-lg" ><i class="changeFaColor fa fa-eye"></i> </a><br/>
                                                <?php } ?>
                                                <?php if(has_permission(EDIT, 'administrator', 'payment')){ ?>
                                                    <a href="<?php echo site_url('administrator/payment/edit/'.$obj->id); ?>" ><i class="changeFaColor fa fa-pencil-square-o"></i>  </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'administrator', 'payment')){ ?>
                                                    <a href="<?php echo site_url('administrator/payment/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" ><i class="changeFaColor fa fa-trash-o"></i>  </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_payment">
                            <div class="x_content">
                               <?php echo form_open_multipart(site_url('administrator/payment/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>

                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <?php $this->load->view('layout/school_list_form'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-3">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li  class="active"><a href="#tab_paypal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <!--<li  class=""><a href="#tab_stripe_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>-->
                                            <li  class=""><a href="#tab_pumoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <!--<li  class=""><a href="#tab_ccavenue_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>  -->
                                            <li  class=""><a href="#tab_paytm_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <li  class=""><a href="#tab_paystack_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>

                                            <li  class=""><a href="#tab_pesapal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>

                                        </ul>
                                      </div>
                                    <div class="col-xs-9">
                                        <div class="tab-content">

                                            <div class="tab-pane fade in active" id="tab_paypal_setting">

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_email"><?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('email'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_email" value="<?php echo isset($payment_setting) ? $payment_setting->paypal_email : ''; ?>"  placeholder="<?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('email'); ?>" required="required" type="email" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paypal_email'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paypal_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paypal_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paypal_demo'); ?></div>
                                                    </div>
                                                </div>
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_extra_charge"><?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->paypal_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paypal_extra_charge'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paypal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paypal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paypal_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.paypal.com" target="_blank"><img src="<?php echo IMG_URL; ?>paypal-setting.png" alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade in  display" id="tab_stripe_setting">
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_secret"><?php echo $this->lang->line('secret'); ?> <?php echo $this->lang->line('key'); ?> <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_secret" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_secret : ''; ?>"  placeholder="stripe_secret" required="required" type="text" autocomplete="off">
                                                      <div class="help-block"><?php echo form_error('stripe_secret'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_demo" required="required">
                                                          <option value="1" <?php if(isset($payment_setting) && $payment_setting->stripe_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                          <option value="0" <?php if(isset($payment_setting) && $payment_setting->stripe_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                      </select>
                                                      <div class="help-block"><?php echo form_error('stripe_demo'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_extra_charge"><?php echo $this->lang->line('stripe'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('stripe'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                      <div class="help-block"><?php echo form_error('stripe_extra_charge'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_status" required="required">
                                                          <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                          <option value="0" <?php if(isset($payment_setting) && $payment_setting->stripe_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                          <option value="1" <?php if(isset($payment_setting) && $payment_setting->stripe_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                      </select>
                                                      <div class="help-block"><?php echo form_error('stripe_status'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <a href="https://stripe.com/" target="_blank"><img src="<?php echo IMG_URL; ?>stripe-setting.png" alt="" /></a>
                                                  </div>
                                              </div>
                                            </div>

                                            <div class="tab-pane fade in " id="tab_pumoney_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_key"><?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_key" value="<?php echo isset($payment_setting) ? $payment_setting->payumoney_key : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('payumoney_key'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_salt"><?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_salt" value="<?php echo isset($payment_setting) ? $payment_setting->payumoney_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('payumoney_salt'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->payumoney_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->payumoney_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('payumoney_demo'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payu_extra_charge"><?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="payu_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->payu_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('payu_extra_charge'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->payumoney_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->payumoney_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('payumoney_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.payumoney.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paym-setting.png" alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade in display" id="tab_ccavenue_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_key"><?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_key" value="<?php echo isset($payment_setting) ? $payment_setting->ccavenue_key : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('ccavenue_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_salt"><?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_salt" value="<?php echo isset($payment_setting) ? $payment_setting->ccavenue_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('ccavenue_salt'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="ccavenue_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->ccavenue_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->ccavenue_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('ccavenue_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_extra_charge"><?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->ccavenue_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('extra_charge'); ?>"  type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('ccavenue_extra_charge'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="ccavenue_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->ccavenue_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->ccavenue_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('ccavenue_status'); ?></div>
                                                    </div>
                                                </div>
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.ccavenue.com/" target="_blank"><img src="<?php echo IMG_URL; ?>ccavenue-setting.png" alt="" /></a>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade in " id="tab_paytm_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_key"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_key" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_key : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_merchant_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_mid"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_mid'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_mid" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_mid : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_mid'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_merchant_mid'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_website"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('website'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_website" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_website : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('website'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_merchant_website'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_industry_type"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('industry_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_industry_type" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_industry_type : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('industry_type'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_industry_type'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paytm_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paytm_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paytm_demo'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_extra_charge"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_extra_charge'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paytm_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paytm_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paytm_status'); ?></div>
                                                    </div>
                                                </div>

                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://paytm.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paytm-setting.png" alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade in " id="tab_paystack_setting">
                                              <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_secret_key" value="<?php echo isset($payment_setting) ? $payment_setting->stack_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_public_key" value="<?php echo isset($payment_setting) ? $payment_setting->stack_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_demo" id="stack_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->stack_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->stack_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_extra_charge" id="stack_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->stack_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->stack_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->stack_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('stack_status'); ?></div>
                                                    </div>
                                                </div>


                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://paystack.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paystack-setting.png" alt="" /></a>
                                                        <div class="instructions">Nigeria & African Payment Gateway</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- pesapal setting table -->
                                            <div class="tab-pane fade in " id="tab_pesapal_setting">
                                              <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_consumer_key"><?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_key'); ?> <span class="required">*</span></label>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="pesapal_consumer_key" value="<?php echo isset($payment_setting) ? $payment_setting->pesapal_consumer_key : ''; ?>"  placeholder="<?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('pesapal_consumer_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_consumer_secret"><?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_secret'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="pesapal_consumer_secret" value="<?php echo isset($payment_setting) ? $payment_setting->pesapal_consumer_secret : ''; ?>"  placeholder="<?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_secret'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('pesapal_consumer_secret'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="pesapal_demo" id="pesapal_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->pesapal_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->pesapal_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('pesapal_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_extracharge"><?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="pesapal_extracharge" id="pesapal_extracharge" value="<?php echo isset($payment_setting) ? $payment_setting->pesapal_extracharge : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('pesapal_extracharge'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="pesapal_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->pesapal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->pesapal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('pesapal_status'); ?></div>
                                                    </div>
                                                </div>


                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.pesapal.com/" target="_blank"><img src="<?php echo IMG_URL; ?>pesapal-setting.png" alt="" /></a>
                                                        <div class="instructions">Tanzania Payment Gateway</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- pesapal setting tab end -->


                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a href="<?php echo site_url('administrator/payment/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                <button id="send" type="submit" class="btn btn-success"><?php  echo $this->lang->line('submit'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <?php if(isset($edit)){ ?>

                        <div class="tab-pane fade in active" id="tab_edit_payment">
                            <div class="x_content">
                               <?php echo form_open_multipart(site_url('administrator/payment/edit/'.$payment_setting->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>

                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-9">
                                        <?php $this->load->view('layout/school_list_edit_form'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-3">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li  class="active"><a href="#tab_edit_paypal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <!--<li  class=""><a href="#tab_edit_stripe_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('stripe'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>-->
                                            <li  class=""><a href="#tab_edit_pumoney_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <!--<li  class=""><a href="#tab_edit_ccavenue_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>-->
                                            <li  class=""><a href="#tab_edit_paytm_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <li  class=""><a href="#tab_edit_paystack_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                            <li  class=""><a href="#tab_edit_pesapal_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('setting'); ?></a> </li>
                                        </ul>
                                      </div>
                                    <div class="col-xs-9">
                                        <div class="tab-content">

                                            <div class="tab-pane fade in active" id="tab_edit_paypal_setting">

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_email"><?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('email'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_email" value="<?php echo isset($payment_setting) ? $payment_setting->paypal_email : ''; ?>"  placeholder="<?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('email'); ?>" required="required" type="email" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paypal_email'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paypal_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paypal_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paypal_demo'); ?></div>
                                                    </div>
                                                </div>
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_extra_charge"><?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paypal_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->paypal_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('paypal'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paypal_extra_charge'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paypal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paypal_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paypal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paypal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paypal_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.paypal.com" target="_blank"><img src="<?php echo IMG_URL; ?>paypal-setting.png" alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade in  display" id="tab_edit_stripe_setting">
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_secret"><?php echo $this->lang->line('secret'); ?> <?php echo $this->lang->line('key'); ?> <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_secret" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_secret : ''; ?>"  placeholder="stripe_secret" required="required" type="text" autocomplete="off">
                                                      <div class="help-block"><?php echo form_error('stripe_secret'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_demo" required="required">
                                                          <option value="1" <?php if(isset($payment_setting) && $payment_setting->stripe_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                          <option value="0" <?php if(isset($payment_setting) && $payment_setting->stripe_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                      </select>
                                                      <div class="help-block"><?php echo form_error('stripe_demo'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_extra_charge"><?php echo $this->lang->line('stripe'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <input  class="form-control col-md-7 col-xs-12"  name="stripe_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->stripe_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('stripe'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                      <div class="help-block"><?php echo form_error('stripe_extra_charge'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stripe_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <select  class="form-control col-md-7 col-xs-12"  name="stripe_status" required="required">
                                                          <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                          <option value="0" <?php if(isset($payment_setting) && $payment_setting->stripe_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                          <option value="1" <?php if(isset($payment_setting) && $payment_setting->stripe_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                      </select>
                                                      <div class="help-block"><?php echo form_error('stripe_status'); ?></div>
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                      <a href="https://stripe.com/" target="_blank"><img src="<?php echo IMG_URL; ?>stripe-setting.png" alt="" /></a>
                                                  </div>
                                              </div>
                                            </div>

                                            <div class="tab-pane fade in " id="tab_edit_pumoney_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_key"><?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_key" value="<?php echo isset($payment_setting) ? $payment_setting->payumoney_key : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('payumoney_key'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_salt"><?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="payumoney_salt" value="<?php echo isset($payment_setting) ? $payment_setting->payumoney_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('payumoney_salt'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->payumoney_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->payumoney_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('payumoney_demo'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payu_extra_charge"><?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="payu_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->payu_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('payumoney'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('payu_extra_charge'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payumoney_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="payumoney_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->payumoney_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->payumoney_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('payumoney_status'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.payumoney.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paym-setting.png" alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade in display" id="tab_edit_ccavenue_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_key"><?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_key" value="<?php echo isset($payment_setting) ? $payment_setting->ccavenue_key : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('ccavenue_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_salt"><?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key_salt'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_salt" value="<?php echo isset($payment_setting) ? $payment_setting->ccavenue_salt : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('key_salt'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('ccavenue_salt'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="ccavenue_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->ccavenue_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->ccavenue_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('ccavenue_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_extra_charge"><?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="ccavenue_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->ccavenue_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('ccavenue'); ?> <?php echo $this->lang->line('extra_charge'); ?>"  type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('ccavenue_extra_charge'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ccavenue_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="ccavenue_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->ccavenue_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->ccavenue_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('ccavenue_status'); ?></div>
                                                    </div>
                                                </div>
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.ccavenue.com/" target="_blank"><img src="<?php echo IMG_URL; ?>ccavenue-setting.png" alt="" /></a>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade in " id="tab_edit_paytm_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_key"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_key" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_key : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_merchant_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_mid"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_mid'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_mid" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_mid : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('merchant_mid'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_merchant_mid'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_merchant_website"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('website'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_merchant_website" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_merchant_website : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('website'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_merchant_website'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_industry_type"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('industry_type'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_industry_type" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_industry_type : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('industry_type'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_industry_type'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paytm_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paytm_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paytm_demo'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_extra_charge"><?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="paytm_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->paytm_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('paytm'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="number" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('paytm_extra_charge'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paytm_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="paytm_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->paytm_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->paytm_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('paytm_status'); ?></div>
                                                    </div>
                                                </div>

                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://paytm.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paytm-setting.png" alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade in " id="tab_edit_paystack_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_secret_key"><?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('secret_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_secret_key" value="<?php echo isset($payment_setting) ? $payment_setting->stack_secret_key : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('secret_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('stack_secret_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_public_key"><?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('public_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_public_key" value="<?php echo isset($payment_setting) ? $payment_setting->stack_public_key : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('public_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('stack_public_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->stack_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->stack_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('stack_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_extra_charge"><?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="stack_extra_charge" value="<?php echo isset($payment_setting) ? $payment_setting->stack_extra_charge : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('stack_extra_charge'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="stack_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->stack_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->stack_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('stack_status'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://paystack.com/" target="_blank"><img src="<?php echo IMG_URL; ?>paystack-setting.png" alt="" /></a>
                                                        <div class="instructions">Nigeria & African Payment Gateway</div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- edit pesapal Settings -->
                                            <div class="tab-pane fade in " id="tab_edit_pesapal_setting">
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_consumer_key"><?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_key'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="pesapal_consumer_key" value="<?php echo isset($payment_setting) ? $payment_setting->pesapal_consumer_key : ''; ?>"  placeholder="<?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_key'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('pesapal_consumer_key'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_consumer_secret"><?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_secret'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="pesapal_consumer_secret" value="<?php echo isset($payment_setting) ? $payment_setting->pesapal_consumer_secret : ''; ?>"  placeholder="<?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('consumer_secret'); ?>" required="required" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('pesapal_consumer_secret'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_demo"><?php echo $this->lang->line('is_demo'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="pesapal_demo" id="pesapal_demo" required="required">
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->pesapal_demo == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->pesapal_demo == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('pesapal_demo'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_extracharge"><?php echo $this->lang->line('pesapal'); ?> <?php echo $this->lang->line('extra_charge'); ?> (%)</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12"  name="pesapal_extracharge" id="pesapal_extracharge" value="<?php echo isset($payment_setting) ? $payment_setting->pesapal_extracharge : ''; ?>"  placeholder="<?php echo $this->lang->line('pay_stack'); ?> <?php echo $this->lang->line('extra_charge'); ?>" type="text" autocomplete="off">
                                                        <div class="help-block"><?php echo form_error('pesapal_extracharge'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pesapal_status"><?php echo $this->lang->line('is_active'); ?> <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select  class="form-control col-md-7 col-xs-12"  name="pesapal_status" required="required">
                                                            <option value="" >--<?php echo $this->lang->line('select'); ?>--</option>
                                                            <option value="0" <?php if(isset($payment_setting) && $payment_setting->pesapal_status == '0'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('no'); ?></option>
                                                            <option value="1" <?php if(isset($payment_setting) && $payment_setting->pesapal_status == '1'){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('yes'); ?></option>
                                                        </select>
                                                        <div class="help-block"><?php echo form_error('pesapal_status'); ?></div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">&nbsp;</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <a href="https://www.pesapal.com/" target="_blank"><img src="<?php echo IMG_URL; ?>pesapal-setting.png" alt="" /></a>
                                                        <div class="instructions">Tanzania Payment Gateway</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- edit pesapal setting end -->

                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                        <div class="col-xs-9">
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <input type="hidden" value="<?php echo isset($payment_setting) ? $payment_setting->id : '' ?>" name="id" />
                                                <a href="<?php echo site_url('administrator/payment/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                                <button id="send" type="submit" class="btn btn-success"><?php  echo $this->lang->line('update'); ?></button>
                                            </div>
                                        </div>
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



<div class="modal fade bs-payment-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?></h4>
        </div>
        <div class="modal-body fn_payment_data">
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">

    function get_payment_modal(payment_id){

        $('.fn_payment_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loader.gif" /></p>');
        $.ajax({
          type   : "POST",
          url    : "<?php echo site_url('administrator/payment/get_single_payment'); ?>",
          data   : {payment_id : payment_id},
          success: function(response){
             if(response)
             {
                $('.fn_payment_data').html(response);
             }
          }
       });
    }
</script>



<!-- datatable with buttons -->
 <script type="text/javascript">
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
</script>
