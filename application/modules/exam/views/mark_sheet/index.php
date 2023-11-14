<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('mark_sheet'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>


            <div class="x_content quick-link">
                <span><?php echo $this->lang->line('quick_link'); ?>:</span>
                <?php if (has_permission(VIEW, 'exam', 'mark')) { ?>
                    <a href="<?php echo site_url('exam/mark/index'); ?>"><?php echo $this->lang->line('manage_mark'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'examresult')) { ?>
                    | <a href="<?php echo site_url('exam/examresult/index'); ?>"><?php echo $this->lang->line('exam_term'); ?> <?php echo $this->lang->line('result'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'finalresult')) { ?>
                    | <a href="<?php echo site_url('exam/finalresult/index'); ?>"><?php echo $this->lang->line('exam_final_result'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'meritlist')) { ?>
                    | <a href="<?php echo site_url('exam/meritlist/index'); ?>"><?php echo $this->lang->line('merit_list'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'marksheet')) { ?>
                    | <a href="<?php echo site_url('exam/marksheet/index'); ?>"><?php echo $this->lang->line('mark_sheet'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'resultcard')) { ?>
                    | <a href="<?php echo site_url('exam/resultcard/index'); ?>"><?php echo $this->lang->line('result_card'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'resultcard')) { ?>
                    | <a href="<?php echo site_url('exam/resultcard/all'); ?>"><?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('result_card'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'mail')) { ?>
                    | <a href="<?php echo site_url('exam/mail/index'); ?>"><?php echo $this->lang->line('mark_send_by_email'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'text')) { ?>
                    | <a href="<?php echo site_url('exam/text/index'); ?>"><?php echo $this->lang->line('mark_send_by_sms'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'resultemail')) { ?>
                    | <a href="<?php echo site_url('exam/resultemail/index'); ?>"> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('email'); ?></a>
                <?php } ?>
                <?php if (has_permission(VIEW, 'exam', 'resultsms')) { ?>
                    | <a href="<?php echo site_url('exam/resultsms/index'); ?>"> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('sms'); ?></a>
                <?php } ?>
            </div>

            <div class="x_content no-print">
                <?php echo form_open_multipart(site_url('exam/marksheet/index'), array('name' => 'marksheet', 'id' => 'marksheet', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">

                    <?php $this->load->view('layout/school_list_filter'); ?>

                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group">
                            <div><?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span></div>
                            <select class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($academic_years as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if (isset($academic_year_id) && $academic_year_id == $obj->id) {
                                                                                echo 'selected="selected"';
                                                                            } ?>><?php echo $obj->session_year; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group">
                            <div><?php echo $this->lang->line('exam'); ?> <span class="required">*</span></div>
                            <select class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($exams as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if (isset($exam_id) && $exam_id == $obj->id) {
                                                                                echo 'selected="selected"';
                                                                            } ?>><?php echo $obj->title; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>

                    <?php if ($this->session->userdata('role_id') != STUDENT) { ?>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group">
                                <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                                <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                                <div><?php echo $this->lang->line('class'); ?> <span class="required">*</span></div>
                                <select class="form-control col-md-7 col-xs-12" name="class_id" id="class_id" required="required" onchange="get_section_by_class(this.value,'','');">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach ($classes as $obj) { ?>
                                        <?php if ($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)) {
                                            continue;  ?>
                                        <?php } elseif ($this->session->userdata('role_id') == GUARDIAN && !in_array($obj->id, $guardian_class_data)) {
                                            continue;
                                        } ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if (isset($class_id) && $class_id == $obj->id) {
                                                                                    echo 'selected="selected"';
                                                                                } ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('class_id'); ?></div>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group">
                                <div><?php echo $this->lang->line('section'); ?> <span class="required">*</span></div>
                                <select class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required" onchange="get_student_by_section(this.value,'');">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                </select>
                                <div class="help-block"><?php echo form_error('section_id'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <div><?php echo $this->lang->line('student'); ?> <span class="required">*</span></div>
                                <select class="form-control col-md-7 col-xs-12" name="student_id" id="student_id" required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                </select>
                                <div class="help-block"><?php echo form_error('student_id'); ?></div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br />
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <?php if (isset($student) && !empty($student)) { ?>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6  col-sm-offset-3  col-xs-offset-3 layout-box">
                            <p>
                                <?php if (isset($school)) { ?>
                                    <div>
                                        <?php if ($school->logo) { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" />
                                        <?php } else if ($school->frontend_logo) { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" />
                                        <?php } else { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt="" />
                                        <?php } ?>
                                    </div>
                                    <h4><?php echo $school->school_name; ?></h4>
                                    <p> <?php echo $school->address; ?></p>
                                <?php } ?>
                                <h4><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('mark_sheet'); ?></h4>
                                <?php echo $this->lang->line('name'); ?> : <?php echo $student->name; ?><br />
                                <?php echo $this->lang->line('exam'); ?> : <?php echo $exam->title; ?><br />
                                <?php echo $this->lang->line('class'); ?> : <?php echo $student->class_name; ?>,
                                <?php echo $this->lang->line('section'); ?> : <?php echo $student->section; ?>,
                                <?php echo $this->lang->line('roll_no'); ?> : <?php echo $student->roll_no; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="x_content">

                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2"><?php echo $this->lang->line('sl_no'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('subject'); ?></th>
                            <?php if (isset($exam_types) && !empty($exam_types)) {

                            ?>
                                <?php //echo '<pre>';print_r($exam_types);die();
                                //echo '<pre>';print_r($marks_details);die(); 

                                ?>
                                <?php foreach ($exam_types as $obj) { ?>
                                    <th colspan="2"><?php echo $obj->exam_type_name; ?></th>
                                    <input type="hidden" name="exam[]" value="<?php echo str_replace(' ', '_', $obj->exam_type_name); ?>">
                                    <input type="hidden" name="exam_type_id[]" value="<?php echo $obj->exam_type_id; ?>">
                                    <input type="hidden" name="max_marks[]" value="<?php echo $obj->max_marks; ?>">
                                <?php } ?>

                                <?php foreach ($marks_details as $details_data) { ?>

                                    <input type="hidden" name="marks_details[]" value="<?php echo $details_data->id; ?>">
                                <?php } ?>

                            <?php } else {  ?>
                                <th colspan="2"><?php echo $this->lang->line('written'); ?></th>
                                <th colspan="2"><?php echo $this->lang->line('tutorial'); ?></th>
                                <th colspan="2"><?php echo $this->lang->line('practical'); ?></th>
                                <th colspan="2"><?php echo $this->lang->line('viva'); ?></th>
                            <?php } ?>
                            <th colspan="2"><?php echo $this->lang->line('total'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('grade'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('point'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('lowest'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('height'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('position'); ?></th>
                        </tr>
                        <tr>
                            <?php if (isset($exam_types) && !empty($exam_types)) { ?>
                                <?php foreach ($exam_types as $obj) { ?>
                                    <th><?php echo $this->lang->line('mark'); ?></th>
                                    <th><?php echo $this->lang->line('obtain'); ?></th>
                                <?php } ?>
                            <?php } else { ?>
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
                        if (isset($subjects) && !empty($subjects)) {
                        ?>
                            <?php foreach ($subjects as $obj) { ?>
                                <?php $lh = get_lowet_height_mark($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $obj->subject_id); ?>
                                <?php $position = get_position_in_subject($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $obj->subject_id, $obj->obtain_total_mark); ?>
                                <tr>
                                    <td><?php echo $count++;  ?></td>
                                    <td><?php echo ucfirst($obj->subject); ?></td>
                                    <?php //echo '<pre>';print_r($exam_details);die(); 
                                    ?>
                                    <?php

                                    // $total_count = $count_all - $count_selected;
                                    $obtained_marks = get_exam_details_by_subject($school_id, $exam_id, $class_id, $academic_year_id, $obj->subject_id, $student->id);

                                    //echo '<pre>';print_r($student);die();
                                    //echo '<pre>';print_r($obtained_marks);die();                              
                                    $i = 0;
                                    $total_exams = array();
                                    foreach ($exam_types as $types) {
                                        $total_exams[] = $types->exam_type_name;
                                    }
                                    //echo '<pre>';print_r($total_exams);die();             
                                    ?>


                                    <?php foreach ($exam_types as $key => $types) {

                                        while ($i < count($total_exams)) {
                                            //echo '<pre> $i = '.$i;print_r($total_exams);//die();
                                            if ($total_exams[$i] == $obtained_marks[$key]->exam_type_name) {
                                                if ($ex->id == $obtained_marks[$key]->exam_id) {
                                                    $exam_name =  $ex->id . '_' . $total_exams[$i];
                                                    $obtained[$exam_name] += $obtained_marks[$key]->marks_obtained;

                                                    $maximum[$exam_name] += $obtained_marks[$key]->max_marks;
                                                }
                                                $i++;
                                    ?>
                                                <td><?php echo $obtained_marks[$key]->max_marks; ?></td>
                                                <td><?php echo $obtained_marks[$key]->marks_obtained; ?></td>

                                                <?php
                                                break;
                                                ?>

                                            <?php } else {

                                                $i++;
                                            ?>
                                                <td>N/A</td>
                                                <td>N/A</td>

                                        <?php }
                                        } ?>


                                    <?php } ?>

                                    <td><?php echo $obj->exam_total_mark; ?></td>
                                    <td><?php echo $obj->obtain_total_mark; ?></td>
                                    <td><?php echo $obj->name; ?></td>
                                    <td><?php echo $obj->point; ?></td>
                                    <td><?php echo $lh->lowest; ?></td>
                                    <td><?php echo $lh->height; ?></td>
                                    <td><?php echo $position; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="17" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 no-print">
                <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('mark_sheet_instruction'); ?></div>
            </div>
        </div>
    </div>
</div>


<!-- Super admin js START  -->
<script type="text/javascript">
    $("document").ready(function() {
        <?php if (isset($school_id) && !empty($school_id)) { ?>
            $(".fn_school_id").trigger('change');
        <?php } ?>
    });

    $('.fn_school_id').on('change', function() {

        var school_id = $(this).val();
        var exam_id = '';
        var class_id = '';
        var academic_year_id = '';

        <?php if (isset($school_id) && !empty($school_id)) { ?>
            exam_id = '<?php echo $exam_id; ?>';
            class_id = '<?php echo $class_id; ?>';
            academic_year_id = '<?php echo $academic_year_id; ?>';
        <?php } ?>

        if (!school_id) {
            toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/get_exam_by_school'); ?>",
            data: {
                school_id: school_id,
                exam_id: exam_id
            },
            async: false,
            success: function(response) {
                if (response) {
                    $('#exam_id').html(response);
                    get_class_by_school(school_id, class_id);
                    get_academic_year_by_school(school_id, academic_year_id);
                }
            }
        });
    });

    function get_academic_year_by_school(school_id, academic_year_id) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data: {
                school_id: school_id,
                academic_year_id: academic_year_id
            },
            async: false,
            success: function(response) {
                if (response) {
                    $('#academic_year_id').html(response);
                }
            }
        });
    }

    function get_class_by_school(school_id, class_id) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data: {
                school_id: school_id,
                class_id: class_id
            },
            async: false,
            success: function(response) {
                if (response) {
                    $('#class_id').html(response);
                }
            }
        });
    }
</script>
<!-- Super admin js end -->


<script type="text/javascript">
    <?php if (isset($class_id) && isset($section_id)) { ?>
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
    <?php } ?>


    function get_section_by_class(class_id, section_id) {

        var school_id = $('#school_id').val();
        if (!school_id) {
            toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data: {
                school_id: school_id,
                class_id: class_id,
                section_id: section_id
            },
            async: false,
            success: function(response) {
                if (response) {
                    $('#section_id').html(response);
                }
            }
        });
    }

    <?php if (isset($class_id) && isset($section_id)) { ?>
        get_student_by_section('<?php echo $section_id; ?>', '<?php echo $student_id; ?>');
    <?php } ?>

    function get_student_by_section(section_id, student_id) {

        var school_id = $('#school_id').val();
        if (!school_id) {
            toastr.error('<?php echo $this->lang->line('select'); ?> <?php echo $this->lang->line('school'); ?>');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/get_student_by_section'); ?>",
            data: {
                section_id: section_id,
                student_id: student_id
            },
            async: false,
            success: function(response) {
                if (response) {
                    $('#student_id').html(response);
                }
            }
        });
    }

    $("#marksheet").validate();
</script>
<style>
    .table>thead>tr>th {
        padding: 4px;
    }
</style>