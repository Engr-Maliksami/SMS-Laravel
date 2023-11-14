<section class="page-breadcumb-area bg-with-black">
    <div class="container text-center">
        <h2 class="title"><?php echo $this->lang->line('online'); ?> <?php echo $this->lang->line('admission'); ?></h2>
        <ul class="links">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="javascript:void(0);"><?php echo $this->lang->line('online'); ?> <?php echo $this->lang->line('admission'); ?></a></li>
        </ul>
    </div>
</section>
<section>
    <div class="container text-center">        
        <?php $this->load->view('layout/message'); ?> 
    </div>
</section>

<section class="page-contact-area">
    <div class="container">
        <form action="<?php echo site_url('admission-online'); ?>" method="post" id="admission" name="admission" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="admission-form">
                    <div class="row"> 
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="admission-address">
                                <div><h3><?php echo $school->school_name; ?></h3></div>                                
                                <div><?php echo $school->address; ?></div>
                                <div><?php echo $school->phone; ?></div>
                                <div><?php echo $school->email; ?></div>
                                <div><h4><?php echo $this->lang->line('online'); ?> <?php echo $this->lang->line('admission'); ?></h4></div>
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><hr></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('basic'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                    </div>                     
                      
                    <div class="row">                  
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($post['name']) ?  $post['name'] : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('name'); ?></div> 
                            </div>
                        </div>                     
                        <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                <label  for="dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="dob"  id="dob" value="<?php echo isset($post['dob']) ?  $post['dob'] : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('dob'); ?></div>
                             </div>
                        </div>

                         <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                 <label for="gender"><?php echo $this->lang->line('gender'); ?> <span class="required">*</span></label>
                                  <select  class="form-control col-md-7 col-xs-12"  name="gender"  id="gender" required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $genders = get_genders(); ?>
                                    <?php foreach($genders as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($post['gender']) && $post['gender'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('gender'); ?></div>
                             </div>
                         </div>

                         <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                 <label for="blood_group"><?php echo $this->lang->line('blood_group'); ?></label>
                                  <select  class="form-control col-md-7 col-xs-12" name="blood_group" id="blood_group">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $bloods = get_blood_group(); ?>
                                    <?php foreach($bloods as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($post['blood_group']) && $post['blood_group'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                    </select>
                                <div class="help-block"><?php echo form_error('blood_group'); ?></div>
                             </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                  <label for="religion"><?php echo $this->lang->line('religion'); ?></label>
                                  <input  class="form-control col-md-7 col-xs-12"  name="religion"  id="add_religion" value="<?php echo isset($post['religion']) ?  $post['religion'] : ''; ?>" placeholder="<?php echo $this->lang->line('religion'); ?>" type="text" autocomplete="off">
                                   <div class="help-block"><?php echo form_error('religion'); ?></div>
                             </div>
                         </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                  <label for="caste"><?php echo $this->lang->line('caste'); ?></label>
                                  <input  class="form-control col-md-7 col-xs-12"  name="caste"  id="add_caste" value="<?php echo isset($post['caste']) ?  $post['caste'] : ''; ?>" placeholder="<?php echo $this->lang->line('caste'); ?>" type="text" autocomplete="off">
                                   <div class="help-block"><?php echo form_error('caste'); ?></div>
                             </div>
                         </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="health_condition"><?php echo $this->lang->line('health_condition'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="health_condition"  id="health_condition" value="" placeholder="<?php echo $this->lang->line('health_condition'); ?>" type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('health_condition'); ?></div>
                            </div>
                        </div>  
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="photo"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('photo'); ?></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="photo"  id="photo" type="file">
                                <div class="text-info" style="font-size: 9px;"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                <div class="help-block"><?php echo form_error('photo'); ?></div>
                            </div>
                        </div>
                    </div>
           
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_phone"><?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('phone'); ?><span class="required">*</span></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="gud_phone"  id="gud_phone" value="<?php echo isset($post['gud_phone']) ?  $post['gud_phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('phone'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('gud_phone'); ?></div>
                                <input type="hidden" name="guardian_id" id="guardian_id" value="" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label style="width: 100%;margin-bottom: 0;">&nbsp;</label>
                                <button  class="btn btn-info "  name="find"  id="fn_find" type="button"><?php echo $this->lang->line('find'); ?> <?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('by'); ?> <?php echo $this->lang->line('phone'); ?></button>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_name"><?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('name'); ?><span class="required">*</span></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="gud_name"  id="gud_name" value="<?php echo isset($post['gud_name']) ?  $post['gud_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('gud_name'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_email"><?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('email'); ?><span class="required">*</span></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="gud_email"  id="gud_email" value="<?php echo isset($post['gud_email']) ?  $post['gud_email'] : ''; ?>" placeholder="<?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('email'); ?>" required="required" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('gud_email'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_national_id"><?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('national_id'); ?></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="gud_national_id"  id="gud_national_id" value="<?php echo isset($post['gud_national_id']) ?  $post['gud_national_id'] : ''; ?>" placeholder="<?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('national_id'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('gud_national_id'); ?></div>
                            </div>
                        </div>                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_profession"><?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('profession'); ?></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="gud_profession"  id="gud_profession" value="<?php echo isset($post['gud_profession']) ?  $post['gud_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('profession'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('gud_profession'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_religion"><?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('religion'); ?></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="gud_religion"  id="gud_religion" value="<?php echo isset($post['gud_religion']) ?  $post['gud_religion'] : ''; ?>" placeholder="<?php echo $this->lang->line('gud'); ?> <?php echo $this->lang->line('religion'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('gud_religion'); ?></div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="relation_with"><?php echo $this->lang->line('relation_with'); ?> </label>
                                <select  class="form-control col-md-7 col-xs-12" name="gud_relation" id="gud_relation"  >
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $relation_types = get_relation_types(); ?>
                                    <?php foreach($relation_types as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($post['relation_with']) && $post['relation_with'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('relation_with'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_present_address"><?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?></label>
                                <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="gud_present_address"  id="gud_present_address"  placeholder="<?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?>"><?php echo isset($post['gud_present_address']) ?  $post['gud_present_address'] : ''; ?></textarea>
                                <div class="help-block"><?php echo form_error('gud_present_address'); ?></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="item form-group">
                                <label for="gud_permanent_address"><?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?></label>
                                <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="gud_permanent_address"  id="gud_permanent_address"  placeholder="<?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?>"><?php echo isset($post['gud_permanent_address']) ?  $post['gud_permanent_address'] : ''; ?></textarea>
                                <div class="help-block"><?php echo form_error('gud_permanent_address'); ?></div>
                            </div>
                        </div>
                    </div>
                    
                <div class="row">
                    <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('contact'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                </div>  
                    
                  <div class="row"> 
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group">
                           <label for="email"><?php echo $this->lang->line('email'); ?> </label>
                           <input  class="form-control col-md-7 col-xs-12"  name="email"  id="email" value="<?php echo isset($post['email']) ?  $post['email'] : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" type="email" autocomplete="off">
                           <div class="help-block"><?php echo form_error('email'); ?></div>
                        </div>
                    </div>                       
                       
                     <div class="col-md-3 col-sm-3 col-xs-12">
                         <div class="item form-group">
                             <label for="phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                             <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="phone" value="<?php echo isset($post['phone']) ?  $post['phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" required="required" type="text" autocomplete="off">
                             <div class="help-block"><?php echo form_error('phone'); ?></div>
                         </div>
                     </div>

                     <div class="col-md-3 col-sm-3 col-xs-12">
                         <div class="item form-group">
                             <label for="national_id"><?php echo $this->lang->line('national_id'); ?> </label>
                             <input  class="form-control col-md-7 col-xs-12"  name="national_id"  id="national_id" value="<?php echo isset($post['national_id']) ?  $post['national_id'] : ''; ?>" placeholder="<?php echo $this->lang->line('national_id'); ?>" type="text" autocomplete="off">
                             <div class="help-block"><?php echo form_error('national_id'); ?></div>
                         </div>
                     </div>

                     <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="item form-group">
                             <label for="present_address"><?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?> </label>
                              <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="present_address"  id="present_address"  placeholder="<?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?>"><?php echo isset($post['present_address']) ?  $post['present_address'] : ''; ?></textarea>
                              <div class="help-block"><?php echo form_error('present_address'); ?></div>
                         </div>
                     </div>                                    
                     <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="item form-group">
                            <label for="permanent_address"><?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?></label>
                            <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="permanent_address"  id="permanent_address"  placeholder="<?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?>"><?php echo isset($post['permanent_address']) ?  $post['permanent_address'] : ''; ?></textarea>
                            <div class="help-block"><?php echo form_error('permanent_address'); ?></div>
                         </div>
                     </div>
                   </div>
                                
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('academic'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                    </div>  
                          
                    <div class="row">                                      
                         <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                 <label for="type_id"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('type'); ?><span class="required">*</span></label>
                                 <select  class="form-control col-md-7 col-xs-12 quick-field" name="type_id" id="add_type_id" required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach($types as $obj){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php echo isset($post['type_id']) && $post['type_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->type; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('type_id'); ?></div>
                             </div>
                         </div>                        
                         <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                 <label for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                 <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_id" id="add_class_id" required="required" onchange="get_section_by_class(this.value, '');">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach($classes as $obj){ ?>
                                        <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('class_id'); ?></div>
                             </div>
                         </div>                        
                         <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                <label for="group"><?php echo $this->lang->line('group'); ?> </label>
                                <select  class="form-control col-md-7 col-xs-12" name="group" id="group">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $groups = get_groups(); ?>
                                    <?php foreach($groups as $key=>$value){ ?>
                                        <option value="<?php echo $key; ?>" <?php echo isset($post['group']) && $post['group'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('group'); ?></div>
                             </div>
                         </div>                   
                         <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                <label for="second_language"><?php echo $this->lang->line('second'); ?> <?php echo $this->lang->line('language'); ?></label>
                                <input  class="form-control col-md-7 col-xs-12"  name="second_language"  id="second_language" value="<?php echo isset($post['second_language']) ?  $post['second_language'] : ''; ?>" placeholder="<?php echo $this->lang->line('second'); ?> <?php echo $this->lang->line('second'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('second_language'); ?></div>
                             </div>
                         </div>
                    </div>
                                
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                    </div>
                      <div class="row"> 
                        <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                <label for="previous_school"><?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('school'); ?> </label>
                                <input  class="form-control col-md-7 col-xs-12"  name="previous_school"  id="previous_school" value="<?php echo isset($post['previous_school']) ?  $post['previous_school'] : ''; ?>" placeholder="<?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('school'); ?>"  type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('previous_school'); ?></div>
                             </div>
                         </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                             <div class="item form-group">
                                <label for="previous_class"><?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('class'); ?> </label>
                                <input  class="form-control col-md-7 col-xs-12"  name="previous_class"  id="previous_class" value="<?php echo isset($post['previous_class']) ?  $post['previous_class'] : ''; ?>" placeholder="<?php echo $this->lang->line('previous'); ?> <?php echo $this->lang->line('class'); ?>"  type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('previous_class'); ?></div>
                             </div>
                         </div>
                    </div>
                              
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                    </div>
                     <div class="row">  
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="father_name"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('name'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="father_name"  id="father_name" value="<?php echo isset($post['father_name']) ?  $post['father_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('name'); ?>" type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('father_name'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="father_phone"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('phone'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="father_phone"  id="father_phone" value="<?php echo isset($post['father_phone']) ?  $post['father_phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('phone'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('father_phone'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="father_education"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('education'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="father_education"  id="father_education" value="<?php echo isset($post['father_education']) ?  $post['father_education'] : ''; ?>" placeholder="<?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('education'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('father_education'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="father_profession"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('profession'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="father_profession"  id="father_profession" value="<?php echo isset($post['father_profession']) ?  $post['father_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('profession'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('father_profession'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="father_designation"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('designation'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="father_designation"  id="father_designation" value="<?php echo isset($post['father_designation']) ?  $post['father_designation'] : ''; ?>" placeholder="<?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('designation'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('father_designation'); ?></div>
                            </div>
                        </div>                        
                   </div>
                    
                        
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><p class="admission-form-title"><strong><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('information'); ?>:</strong></p> </div>
                    </div>
                    <div class="row">  
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="mother_name"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('name'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="mother_name"  id="mother_name" value="<?php echo isset($post['mother_name']) ?  $post['mother_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('name'); ?>" type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('mother_name'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="mother_phone"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('phone'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="mother_phone"  id="mother_phone" value="<?php echo isset($post['mother_phone']) ?  $post['mother_phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('phone'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('mother_phone'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="mother_education"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('education'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="mother_education"  id="mother_education" value="<?php echo isset($post['mother_education']) ?  $post['mother_education'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('education'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('mother_education'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="mother_profession"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('profession'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="mother_profession"  id="mother_profession" value="<?php echo isset($post['mother_profession']) ?  $post['mother_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('profession'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('mother_profession'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                               <label for="mother_designation"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('designation'); ?> </label>
                               <input  class="form-control col-md-7 col-xs-12"  name="mother_designation"  id="mother_designation" value="<?php echo isset($post['mother_designation']) ?  $post['mother_designation'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('designation'); ?>"  type="text" autocomplete="off">
                               <div class="help-block"><?php echo form_error('mother_designation'); ?></div>
                            </div>
                        </div>                        
                   </div>
                    <div class="ln_solid"><hr/></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 margin-top">
                        <button type="submit" class="btn btn-info glbscl-link-btn hvr-bs"> <?php echo $this->lang->line('apply'); ?> <?php echo $this->lang->line('online'); ?> <?php echo $this->lang->line('admission'); ?></button>
                        <a  class="btn btn-info glbscl-link-btn hvr-bs"  href="<?php echo site_url('admission-form'); ?>"><?php echo $this->lang->line('print'); ?> <?php echo $this->lang->line('admission_form'); ?></a>
                    </div>
                </div>
                </div>
            </div>         
        </div>
        </form>     
    </div>
</section>
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">     
     
     function setInputFilter(textbox, inputFilter) { 
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                //console.log("1====>>",textbox);
                if(this.hasOwnProperty("oldValue") && this.value=='') {
                    //console.log("check this====>>",this.value);
                    this.value = this.value;
                }else
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    //console.log("2====>>",this.oldValue);
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    //console.log("3====>>",this.value);
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    setInputFilter(document.getElementById("gud_phone"), function(value) {
        return /^[\d\(\)\-+ _]+$/.test(value);
    });

    setInputFilter(document.getElementById("phone"), function(value) {
        return /^[\d\(\)\-+ _]+$/.test(value);
    });

    setInputFilter(document.getElementById("father_phone"), function(value) {
        return /^[\d\(\)\-+ _]+$/.test(value);
    });

    setInputFilter(document.getElementById("mother_phone"), function(value) {
        return /^[\d\(\)\-+ _]+$/.test(value); 
    });

     $( "#dob" ).datepicker({  endDate: "today",startView: 2 });

//
function ValidateEmail(inputText){
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
     if(inputText.value.match(mailformat)){
        document.form1.text1.focus();
        return true;
      }
     else{
        swal({
                title: "Exam",
                text: "You have entered an invalid email address!",
                type: "error",
                confirmButtonText: "OK"
            });
        document.form1.text1.focus();
        return false;
     }
}

 


    $('#admission').validate();
    
         
    $('#fn_find').on('click', function(){
           
            var phone = $('#gud_phone').val();
            
            if(!phone){
                $('#gud_phone').focus();
                return false;
            }
            
            $.ajax({       
            type   : "POST",
            dataType: "json",
            url    : "<?php echo site_url('web/get_guardian_info'); ?>",
            data   : { phone : phone},               
            async  : true,
            success: function(response){ 
               if(response)
               {
                    $('#guardian_id').val(response.id);  
                    $('#gud_name').val(response.name);  
                    $('#gud_email').val(response.email);  
                    $('#gud_national_id').val(response.national_id);  
                    $('#gud_profession').val(response.profession);  
                    $('#gud_religion').val(response.religion);  
                    $('#gud_present_address').val(response.present_address);  
                    $('#gud_permanent_address').val(response.permanent_address); 
                    $('#phone').val(response.phone); 
                    $('#present_address').val(response.present_address); 
                    $('#permanent_address').val(response.permanent_address); 
                    
               }else{
                   
                    $('#guardian_id').val('');  
                    $('#gud_name').val('');  
                    $('#gud_email').val('');  
                    $('#gud_national_id').val('');  
                    $('#gud_profession').val('');  
                    $('#gud_religion').val('');  
                    $('#gud_present_address').val('');  
                    $('#gud_permanent_address').val(''); 
                    $('#phone').val(''); 
                    $('#present_address').val(''); 
                    $('#permanent_address').val(''); 
                    
               }
            }
        });  
    });
        
</script>
