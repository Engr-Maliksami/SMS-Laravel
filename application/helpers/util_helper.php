<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('_d')) {

    function _d($data, $exit = TRUE) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($exit)
            exit;
    }
}

if (!function_exists('logged_in_user_id')) {

    function logged_in_user_id() {
        $logged_in_id = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('id') && $CI->session->userdata('role_id')):
            $logged_in_id = $CI->session->userdata('id');
        endif;
        return $logged_in_id;
    }

}

if (!function_exists('logged_in_role_id')) {

    function logged_in_role_id() {
        $logged_in_role_id = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('role_id')):
            $logged_in_role_id = $CI->session->userdata('role_id');
        endif;
        return $logged_in_role_id;
    }

}

if (!function_exists('logged_in_user_type')) {

    function logged_in_user_type() {
        $logged_in_type = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('user_type')):
            $logged_in_id = $CI->session->userdata('user_type');
        endif;
        return $logged_in_type;
    }

}




if (!function_exists('success')) {

    function success($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('success', $message);
        return true;
    }
}

if (!function_exists('error')) {

    function error($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('error', $message);
        return true;
    }

}

if (!function_exists('warning')) {

    function warning($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('warning', $message);
        return true;
    }

}

if (!function_exists('info')) {

    function info($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('info', $message);
        return true;
    }

}

if (!function_exists('get_slug')) {

    function get_slug($slug) {
        if (!$slug) {
            return;
        }

        $char = array("!", "â€™", "'", ":", ",", "_", "`", "~", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "=", "{", "}", "[", "]", "/", ";", '"', '<', '>', '?', "'\'",);
        $slug = str_replace($char, "", $slug);
        return $str = strtolower(str_replace(' ', "-", $slug));
    }

}

if (!function_exists('get_status')) {

    function get_status($status) {
        $ci = & get_instance();
        if ($status == 1) {
            return $ci->lang->line('active');
        } elseif ($status == 2) {
            return $ci->lang->line('in_active');
        } elseif ($status == 3) {
            return $ci->lang->line('trash');
        }
    }

}


if (!function_exists('verify_email_format')) {

    function verify_email_format($email) {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '';
        } else {
            return $email;
        }
    }

}


if (!function_exists('get_classes')) {

    function get_classes($school_id = null) {
        $ci = & get_instance();
        $ci->db->select('C.*');
        $ci->db->from('classes AS C');
        if($school_id){
            $ci->db->where('C.school_id', $school_id);
        }
         return $ci->db->get()->result();
    }

}

if (!function_exists('get_vehicles')) {

    function get_vehicle_by_ids($ids) {
        $str = '';
        if ($ids) {
            $ci = & get_instance();
            $sql = "SELECT * FROM `vehicles` WHERE `id` IN($ids)";
            $result = $ci->db->query($sql)->result();
            if (!empty($result)) {
                foreach ($result as $obj) {
                    $str .= $obj->number . ',';
                }
            }
        }
        return rtrim($str, ',');
    }

}

if (!function_exists('get_routines_by_day')) {

    function get_routines_by_day($day, $class_id = null, $section_id =null) {
        $ci = & get_instance();

        $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
        $ci->db->from('routines AS R');
        $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
        $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
        $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
        $ci->db->where('R.day', $day);

        if(logged_in_role_id() == TEACHER){
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id'));
        }else{
            $ci->db->where('R.class_id', $class_id);
            $ci->db->where('R.section_id', $section_id);
        }

        $ci->db->order_by("R.id", "ASC");
       return $ci->db->get()->result();


    }

}

if (!function_exists('get_student_attendance')) {

    function get_student_attendance($student_id, $school_id, $academic_year_id, $class_id, $section_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('SA.' . $field);
        $ci->db->from('student_attendances AS SA');
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.class_id', $class_id);

        if($section_id){
            $ci->db->where('SA.section_id', $section_id);
        }

        $ci->db->where('SA.year', $year);
        $ci->db->where('SA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}

if (!function_exists('get_teacher_attendance')) {

    function get_teacher_attendance($teacher_id, $school_id, $academic_year_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('TA.' . $field);
        $ci->db->from('teacher_attendances AS TA');
        $ci->db->where('TA.teacher_id', $teacher_id);
        $ci->db->where('TA.school_id', $school_id);
        $ci->db->where('TA.academic_year_id', $academic_year_id);
        $ci->db->where('TA.year', $year);
        $ci->db->where('TA.month', $month);
       return $ci->db->get()->row()->$field;
      // echo $ci->db->last_query();
    }

}

if (!function_exists('get_employee_attendance')) {

    function get_employee_attendance($teacher_id, $school_id, $academic_year_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('EA.' . $field);
        $ci->db->from('employee_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.employee_id', $teacher_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        $ci->db->where('EA.year', $year);
        $ci->db->where('EA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}

if (!function_exists('get_exam_attendance')) {

    function get_exam_attendance($school_id, $student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('EA.is_attend');
        $ci->db->from('exam_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        $ci->db->where('EA.exam_id', $exam_id);
        $ci->db->where('EA.class_id', $class_id);
        if($section_id){
            $ci->db->where('EA.section_id', $section_id);
        }
        $ci->db->where('EA.student_id', $student_id);
        $ci->db->where('EA.subject_id', $subject_id);
        return @$ci->db->get()->row()->is_attend;

    }

}

if (!function_exists('get_exam_mark')) {

    function get_exam_mark($school_id, $student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('M.*');
        $ci->db->from('marks AS M');
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.subject_id', $subject_id);
        return $ci->db->get()->row();
    }

}



if (!function_exists('get_exam_total_mark')) {

    function get_exam_total_mark($school_id, $exam_id, $student_id, $academic_year_id, $class_id, $section_id = null) {

        $ci = & get_instance();
        $ci->db->select('COUNT(M.id) AS total_subject, SUM(G.point) AS total_point, SUM(M.exam_total_mark) AS exam_mark, SUM(M.obtain_total_mark) AS obtain_mark');
        $ci->db->from('marks AS M');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.exam_id', $exam_id);
        if ($section_id) {
            $ci->db->where('M.section_id', $section_id);
        }

        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}


if (!function_exists('get_exam_result')) {

    function get_exam_result($school_id, $exim_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        $ci = & get_instance();
        $ci->db->select('ER.*, G.name');
        $ci->db->from('exam_results AS ER');
        $ci->db->join('grades AS G', 'G.id = ER.grade_id', 'left');
        $ci->db->where('ER.school_id', $school_id);
        $ci->db->where('ER.exam_id', $exim_id);
        $ci->db->where('ER.class_id', $class_id);

        if ($section_id) {
            $ci->db->where('ER.section_id', $section_id);
        }

        $ci->db->where('ER.student_id', $student_id);
        $ci->db->where('ER.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}


if (!function_exists('get_exam_final_result')) {

    function get_exam_final_result($school_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        $ci = & get_instance();
        $ci->db->select('FR.*');
        $ci->db->from('final_results AS FR');
        $ci->db->where('FR.class_id', $class_id);
        if ($section_id) {
            $ci->db->where('FR.section_id', $section_id);
        }
        $ci->db->where('FR.school_id', $school_id);
        $ci->db->where('FR.student_id', $student_id);
        $ci->db->where('FR.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}



if (!function_exists('get_student_position')) {

    function get_student_position($school_id, $academic_year_id, $class_id, $student_id, $section_id = null) {

        $cond = "";
        $condition = " academic_year_id = $academic_year_id ";
        $condition .= " AND school_id = $school_id";
        $condition .= " AND class_id = $class_id";
        if($section_id){
           $condition .= " AND section_id = $section_id";
        }

        $cond = $condition;
        $condition .= " AND student_id = $student_id";



        $ci = & get_instance();
        $sql = "SELECT id, avg_grade_point, FIND_IN_SET( (avg_grade_point),
                ( SELECT GROUP_CONCAT( (avg_grade_point) ORDER BY avg_grade_point DESC )
                FROM final_results WHERE $cond  )) AS rank
                FROM final_results
                WHERE $condition";

        $result =  $ci->db->query($sql)->row();

        $rank = '';
        if(!empty($result)){
            $rank = $result->rank;
        }

        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd';
        }elseif($rank == 3){
           return $rank.'rd';
        }elseif($rank > 3 ){
            return $rank.'th';
        }else{
            return '--';
        }
    }

}



if (!function_exists('get_lowet_height_mark')) {

    function get_lowet_height_mark($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('MIN(M.obtain_total_mark) AS lowest, MAX(M.obtain_total_mark) AS height');
        $ci->db->from('marks AS M');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.section_id', $section_id);
        $ci->db->where('M.subject_id', $subject_id);
        return  $ci->db->get()->row();
     // echo $ci->db->last_query();
    }
}


if (!function_exists('get_position_in_subject')) {

    function get_position_in_subject($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id, $mark) {


        $ci = & get_instance();
        $sec = "";
        if($section_id){
           $sec = " AND section_id = $section_id";
        }

        $sql = "SELECT id, obtain_total_mark, FIND_IN_SET( obtain_total_mark,(
                SELECT GROUP_CONCAT( obtain_total_mark  ORDER BY obtain_total_mark DESC )
                FROM marks WHERE
                school_id = $school_id
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id
                AND class_id = $class_id
                $sec
                AND subject_id = $subject_id))
                AS rank
                FROM marks
                WHERE school_id = $school_id
                   AND academic_year_id = $academic_year_id
                   AND exam_id = $exam_id
                   AND class_id = $class_id
                   $sec
                   AND subject_id = $subject_id
                   AND  obtain_total_mark = $mark";

        $rank =  $ci->db->query($sql)->row()->rank;

        if($mark == 0){
            return '--';
        }

        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd';
        }elseif($rank == 3){
           return $rank.'rd';
        }elseif($rank > 3 ){
            return $rank.'th';
        }else{
            return '--';
        }
    }

}


if (!function_exists('get_subject_list')) {

    function get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        $ci->db->select('M.*,S.name AS subject, G.point, G.name');
        $ci->db->from('marks AS M');
        $ci->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);
        return  $ci->db->get()->result();
    }

}



if (!function_exists('get_exam_wise_markt')) {

    function get_exam_wise_markt($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();

        // $select = 'SUM(M.written_mark) AS written_mark,
        //            SUM(M.written_obtain) AS written_obtain,
        //            SUM(M.tutorial_mark) AS tutorial_mark,
        //            SUM(M.tutorial_obtain) AS tutorial_obtain,
        //            SUM(M.practical_mark) AS practical_mark,
        //            SUM(M.practical_obtain) AS practical_obtain,
        //            SUM(M.viva_mark) AS viva_mark,
        //            SUM(M.viva_obtain) AS viva_obtain,
        //            COUNT(M.id) AS total_subject,
        //            SUM(G.point) AS point
        //            ';
                   $select = 'COUNT(M.id) AS total_subject,
                   SUM(G.point) AS point
                   ';

        //$select ='M.id';

        $ci->db->select($select);
        $ci->db->from('marks AS M');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);

        // $res = $ci->db->get();
         //print_r($ci->db->last_query());
        return $ci->db->get()->row();
        // $ci->db->last_query();
    }
}


if (!function_exists('get_position_in_exam')) {

    function get_position_in_exam($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $mark = null) {

        $ci = & get_instance();

        $sec = "";
        if($section_id){
           $sec = " AND section_id = $section_id";
        }

        $sql = "SELECT id, total_obtain_mark, FIND_IN_SET( total_obtain_mark,(
                SELECT GROUP_CONCAT( total_obtain_mark  ORDER BY total_obtain_mark DESC )
                FROM exam_results WHERE
                school_id = $school_id
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id
                AND class_id = $class_id
                $sec ))
                AS rank
                FROM exam_results
                WHERE school_id = $school_id
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id
                AND class_id = $class_id
                $sec
                AND total_obtain_mark = $mark";

        $rank =  @$ci->db->query($sql)->row()->rank;

        if($mark == 0){
            return '--';
        }

        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd';
        }elseif($rank == 3){
           return $rank.'rd';
        }elseif($rank > 3 ){
            return $rank.'th';
        }else{
            return '--';
        }
    }

}


if (!function_exists('get_lowet_height_result')) {

    function get_lowet_height_result($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        $ci->db->select('MIN(ER.total_obtain_mark) AS lowest, MAX(ER.total_obtain_mark) AS height');
        $ci->db->from('exam_results AS ER');
        $ci->db->where('ER.school_id', $school_id);
        $ci->db->where('ER.academic_year_id', $academic_year_id);
        $ci->db->where('ER.exam_id', $exam_id);
        $ci->db->where('ER.class_id', $class_id);
        if($section_id){
           $ci->db->where('ER.section_id', $section_id);
        }
        return  $ci->db->get()->row();
    }

}


if (!function_exists('get_final_result')) {

    function get_final_result($school_id, $academic_year_id, $class_id, $section_id = null, $student_id = null){

        $ci = & get_instance();
        $ci->db->select('FR.*, G.name AS grade');
        $ci->db->from('final_results AS FR');
        $ci->db->join('grades AS G', 'G.id = FR.grade_id', 'left');
        $ci->db->where('FR.academic_year_id', $academic_year_id);
        $ci->db->where('FR.school_id', $school_id);
        $ci->db->where('FR.class_id', $class_id);
        if($section_id){
           $ci->db->where('FR.section_id', $section_id);
        }
        $ci->db->where('FR.student_id', $student_id);
        return $ci->db->get()->row();
    }
}


if (!function_exists('get_position_in_class')) {

    function get_position_in_class($school_id, $academic_year_id, $class_id, $student_id) {


        $condition = " school_id = $school_id";
        $condition .= " AND academic_year_id = $academic_year_id";
        $condition .= " AND class_id = $class_id";
        $condition .= " AND student_id = $student_id";

        $ci = & get_instance();
        $sql = "SELECT id, avg_grade_point, FIND_IN_SET( (avg_grade_point+total_obtain_mark),
                ( SELECT GROUP_CONCAT( (avg_grade_point+total_obtain_mark) ORDER BY avg_grade_point DESC )
                FROM final_results ) ) AS rank
                FROM final_results
                WHERE $condition";

        $rank =  @$ci->db->query($sql)->row()->rank;

        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd';
        }elseif($rank == 3){
           return $rank.'rd';
        }elseif($rank > 3 ){
            return $rank.'th';
        }else{
            return '--';
        }
    }

}




if (!function_exists('get_enrollment')) {

    function get_enrollment($student_id, $academic_year_id, $school_id = null) {
        $ci = & get_instance();
        $ci->db->select('E.*');
        $ci->db->from('enrollments AS E');
        $ci->db->where('E.student_id', $student_id);
        $ci->db->where('E.academic_year_id', $academic_year_id);
        if($school_id){
            $ci->db->where('E.school_id', $school_id);
        }
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_user_by_role')) {

    function get_user_by_role($role_id, $user_id) {

        $ci = & get_instance();

        if ($role_id == SUPER_ADMIN) {

            $ci->db->select('SA.*, U.username, U.role_id');
            $ci->db->from('system_admin AS SA');
            $ci->db->join('users AS U', 'U.id = SA.user_id', 'left');
            $ci->db->where('SA.user_id', $user_id);
            return $ci->db->get()->row();

        }elseif ($role_id == STUDENT) {

            $ci->db->select('S.*, T.type,  D.amount, D.title AS discount, G.name AS guardian, E.roll_no, E.section_id, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $ci->db->from('enrollments AS E');
            $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
            $ci->db->join('student_types AS T', 'T.id = S.type_id', 'left');
            $ci->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
            $ci->db->join('users AS U', 'U.id = S.user_id', 'left');
            $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $ci->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
            $ci->db->where('S.user_id', $user_id);

            return $ci->db->get()->row();

        } elseif ($role_id == TEACHER) {

            $ci->db->select('T.*, U.username, U.role_id');
            $ci->db->from('teachers AS T');
            $ci->db->join('users AS U', 'U.id = T.user_id', 'left');
            $ci->db->where('T.user_id', $user_id);
            return $ci->db->get()->row();

        } elseif ($role_id == GUARDIAN) {

            $ci->db->select('G.*, U.username, U.role_id');
            $ci->db->from('guardians AS G');
            $ci->db->join('users AS U', 'U.id = G.user_id', 'left');
            $ci->db->where('G.user_id', $user_id);
            return $ci->db->get()->row();

        } else {

            $ci->db->select('E.*, SG.grade_name, U.username, U.role_id, D.name AS designation');
            $ci->db->from('employees AS E');
            $ci->db->join('users AS U', 'U.id = E.user_id', 'left');
            $ci->db->join('designations AS D', 'D.id = E.designation_id', 'left');
            $ci->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left');
            $ci->db->where('E.user_id', $user_id);
            return $ci->db->get()->row();
        }

        $ci->db->last_query();
    }

}


if (!function_exists('get_user_by_id')) {

    function get_user_by_id($user_id) {

        $ci = & get_instance();

        $ci->db->select('U.id, U.role_id');
        $ci->db->from('users AS U');
        $ci->db->where('U.id', $user_id);
        $user = $ci->db->get()->row();

        if ($user->role_id == SUPER_ADMIN) {

            $ci->db->select('SA.*, U.username, U.role_id');
            $ci->db->from('system_admin AS SA');
            $ci->db->join('users AS U', 'U.id = SA.user_id', 'left');
            $ci->db->where('SA.user_id', $user_id);
            return $ci->db->get()->row();

        }else if ($user->role_id == STUDENT) {

            $ci->db->select('S.*, E.roll_no, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $ci->db->from('enrollments AS E');
            $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
            $ci->db->join('users AS U', 'U.id = S.user_id', 'left');
            $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $ci->db->where('S.user_id', $user_id);
            return $ci->db->get()->row();

        } elseif ($user->role_id == TEACHER) {

            $ci->db->select('T.*, U.username, U.role_id');
            $ci->db->from('teachers AS T');
            $ci->db->join('users AS U', 'U.id = T.user_id', 'left');
            $ci->db->where('T.user_id', $user_id);
            return $ci->db->get()->row();

        } elseif ($user->role_id == GUARDIAN) {

            $ci->db->select('G.*, U.username, U.role_id');
            $ci->db->from('guardians AS G');
            $ci->db->join('users AS U', 'U.id = G.user_id', 'left');
            $ci->db->where('G.user_id', $user_id);
            return $ci->db->get()->row();

        } else {

            $ci->db->select('E.*, U.username, U.role_id, D.name AS designation');
            $ci->db->from('employees AS E');
            $ci->db->join('users AS U', 'U.id = E.user_id', 'left');
            $ci->db->join('designations AS D', 'D.id = E.designation_id', 'left');
            $ci->db->where('E.user_id', $user_id);
            return  $ci->db->get()->row();
        }

        // $ci->db->last_query();
    }

}


if (!function_exists('get_total_used_leave')) {

    function get_total_used_leave($role_id, $type_id, $user_id) {
        $ci = & get_instance();

        $ci->db->select('sum(A.leave_day) AS total');
        $ci->db->from('leave_applications AS A');
        $ci->db->where('A.role_id', $role_id);
        $ci->db->where('A.type_id', $type_id);
        $ci->db->where('A.user_id', $user_id);
        $ci->db->where('A.leave_status', 2);
        $result = $ci->db->get()->row();

        if(!empty($result)){
            return $result->total;
        }else{
            return 0;
        }
    }
}


if (!function_exists('get_blood_group')) {

    function get_blood_group() {
        $ci = & get_instance();
        return array(
            'a_positive' => $ci->lang->line('a_positive'),
            'a_negative' => $ci->lang->line('a_negative'),
            'b_positive' => $ci->lang->line('b_positive'),
            'b_negative' => $ci->lang->line('b_negative'),
            'o_positive' => $ci->lang->line('o_positive'),
            'o_negative' => $ci->lang->line('o_negative'),
            'ab_positive' => $ci->lang->line('ab_positive'),
            'ab_negative' => $ci->lang->line('ab_negative')
        );
    }

}

if (!function_exists('get_subject_type')) {

    function get_subject_type() {
        $ci = & get_instance();
        return array(
            'mandatory' => $ci->lang->line('mandatory'),
            'optional' => $ci->lang->line('optional')
        );
    }

}

if (!function_exists('get_groups')) {

    function get_groups() {
        $ci = & get_instance();
        return array(
            'science' => $ci->lang->line('science'),
            'arts' => $ci->lang->line('arts'),
            'commerce' => $ci->lang->line('commerce')
        );
    }

}


if (!function_exists('get_week_days')) {

    function get_week_days() {
        $ci = & get_instance();
        return array(
            'saturday' => $ci->lang->line('saturday'),
            'sunday' => $ci->lang->line('sunday'),
            'monday' => $ci->lang->line('monday'),
            'tuesday' => $ci->lang->line('tuesday'),
            'wednesday' => $ci->lang->line('wednesday'),
            'thursday' => $ci->lang->line('thursday'),
            'friday' => $ci->lang->line('friday')
        );
    }

}

if (!function_exists('get_months')) {

    function get_months() {
        $ci = & get_instance();
        return array(
            'january' => $ci->lang->line('january'),
            'february' => $ci->lang->line('february'),
            'march' => $ci->lang->line('march'),
            'april' => $ci->lang->line('april'),
            'may' => $ci->lang->line('may'),
            'june' => $ci->lang->line('june'),
            'july' => $ci->lang->line('july'),
            'august' => $ci->lang->line('august'),
            'september' => $ci->lang->line('september'),
            'october' => $ci->lang->line('october'),
            'november' => $ci->lang->line('november'),
            'december' => $ci->lang->line('december')
        );
    }

}

if (!function_exists('get_hostel_types')) {

    function get_hostel_types() {
        $ci = & get_instance();
        return array(
            'boys' => $ci->lang->line('boys'),
            'girls' => $ci->lang->line('girls'),
            'combine' => $ci->lang->line('combine')
        );
    }
}

if (!function_exists('get_page_location')) {

    function get_page_location() {
        $ci = & get_instance();
        return array(
            'header' => $ci->lang->line('header'),
            'footer' => $ci->lang->line('footer'),
        );
    }
}

if (!function_exists('get_room_types')) {

    function get_room_types() {
        $ci = & get_instance();
        return array(
            'ac' => $ci->lang->line('ac'),
            'non_ac' => $ci->lang->line('non_ac')
        );
    }

}


if (!function_exists('get_genders')) {

    function get_genders() {
        $ci = & get_instance();
        return array(
            'male' => $ci->lang->line('male'),
            'female' => $ci->lang->line('female')
        );
    }

}

if (!function_exists('get_paid_types')) {

    function get_paid_status($status) {
        $ci = & get_instance();
        $data = array(
            'paid' => $ci->lang->line('paid'),
            'unpaid' => $ci->lang->line('unpaid'),
            'partial' => $ci->lang->line('partial')
        );
        return $data[$status];
    }

}

if (!function_exists('get_relation_types')) {

    function get_relation_types() {
        $ci = & get_instance();
        return array(
            'father' => $ci->lang->line('father'),
            'mother' => $ci->lang->line('mother'),
            'sister' => $ci->lang->line('sister'),
            'brother' => $ci->lang->line('brother'),
            'uncle' => $ci->lang->line('uncle'),
            'maternal_uncle' => $ci->lang->line('maternal_uncle'),
            'other_relative' => $ci->lang->line('other_relative')
        );
    }

}

if (!function_exists('get_payment_methods')) {

    function get_payment_methods($school_id = null) {
        $ci = & get_instance();

        $methods = array('cash' => $ci->lang->line('cash'), 'cheque' => $ci->lang->line('cheque'));

        if($ci->session->userdata('role_id') != SUPER_ADMIN){
            $school_id =  $ci->session->userdata('school_id');
        }

        $ci->db->select('PS.*');
        $ci->db->from('payment_settings AS PS');
        if($school_id){
            $ci->db->where('PS.school_id', $school_id);
        }

        $data = $ci->db->get()->row();
        if(!empty($data)){
            if ($data->paypal_status) {
                $methods['paypal'] = $ci->lang->line('paypal');
            }
            if ($data->payumoney_status) {
                $methods['payumoney'] = $ci->lang->line('payumoney');
            }
            /*if ($data->stripe_status) {
                $methods['stripe'] = $ci->lang->line('stripe');
            }
            if ($data->ccavenue_status) {
                $methods['ccavenue'] = $ci->lang->line('ccavenue');
            }*/
            if ($data->paytm_status) {
                $methods['paytm'] = $ci->lang->line('paytm');
            }
            if ($data->stack_status) {
                $methods['paystack'] = $ci->lang->line('pay_stack');
            }
            if ($data->pesapal_status) {
                $methods['pesapal'] = $ci->lang->line('pesapal');
            }
        }
// print_r($methods); die();
        return $methods;
    }

}

if (!function_exists('get_sms_gateways')) {

    function get_sms_gateways( $school_id ) {

        $ci = & get_instance();
        $gateways = array();

        $ci->db->select('SS.*');
        $ci->db->from('sms_settings AS SS');
        $ci->db->where('SS.school_id', $school_id);
        $data = $ci->db->get()->row();

        if(!empty($data)){

            if ($data->clickatell_status) {
                $gateways['clicktell'] = $ci->lang->line('clicktell');
            }
            if ($data->twilio_status) {
                $gateways['twilio'] = $ci->lang->line('twilio');
            }
            if ($data->bulk_status) {
                $gateways['bulk'] = $ci->lang->line('bulk');
            }
            if ($data->msg91_status) {
                $gateways['msg91'] = $ci->lang->line('msg91');
            }
            if ($data->plivo_status) {
                $gateways['plivo'] = $ci->lang->line('plivo');
            }
            if ($data->textlocal_status) {
                $gateways['text_local'] = $ci->lang->line('text_local');
            }
            if ($data->smscountry_status) {
                $gateways['sms_country'] = $ci->lang->line('sms_country');
            }
            if ($data->betasms_status) {
                $gateways['beta_sms'] = $ci->lang->line('beta_sms');
            }
            if ($data->siltech_status) {
                $gateways['siltech_sms'] = $ci->lang->line('siltech_sms');
            }
         }
        return $gateways;
    }

}


if (!function_exists('get_group_by_type')) {

    function get_group_by_type() {
        $ci = & get_instance();
        return array(
            'daily' => $ci->lang->line('daily'),
            'monthly' => $ci->lang->line('monthly'),
            'yearly' => $ci->lang->line('yearly')
        );
    }

}


if (!function_exists('get_template_tags')) {

    function get_template_tags($role_id) {
        $tags = array();
        $tags[] = '[name]';
        $tags[] = '[email]';
        $tags[] = '[phone]';

        if($role_id == SUPER_ADMIN){

            $tags[] = '[designation]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
        }elseif ($role_id == STUDENT) {

            $tags[] = '[class_name]';
            $tags[] = '[section]';
            $tags[] = '[roll_no]';
            $tags[] = '[dob]';
            $tags[] = '[gender]';
            $tags[] = '[religion]';
            $tags[] = '[blood_group]';
            $tags[] = '[registration_no]';
            $tags[] = '[group]';
            $tags[] = '[created_at]';
            $tags[] = '[guardian]';

        } else if ($role_id == GUARDIAN) {
            $tags[] = '[profession]';
        } else if ($role_id == TEACHER) {
            $tags[] = '[responsibility]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
            $tags[] = '[joining_date]';
        } else {
            $tags[] = '[designation]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
            $tags[] = '[joining_date]';
        }

        $tags[] = '[present_address]';
        $tags[] = '[permanent_address]';

        return $tags;
    }

}

if (!function_exists('get_formatted_body')) {

    function get_formatted_body($body, $role_id, $user_id) {

        $tags = get_template_tags($role_id);
        $user = get_user_by_role($role_id, $user_id);

        $arr = array('[', ']');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);

            if($field == 'created_at'){
                $body = str_replace($tag, date('M-d-Y', strtotime($user->created_at)), $body);
            }else{
                $body = str_replace($tag, $user->{$field}, $body);
            }
        }

        return $body;
    }
}

if (!function_exists('get_formatted_certificate_text')) {

    function get_formatted_certificate_text($body, $role_id, $user_id) {

        $tags = get_template_tags($role_id);
        $user = get_user_by_role($role_id, $user_id);

        $arr = array('[', ']');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);

            if($field == 'created_at'){
                $body = str_replace($tag, '<span>'.date('M-d-Y', strtotime($user->created_at)).'</span>', $body);
            }else{
                $body = str_replace($tag, '<span>'.$user->{$field}.'</span>', $body);
            }
        }

        return $body;
    }
}



if (!function_exists('get_nice_time')) {

    function get_nice_time($date) {

        $ci = & get_instance();
        if (empty($date)) {
            return "2 months ago"; //"No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "2 months ago"; // "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

}



if (!function_exists('get_inbox_message')) {

    function get_inbox_message() {
        $ci = & get_instance();
        $ci->db->select('MR.*, M.*');
        $ci->db->from('message_relationships AS MR');
        $ci->db->join('messages AS M', 'M.id = MR.message_id', 'left');
        $ci->db->where('MR.status', 1);
        $ci->db->where('MR.is_read', 0);
        $ci->db->where('MR.owner_id', logged_in_user_id());
        $ci->db->where('MR.receiver_id', logged_in_user_id());
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_hostel_by_school')) {

    function get_hostel_by_school($school_id) {
        $ci = & get_instance();
        $ci->db->select('H.*');
        $ci->db->from('hostels AS H');
        $ci->db->where('H.school_id', $school_id);
       return $ci->db->get()->result();
    }

}

if (!function_exists('get_gallery_images')) {

    function get_gallery_images($school_id, $gallery_id) {
        $ci = & get_instance();
        $ci->db->select('GI.*');
        $ci->db->from('gallery_images AS GI');
        $ci->db->where('GI.school_id', $school_id);
        $ci->db->where('GI.gallery_id', $gallery_id);
       return $ci->db->get()->result();
    }
}


if (!function_exists('get_fee_amount')) {

    function get_fee_amount($income_head_id, $class_id) {
        $ci = & get_instance();
        return $ci->db->get_where('fees_amount', array('class_id'=>$class_id, 'income_head_id'=>$income_head_id))->row();
    }
}

if (!function_exists('get_invoice_paid_amount')) {

    function get_invoice_paid_amount($invoice_id){
        $ci = & get_instance();
        $ci->db->select('I.*, SUM(T.amount) AS paid_amount');
        $ci->db->from('invoices AS I');
        $ci->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $ci->db->where('I.id', $invoice_id);
        return $ci->db->get()->row();
    }
}

if (!function_exists('get_operation_by_module')) {

    function get_operation_by_module($module_id) {
        $ci = & get_instance();
        $ci->db->select('O.*');
        $ci->db->from('operations AS O');
        $ci->db->where('O.module_id', $module_id);
        return $ci->db->get()->result();
    }

}

if (!function_exists('get_permission_by_operation')) {

    function get_permission_by_operation($role_id, $operation_id) {
        $ci = & get_instance();
        $ci->db->select('P.*');
        $ci->db->from('privileges AS P');
        $ci->db->where('P.role_id', $role_id);
        $ci->db->where('P.operation_id', $operation_id);
        return $ci->db->get()->row();
    }
}

if (!function_exists('get_school_list')) {

    function get_school_list() {
        $ci = & get_instance();
        $ci->db->select('S.*');
        $ci->db->from('schools AS S');
        $ci->db->where('S.status', 1);
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_lang')) {

    function get_lang() {
        $ci = & get_instance();
        $ci->lang->line('dashboard');
    }

}

if (!function_exists('get_default_lang_list')) {

    function get_default_lang_list($lang) {
        $lang_lists = array();
        $lang_lists['english'] = 'english';
        $lang_lists['bengali'] = 'bengali';
        $lang_lists['spanish'] = 'spanish';
        $lang_lists['arabic'] = 'arabic';
        $lang_lists['hindi'] = 'hindi';
        $lang_lists['urdu'] = 'urdu';
        $lang_lists['chinese'] = 'chinese';
        $lang_lists['japanese'] = 'japanese';
        $lang_lists['portuguese'] = 'portuguese';
        $lang_lists['russian'] = 'russian';
        $lang_lists['french'] = 'french';
        $lang_lists['korean'] = 'korean';
        $lang_lists['german'] = 'german';
        $lang_lists['italian'] = 'italian';
        $lang_lists['thai'] = 'thai';
        $lang_lists['hungarian'] = 'hungarian';
        $lang_lists['dutch'] = 'dutch';
        $lang_lists['latin'] = 'latin';
        $lang_lists['indonesian'] = 'indonesian';
        $lang_lists['turkish'] = 'turkish';
        $lang_lists['greek'] = 'greek';
        $lang_lists['persian'] = 'persian';
        $lang_lists['malay'] = 'malay';
        $lang_lists['telugu'] = 'telugu';
        $lang_lists['tamil'] = 'tamil';
        $lang_lists['gujarati'] = 'gujarati';
        $lang_lists['polish'] = 'polish';
        $lang_lists['ukrainian'] = 'ukrainian';
        $lang_lists['panjabi'] = 'panjabi';
        $lang_lists['romanian'] = 'romanian';
        $lang_lists['burmese'] = 'burmese';
        $lang_lists['yoruba'] = 'yoruba';
        $lang_lists['hausa'] = 'hausa';

        if (isset($lang_lists[$lang]) && !empty($lang_lists[$lang])) {
            return true;
        } else {
            return FALSE;
        }
    }

}


if (!function_exists('get_timezones')) {
    function get_timezones() {
        $timezones = array(
            'Pacific/Midway' => "(GMT-11:00) Midway Island",
            'US/Samoa' => "(GMT-11:00) Samoa",
            'US/Hawaii' => "(GMT-10:00) Hawaii",
            'US/Alaska' => "(GMT-09:00) Alaska",
            'US/Pacific' => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana' => "(GMT-08:00) Tijuana",
            'US/Arizona' => "(GMT-07:00) Arizona",
            'US/Mountain' => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua' => "(GMT-07:00) Chihuahua",
            'America/Mazatlan' => "(GMT-07:00) Mazatlan",
            'America/Mexico_City' => "(GMT-06:00) Mexico City",
            'America/Monterrey' => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
            'US/Central' => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern' => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana' => "(GMT-05:00) Indiana (East)",
            'America/Bogota' => "(GMT-05:00) Bogota",
            'America/Lima' => "(GMT-05:00) Lima",
            'America/Caracas' => "(GMT-04:30) Caracas",
            'Canada/Atlantic' => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz' => "(GMT-04:00) La Paz",
            'America/Santiago' => "(GMT-04:00) Santiago",
            'Canada/Newfoundland' => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland' => "(GMT-03:00) Greenland",
            'Atlantic/Stanley' => "(GMT-02:00) Stanley",
            'Atlantic/Azores' => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca' => "(GMT) Casablanca",
            'Europe/Dublin' => "(GMT) Dublin",
            'Europe/Lisbon' => "(GMT) Lisbon",
            'Europe/London' => "(GMT) London",
            'Africa/Monrovia' => "(GMT) Monrovia",
            'Europe/Amsterdam' => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade' => "(GMT+01:00) Belgrade",
            'Europe/Berlin' => "(GMT+01:00) Berlin",
            'Europe/Bratislava' => "(GMT+01:00) Bratislava",
            'Europe/Brussels' => "(GMT+01:00) Brussels",
            'Europe/Budapest' => "(GMT+01:00) Budapest",
            'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana' => "(GMT+01:00) Ljubljana",
            'Europe/Madrid' => "(GMT+01:00) Madrid",
            'Europe/Paris' => "(GMT+01:00) Paris",
            'Europe/Prague' => "(GMT+01:00) Prague",
            'Europe/Rome' => "(GMT+01:00) Rome",
            'Europe/Sarajevo' => "(GMT+01:00) Sarajevo",
            'Europe/Skopje' => "(GMT+01:00) Skopje",
            'Europe/Stockholm' => "(GMT+01:00) Stockholm",
            'Europe/Vienna' => "(GMT+01:00) Vienna",
            'Europe/Warsaw' => "(GMT+01:00) Warsaw",
            'Europe/Zagreb' => "(GMT+01:00) Zagreb",
            'Europe/Athens' => "(GMT+02:00) Athens",
            'Europe/Bucharest' => "(GMT+02:00) Bucharest",
            'Africa/Cairo' => "(GMT+02:00) Cairo",
            'Africa/Harare' => "(GMT+02:00) Harare",
            'Europe/Helsinki' => "(GMT+02:00) Helsinki",
            'Europe/Istanbul' => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem' => "(GMT+02:00) Jerusalem",
            'Europe/Kiev' => "(GMT+02:00) Kyiv",
            'Europe/Minsk' => "(GMT+02:00) Minsk",
            'Europe/Riga' => "(GMT+02:00) Riga",
            'Europe/Sofia' => "(GMT+02:00) Sofia",
            'Europe/Tallinn' => "(GMT+02:00) Tallinn",
            'Europe/Vilnius' => "(GMT+02:00) Vilnius",
            'Asia/Baghdad' => "(GMT+03:00) Baghdad",
            'Asia/Kuwait' => "(GMT+03:00) Kuwait",
            'Africa/Nairobi' => "(GMT+03:00) Nairobi",
            'Asia/Riyadh' => "(GMT+03:00) Riyadh",
            'Asia/Tehran' => "(GMT+03:30) Tehran",
            'Europe/Moscow' => "(GMT+04:00) Moscow",
            'Asia/Baku' => "(GMT+04:00) Baku",
            'Europe/Volgograd' => "(GMT+04:00) Volgograd",
            'Asia/Muscat' => "(GMT+04:00) Muscat",
            'Asia/Tbilisi' => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan' => "(GMT+04:00) Yerevan",
            'Asia/Kabul' => "(GMT+04:30) Kabul",
            'Asia/Karachi' => "(GMT+05:00) Karachi",
            'Asia/Tashkent' => "(GMT+05:00) Tashkent",
            'Asia/Kolkata' => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu' => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg' => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty' => "(GMT+06:00) Almaty",
            'Asia/Dhaka' => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk' => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok' => "(GMT+07:00) Bangkok",
            'Asia/Jakarta' => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk' => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing' => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong' => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth' => "(GMT+08:00) Perth",
            'Asia/Singapore' => "(GMT+08:00) Singapore",
            'Asia/Taipei' => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar' => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi' => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk' => "(GMT+09:00) Irkutsk",
            'Asia/Seoul' => "(GMT+09:00) Seoul",
            'Asia/Tokyo' => "(GMT+09:00) Tokyo",
            'Australia/Adelaide' => "(GMT+09:30) Adelaide",
            'Australia/Darwin' => "(GMT+09:30) Darwin",
            'Asia/Yakutsk' => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane' => "(GMT+10:00) Brisbane",
            'Australia/Canberra' => "(GMT+10:00) Canberra",
            'Pacific/Guam' => "(GMT+10:00) Guam",
            'Australia/Hobart' => "(GMT+10:00) Hobart",
            'Australia/Melbourne' => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney' => "(GMT+10:00) Sydney",
            'Asia/Vladivostok' => "(GMT+11:00) Vladivostok",
            'Asia/Magadan' => "(GMT+12:00) Magadan",
            'Pacific/Auckland' => "(GMT+12:00) Auckland",
            'Pacific/Fiji' => "(GMT+12:00) Fiji",
        );

        return $timezones;
    }
}


if (!function_exists('get_date_format')) {
    function get_date_format() {

        $date = array();
        $date['Y-m-d'] = '2001-03-15';
        $date['d-m-Y'] = '15-03-2018';
        $date['d/m/Y'] = '15/03/2018';
        $date['m/d/Y'] = '03/15/2018';
        $date['m.d.Y'] = '03.10.2018';
        $date['j, n, Y'] = '14, 7, 2018';
        $date['F j, Y'] = 'July 15, 2018';
        $date['M j, Y'] = 'Jul 13, 2018';
        $date['j M, Y'] = '13 Jul, 2018';

        return $date;
    }
}


if (!function_exists('get_mail_protocol')) {
    function get_mail_protocol() {

        $protocol = array();
        $protocol['mail'] = 'mail';
        $protocol['sendmail'] = 'sendmail';
        $protocol['smtp'] = 'smtp';

        return $protocol;
    }
}

if (!function_exists('get_smtp_crypto')) {
    function get_smtp_crypto() {

        $smtp_crypto = array();
        $smtp_crypto['tls'] = 'tls';
        $smtp_crypto['ssl'] = 'ssl';

        return $smtp_crypto;
    }
}

if (!function_exists('get_mail_type')) {
    function get_mail_type() {

        $mail_type = array();
        $mail_type['text'] = 'text';
        $mail_type['html'] = 'html';

        return $mail_type;
    }
}

if (!function_exists('get_char_set')) {
    function get_char_set() {

        $char_set = array();
        $char_set['utf-8'] = 'utf-8';
        $char_set['iso-8859-1'] = 'iso-8859-1';

        return $char_set;
    }
}

if (!function_exists('get_email_priority')) {
    function get_email_priority() {

        $priority = array();
        $priority['1'] = 'highest';
        $priority['3'] = 'normal';
        $priority['5'] = 'lowest';

        return $priority;
    }
}

if (!function_exists('get_card_bottom_text_align')) {
    function get_card_bottom_text_align() {

        $text_align = array();
        $text_align['center'] = 'center';
        $text_align['left'] = 'left';
        $text_align['right'] = 'right';

        return $text_align;
    }
}




if (!function_exists('check_permission')) {

    function check_permission($action) {

        $ci = & get_instance();
        $role_id = $ci->session->userdata('role_id');
        $operation_slug = $ci->router->fetch_class();
        $module_slug = $ci->router->fetch_module();

        if ($module_slug == '') {
            $module_slug = $operation_slug;
        }

        $module_slug = 'my_' . $module_slug;

        $data = $ci->config->item($operation_slug, $module_slug);
        //echo '<pre>';echo $operation_slug.'=='.$data[$role_id];print_r($data);//die();
        $result = $data[$role_id];

        if (!empty($result)) {
            $array = explode('|', $result);
            //echo '=====';print_r($array);die();
            if (!$array[$action]) {
                error($ci->lang->line('permission_denied'));
                redirect('dashboard');
            }
        } else {
            error($ci->lang->line('permission_denied'));
            redirect('dashboard');
        }

        return TRUE;
    }

}

if (!function_exists('has_permission')) {

    function has_permission($action, $module_slug = null, $operation_slug = null) {

        $ci = & get_instance();
        $role_id = $ci->session->userdata('role_id');

        if ($module_slug == '') {
            $module_slug = $operation_slug;
        }

        $module_slug = 'my_' . $module_slug;

        $data = $ci->config->item($operation_slug, $module_slug);

        $result = @$data[$role_id];

        if (!empty($result)) {
            $array = explode('|', $result);
            return $array[$action];
        } else {
            return FALSE;
        }
    }

}


if (!function_exists('create_log')) {

    function create_log($activity = null) {

        $ci = & get_instance();
        $data = array();

        if($ci->session->userdata('role_id') == SUPER_ADMIN){
            $data['school_id'] = 0;
        }else{
            $data['school_id'] = $ci->session->userdata('school_id');
        }

        $data['user_id'] = logged_in_user_id();
        $data['role_id'] = logged_in_role_id();
        $user = get_user_by_id($data['user_id']);

        $data['name'] = $user->name;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['activity'] = $activity;
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $ci->db->insert('activity_logs', $data);
    }
}




/* STRICT DATA ACCESS START*/


if (!function_exists('get_guardian_access_data')) {

 function get_guardian_access_data($type = NULL){


        $ci = & get_instance();

         if($ci->session->userdata('role_id') != GUARDIAN){
             return FALSE;
         }

        $school_id = $ci->session->userdata('school_id');
        $guardian_id = $ci->session->userdata('profile_id');
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();

        $ci->db->select('E.student_id, E.roll_no, E.class_id, E.section_id, C.name AS class_name, SE.name AS section');
        $ci->db->from('enrollments AS E');
        $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
        $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $ci->db->where('E.academic_year_id', $school->academic_year_id);
        $ci->db->where('S.guardian_id', $guardian_id);
        $ci->db->where('S.school_id', $school_id);
        $result = $ci->db->get()->result();
        $data = array();

       if(!empty($result )){
            if($type == 'class'){

                foreach($result as $obj){
                    $data[] = $obj->class_id;
                }

            }elseif($type == 'section'){

                foreach($result as $obj){
                    $data[] = $obj->section_id;
                }

            }elseif($type == 'student'){

                foreach($result as $obj){
                    $data[] = $obj->student_id;
                }
            }elseif($type == 'subject'){

                foreach($result as $obj){
                    $data[] = $obj->class_id;
                }

                // Getting subject ids by classes
                $ci->db->select('S.*');
                $ci->db->from('subjects AS S');
                $ci->db->where_in('S.class_id', implode(',', $data));
                $ci->db->order_by("S.id", "ASC");
                $subjects= $ci->db->get()->result();

                foreach($subjects as $obj){
                    $data[] = $obj->teacher_id;
                }

            }
       }

       return $data;
   }
}


if (!function_exists('get_teacher_access_data')) {

 function get_teacher_access_data($type = NULL){

        $ci = & get_instance();

         if($ci->session->userdata('role_id') != TEACHER){
             return FALSE;
         }

        $school_id = $ci->session->userdata('school_id');
        $teacher_id = $ci->session->userdata('profile_id');
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();

        $data = array();

        if($type == 'student'){

            $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
            $ci->db->from('routines AS R');
            $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
            $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
            $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id'));
            $ci->db->where('R.school_id', $school_id);
            $ci->db->order_by("R.id", "ASC");
            $result = $ci->db->get()->result();

            foreach($result as $obj){
                $data[] = $obj->class_id;
            }

        }elseif($type == 'subject'){

            $ci->db->select('S.*');
            $ci->db->from('subjects AS S');
            $ci->db->where('S.teacher_id', $ci->session->userdata('profile_id'));
            $ci->db->order_by("S.id", "ASC");
            $result = $ci->db->get()->result();

            foreach($result as $obj){
                $data[] = $obj->id;
            }
        }


       return $data;
   }
}

if (!function_exists('get_exam_details')) {
  function get_exam_details($school_id, $exam_id, $class_id, $academic_year_id,$student_id){
    $ci = & get_instance();

    $ci->db->select('MET.name as exam_type_name, M.student_id,M.subject_id,M.school_id, MD.marks_obtained,ETM.max_marks,M.exam_id');

    $ci->db->from('marks AS M');
    $ci->db->join('marks_details AS MD', 'M.id = MD.marks_id', 'left');
    $ci->db->join('master_exam_types AS MET', 'MET.id = MD.exam_type_id', 'left');
    $ci->db->join('exam_type_mapping AS ETM', 'ETM.id = MD.exam_type_id', 'left');

    $ci->db->where('M.school_id', $school_id);
    $ci->db->where('M.exam_id', $exam_id);
    $ci->db->where('M.class_id', $class_id);
    $ci->db->where('M.academic_year_id', $academic_year_id);
    $ci->db->where('M.student_id', $student_id);

    $res = $ci->db->get();
    //print_r($ci->db->last_query());    die();

    return $res->result();
    //return $this->db->get()->result();
  }
}

if (!function_exists('get_exam_details_by_subject')) {
    function get_exam_details_by_subject($school_id, $exam_id, $class_id, $academic_year_id,$subject_id,$student_id){
      $ci = & get_instance();

      $ci->db->select('MET.name as exam_type_name, M.student_id,M.subject_id,M.school_id, MD.marks_obtained,ETM.max_marks,M.exam_id');

      $ci->db->from('marks AS M');
      $ci->db->join('marks_details AS MD', 'M.id = MD.marks_id', 'left');
      $ci->db->join('master_exam_types AS MET', 'MET.id = MD.exam_type_id', 'left');
      $ci->db->join('exam_type_mapping AS ETM', '(ETM.exam_id = M.exam_id AND ETM.subject_id = M.subject_id and ETM.exam_type_id = MD.exam_type_id)', 'left');

      $ci->db->where('M.school_id', $school_id);
      $ci->db->where('M.exam_id', $exam_id);
      $ci->db->where('M.class_id', $class_id);
      $ci->db->where('M.academic_year_id', $academic_year_id);
      $ci->db->where('M.subject_id', $subject_id);
      $ci->db->where('M.student_id', $student_id);

      $res = $ci->db->get();
      //print_r($ci->db->last_query());    die();

      return $res->result();
      //return $this->db->get()->result();
    }
  }


if (!function_exists('get_exam_type_details')) {
    function get_exam_type_details($school_id, $class_id, $academic_year_id,$student_id){
      $ci = & get_instance();

      $select = $ci->db->select('E.id as id');
      $ci->db->from('exams AS E');
      $ci->db->where('E.school_id', $school_id);
      $ci->db->where('E.academic_year_id', $academic_year_id);
      $res = $ci->db->get();
      foreach ($res->result() as $row){
        $ids[] = $row->id;
       }
      $ci->db->select('Distinct(MET.name) as exam_type_name');
      $ci->db->from('exam_type_mapping AS ETM');
      $ci->db->join('master_exam_types AS MET', 'MET.id = ETM.exam_type_id');
      $ci->db->where('ETM.class_id', $class_id);
      $ci->db->where('ETM.academic_year_id', $academic_year_id);
      $ci->db->where_in('ETM.exam_id', $ids);

      $res = $ci->db->get();
      //print_r($ci->db->last_query());    die();

      return $res->result();
      //return $this->db->get()->result();
    }
  }

if (!function_exists('get_student_access_data')) {

 function get_student_access_data($type = NULL){

        $ci = & get_instance();
         if($ci->session->userdata('role_id') != STUDENT){
             return FALSE;
         }

        $school_id = $ci->session->userdata('school_id');
        $student_id = $ci->session->userdata('profile_id');
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();

        $data = array();

        if($type == 'student'){

            $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
            $ci->db->from('routines AS R');
            $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
            $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
            $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id'));
            $ci->db->order_by("R.id", "ASC");
            $result = $ci->db->get()->result();

            foreach($result as $obj){
                $data[] = $obj->class_id;
            }
        }elseif($type == 'subject'){

            $ci->db->select('S.*');
            $ci->db->from('subjects AS S');
            $ci->db->where('S.class_id', $ci->session->userdata('class_id'));
            $ci->db->order_by("S.id", "ASC");
            $result = $ci->db->get()->result();

            foreach($result as $obj){
                $data[] = $obj->teacher_id;
            }
        }


       return $data;
   }
}

// For  APIs

if (!function_exists('api_get_exam_details_by_subject')) {
    function api_get_exam_details_by_subject($school_id, $exam_id, $class_id, $academic_year_id,$subject_id,$student_id){
      $ci = & get_instance();

      $ci->db->select('MET.name as name, ETM.exam_type_id as type_id,M.student_id,M.subject_id,M.school_id, MD.marks_obtained as obtain,ETM.max_marks as max,M.exam_id');

      $ci->db->from('marks AS M');
      $ci->db->join('marks_details AS MD', 'M.id = MD.marks_id', 'left');

      $ci->db->join('master_exam_types AS MET', 'MET.id = MD.exam_type_id', 'left');
      $ci->db->join('exam_type_mapping AS ETM', '(ETM.exam_id = M.exam_id AND ETM.subject_id = M.subject_id and ETM.exam_type_id = MD.exam_type_id)', 'left');


      //$ci->db->join('master_exam_types AS MET', 'MET.id = MD.exam_type_id', 'left');
      //$ci->db->join('exam_type_mapping AS ETM', 'ETM.id = MD.exam_type_id', 'left');

      $ci->db->where('M.school_id', $school_id);
      $ci->db->where('M.exam_id', $exam_id);
      $ci->db->where('M.class_id', $class_id);
      $ci->db->where('M.academic_year_id', $academic_year_id);
      $ci->db->where('M.subject_id', $subject_id);
      $ci->db->where('M.student_id', $student_id);

      $res = $ci->db->get();
      //print_r($ci->db->last_query()); //   die();

      return $res->result();
      //return $this->db->get()->result();
    }
  }

  if (!function_exists('api_get_all_exam_results')) {
    function api_get_all_exam_results($school_id, $class_id, $academic_year_id,$section_id,$student_id){
      $ci = & get_instance();

      $ci->db->select('E.id,E.title,ER.total_subject,ER.total_mark,ER.total_obtain_mark,ER.avg_grade_point,ER.result_status,ER.merit_rank_in_class, ER.merit_rank_in_section, ER.remark,G.name as grade');

      $ci->db->from('exams AS E');
      $ci->db->join('exam_results AS ER', 'E.id = ER.exam_id', 'left');
      $ci->db->join('grades AS G', 'ER.grade_id = G.id', 'left');

      $ci->db->where('ER.school_id', $school_id);
      $ci->db->where('ER.class_id', $class_id);
      $ci->db->where('ER.academic_year_id', $academic_year_id);
      $ci->db->where('ER.section_id', $section_id);
      $ci->db->where('ER.student_id', $student_id);

      $res = $ci->db->get();
      //print_r($ci->db->last_query());    die();

      return $res->result();
      //return $this->db->get()->result();
    }
  }

  if (!function_exists('api_get_subject_list')) {

    function api_get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null,$subject_id) {
        $ci = & get_instance();
        $ci->db->select('M.*,S.name AS subject, G.point, G.name,MIN(M.obtain_total_mark) AS lowest, MAX(M.obtain_total_mark) AS highest');
        $ci->db->from('marks AS M');
        $ci->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.subject_id', $subject_id);
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);
        $res = $ci->db->get();
         //print_r($ci->db->last_query());    die();

      return $res->row();
      //return $this->db->get()->result();
      //  return  $ci->db->get()->result();
    }

}

if (!function_exists('api_get_lowest_mark')) {

    function api_get_lowest_mark($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('MIN(M.obtain_total_mark) AS lowest');
        $ci->db->from('marks AS M');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.section_id', $section_id);
        $ci->db->where('M.subject_id', $subject_id);
        return  $ci->db->get()->row();
     // echo $ci->db->last_query();
    }
}

if (!function_exists('api_get_highest_mark')) {

    function api_get_highest_mark($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('MAX(M.obtain_total_mark) AS height');
        $ci->db->from('marks AS M');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.section_id', $section_id);
        $ci->db->where('M.subject_id', $subject_id);

       return $ci->db->get()->row();
     // echo $ci->db->last_query();
    }
}

if (!function_exists('api_get_student_all_teacher_list')) {

    function api_get_student_all_teacher_list($school_id, $class_id, $section_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('DISTINCT(T.name) as teacher_name,T.user_id ,T.photo as image,S.*');
        $ci->db->from('teachers AS T');
        $ci->db->join('subjects AS S', 'S.teacher_id = T.id','LEFT');
        $ci->db->group_by('T.name');
        $ci->db->join('sections AS SEC', 'SEC.class_id = S.class_id');
        $ci->db->where('S.school_id', $school_id);
        $ci->db->where('S.class_id', $class_id);
        $ci->db->where('SEC.id', $section_id);

        if($search){
            //if keyword is present, add this condition as well
         $where = "( T.name LIKE '%$search%' )";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
        //$ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_all_teacher_count')) {

    function api_get_all_teacher_count($school_id, $class_id, $section_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(DISTINCT(T.name)) as count,T.name');
        $ci->db->from('teachers AS T');
        $ci->db->join('subjects AS S', 'S.teacher_id = T.id','LEFT');
        $ci->db->group_by('T.name');
        $ci->db->join('sections AS SEC', 'SEC.class_id = S.class_id');
        $ci->db->where('S.school_id', $school_id);
        $ci->db->where('S.class_id', $class_id);
        $ci->db->where('SEC.id', $section_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( T.name LIKE '%$search%')";
         $ci->db->where($where);
        }

        //$ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_teacher_subject')) {

    function api_get_teacher_subject($school_id, $class_id, $section_id,$teacher_id) {
        $ci = & get_instance();
        $ci->db->select('T.name as teacher_name,S.*');
        $ci->db->from('teachers AS T');
        $ci->db->join('subjects AS S', 'S.teacher_id = T.id','LEFT');
        //$ci->db->group_by('T.name');
        $ci->db->join('sections AS SEC', 'SEC.class_id = S.class_id');
        $ci->db->where('S.school_id', $school_id);
        $ci->db->where('S.class_id', $class_id);
        $ci->db->where('SEC.id', $section_id);
        $ci->db->where('S.teacher_id', $teacher_id);


      //  $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_routine_list')) {

    function api_get_student_routine_list($school_id, $class_id, $section_id) {
        $ci = & get_instance();
        $ci->db->select('R.*,S.name,T.name as teacher_name');
        $ci->db->from('routines AS R');
        $ci->db->join('subjects AS S', 'S.id = R.subject_id','LEFT');
        $ci->db->join('teachers AS T', 'T.id = S.teacher_id','LEFT');
        $ci->db->where('R.school_id', $school_id);
        $ci->db->where('R.class_id', $class_id);
        $ci->db->where('R.section_id', $section_id);


      //  $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_study_material')) {

    function api_get_student_study_material($school_id, $class_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('M.*,C.name as class_name,S.name as subject_name,');
        $ci->db->from('study_materials AS M');
        $ci->db->join('subjects AS S', 'S.id = M.subject_id');
        $ci->db->join('classes AS C', 'C.id = M.class_id');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.class_id', $class_id);

        if($search){
            //if keyword is present, add this condition as well
         $where = "( M.title LIKE '%$search%' OR M.description LIKE '%$search%')";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
       // $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_study_material_count')) {

    function api_get_student_study_material_count($school_id, $class_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(M.id) as count');
        $ci->db->from('study_materials AS M');
        $ci->db->join('subjects AS S', 'S.id = M.subject_id');
        $ci->db->join('classes AS C', 'C.id = M.class_id');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.class_id', $class_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( S.name LIKE '%$search%' )";
         $ci->db->where($where);
        }
        //$ci->db->get();
       return $ci->db->get()->row();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_syllabus')) {

    function api_get_student_syllabus($school_id, $class_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('L.*,C.name as class_name,S.name as subject_name,');
        $ci->db->from('syllabuses AS L');
        $ci->db->join('subjects AS S', 'S.id = L.subject_id');
        $ci->db->join('classes AS C', 'C.id = L.class_id');
        $ci->db->where('L.school_id', $school_id);
        $ci->db->where('L.class_id', $class_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( L.title LIKE '%$search%')";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
       // $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_syllabus_count')) {

    function api_get_student_syllabus_count($school_id, $class_id,$search) {
        $ci = & get_instance();
        $ci->db->select('L.id as count');
        $ci->db->from('syllabuses AS L');
        $ci->db->join('subjects AS S', 'S.id = L.subject_id');
        $ci->db->join('classes AS C', 'C.id = L.class_id');
        $ci->db->where('L.school_id', $school_id);
        $ci->db->where('L.class_id', $class_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( S.name LIKE '%$search%' )";
         $ci->db->where($where);
        }
       // $ci->db->get();
       return $ci->db->get()->row();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_assignment')) {

    function api_get_student_assignment($school_id, $class_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('A.*,C.name as class_name,S.name as subject_name,');
        $ci->db->from('assignments AS A');
        $ci->db->join('subjects AS S', 'S.id = A.subject_id');
        $ci->db->join('classes AS C', 'C.id = A.class_id');
        $ci->db->where('A.school_id', $school_id);
        $ci->db->where('A.class_id', $class_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( S.subject_name LIKE '%$search%')";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
       // $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_assignment_count')) {

    function api_get_student_assignment_count($school_id, $class_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(A.id) as count');
        $ci->db->from('assignments AS A');
        $ci->db->join('subjects AS S', 'S.id = A.subject_id');
        $ci->db->join('classes AS C', 'C.id = A.class_id');
        $ci->db->where('A.school_id', $school_id);
        $ci->db->where('A.class_id', $class_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( S.name LIKE '%$search%' )";
         $ci->db->where($where);
        }
       // $ci->db->get();
       return $ci->db->get()->row();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_attendance')) {

    function api_get_student_attendance($school_id, $class_id,$student_id,$section_id) {
        $ci = & get_instance();
        $ci->db->select('S.id as attendance_id,S.*');
        $ci->db->from('student_attendances AS S');
        $ci->db->where('S.school_id', $school_id);
        $ci->db->where('S.class_id', $class_id);
        $ci->db->where('S.student_id', $student_id);
        $ci->db->where('S.section_id', $section_id);

        //$ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_attendance1')) {

    function api_get_student_attendance1($student_id, $school_id, $academic_year_id, $class_id, $section_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('SA.' . $field);
        $ci->db->from('student_attendances AS SA');
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.class_id', $class_id);

        if($section_id){
            $ci->db->where('SA.section_id', $section_id);
        }

        $ci->db->where('SA.year', $year);
        $ci->db->where('SA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}


if (!function_exists('api_get_student_monthly_attendance')) {

    function api_get_student_monthly_attendance($school_id, $student_id, $academic_year_id, $class_id, $section_id, $month, $days) {

        $fields = '';

        for ($i = 1; $i <= $days; $i++) {
            if ($i == $days) {
                $fields .= 'SA.day_' . $i;
            } else {
                $fields .= 'SA.day_' . $i . ',';
            }
        }

        $ci = & get_instance();
        $ci->db->select($fields);
        $ci->db->from('student_attendances AS SA');
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.class_id', $class_id);
        $ci->db->where('SA.section_id', $section_id);
        $ci->db->where('SA.month', $month);
        return $ci->db->get()->row();
    }

}


if (!function_exists('api_get_student_holidays')) {

    function api_get_student_holidays($school_id,$month) {
        $ci = & get_instance();
        $ci->db->select('H.*');
        $ci->db->from('holidays as H');
        $ci->db->where('H.school_id', $school_id);
        $ci->db->where('H.month', $month);
        return $ci->db->get()->result();
    }

}

if (!function_exists('get_school_settings')) {

    function get_school_settings($school_id) {
        $ci = & get_instance();
        $ci->db->select('G.*');
        $ci->db->from('schools as G');
        $ci->db->where('G.id', $school_id);
        return $ci->db->get()->row();
    }

}
if (!function_exists('api_get_holiday_name')) {

    function api_get_holiday_name($school_id,$id) {
        $ci = & get_instance();
        $ci->db->select('H.title');
        $ci->db->from('holidays as H');
        $ci->db->where('H.school_id', $school_id);
        $ci->db->where('H.id', $id);
        return $ci->db->get()->row();
    }

}

if (!function_exists('api_get_student_notice')) {

    function api_get_student_notice($school_id, $role_name,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('N.*');
        $ci->db->from('notices AS N');
        $ci->db->join('roles AS R', 'R.id = N.role_id');
        $ci->db->where('R.name', $role_name);
        $ci->db->where('N.school_id', $school_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( N.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
       // $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_notice_count')) {

    function api_get_student_notice_count($school_id, $role_name,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(N.id) as count');
        $ci->db->from('notices AS N');
        $ci->db->join('roles AS R', 'R.id = N.role_id');
        $ci->db->where('R.name', $role_name);
        $ci->db->where('N.school_id', $school_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( N.title LIKE '%$search%')";
         $ci->db->where($where);
        }
       // $ci->db->get();
       return $ci->db->get()->row();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_subjects')) {

    function api_get_student_subjects($school_id, $class_id) {
        $ci = & get_instance();
        $ci->db->select('S.*');
        $ci->db->from('subjects AS S');
        $ci->db->where('S.class_id', $class_id);
        $ci->db->where('S.school_id', $school_id);
       return $ci->db->get()->result();
    }
}

if (!function_exists('api_get_student_exams')) {

    function api_get_student_exams($school_id, $class_id,$academic_year_id) {
        $ci = & get_instance();
        $ci->db->select('E.*');
        $ci->db->from('exams AS E');
        $ci->db->where('E.class_id', $class_id);
        $ci->db->where('E.school_id', $school_id);
        $ci->db->where('E.academic_year_id', $academic_year_id);

       //  $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_student_holiday_list')) {

    function api_get_student_holiday_list($school_id, $month) {
        $ci = & get_instance();
        $ci->db->select('H.*');
        $ci->db->from('holidays AS H');
        $ci->db->where('H.school_id', $school_id);
        $ci->db->where('H.month', $month);

       //  $ci->db->get();
       return $ci->db->get()->result();
      //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_all_vehical_routes')) {

    function api_get_all_vehical_routes($school_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('R.*,V.number,V.model,V.contact,V.note');
        $ci->db->from('routes AS R');
        $ci->db->join('route_stops AS S', 'R.id = S.route_id');
        $ci->db->join('vehicles AS V', 'R.vehicle_ids = V.id');
        $ci->db->where('R.school_id', $school_id);
        $ci->db->group_by('R.title');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( S.stop_name LIKE '%$search%' )";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
        //  $ci->db->get();
        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_all_vehical_routes_count')) {

    function api_get_all_vehical_routes_count($school_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(R.id) as count');
        $ci->db->from('routes AS R');
        $ci->db->join('route_stops AS S', 'R.id = S.route_id');
        $ci->db->join('vehicles AS V', 'R.vehicle_ids = V.id');
        $ci->db->where('R.school_id', $school_id);
        $ci->db->group_by('R.title');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.title LIKE '%$search%')";
         $ci->db->where($where);
        }
        //  $ci->db->get();
        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_routes_details')) {

    function api_get_routes_details($school_id,$route_id,$limit,$search) {
        $ci = & get_instance();
        $ci->db->select('R.*,S.*');
        $ci->db->from('routes AS R');
        $ci->db->join('route_stops AS S', 'R.id = S.route_id');
        $ci->db->where('R.school_id', $school_id);
        $ci->db->where('S.school_id', $school_id);
        $ci->db->where('S.route_id', $route_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.title LIKE '%$search%' )";
         $ci->db->where($where);
        }


        //  $ci->db->get();
        return $ci->db->get()->result();
       // echo $ci->db->last_query();die();
    }
}


if (!function_exists('api_get_routes_details_count')) {

    function api_get_routes_details_count($school_id,$route_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(R.id) as count');
        $ci->db->from('routes AS R');
        $ci->db->join('route_stops AS S', 'R.id = S.route_id');
        $ci->db->where('R.school_id', $school_id);
        $ci->db->where('S.school_id', $school_id);
        $ci->db->where('S.route_id', $route_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
          //$ci->db->get();
        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_holiday_details')) {

    function api_get_holiday_details($school_id,$academic_year_id) {
        $ci = & get_instance();
        $ci->db->select('DISTINCT(H.id),H.*,A.date_from as from,A.date_to as to');
        $ci->db->from('holidays AS H');
        $ci->db->join('holidays_dates AS HL', 'HL.holidays_id = H.id');
        $ci->db->join('academic_years AS A', 'A.school_id = H.school_id');
        $ci->db->where('H.school_id', $school_id);
        $ci->db->where('A.id', $academic_year_id);
        $ci->db->where('HL.date BETWEEN A.date_from and A.date_to');
        $ci->db->order_by('H.date_from', 'asc');
        //$ci->db->get();
        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_library_books_list_issued_by_student')) {

    function api_library_books_list_issued_by_student($school_id,$user_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('BI.*,B.*');
        $ci->db->from('book_issues AS BI');
        $ci->db->join('library_members AS L', 'L.id = BI.library_member_id');
        $ci->db->join('books AS B', 'B.id = BI.book_id');

        $ci->db->where('BI.school_id', $school_id);
        $ci->db->where('L.user_id', $user_id);
        $ci->db->where('BI.is_returned', '0');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
        //$ci->db->get();
        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_library_books_list_issued_by_student_count')) {

    function api_library_books_list_issued_by_student_count($school_id,$user_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(BI.id) as count');
        $ci->db->from('book_issues AS BI');
        $ci->db->join('library_members AS L', 'L.id = BI.library_member_id');
        $ci->db->join('books AS B', 'B.id = BI.book_id');

        $ci->db->where('BI.school_id', $school_id);
        $ci->db->where('L.user_id', $user_id);
        $ci->db->where('BI.is_returned', '0');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
        //$ci->db->get();
        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}
if (!function_exists('api_library_books_history_student')) {

    function api_library_books_history_student($school_id,$user_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('BI.*,B.*');
        $ci->db->from('book_issues AS BI');
        $ci->db->join('library_members AS L', 'L.id = BI.library_member_id');
        $ci->db->join('books AS B', 'B.id = BI.book_id');

        $ci->db->where('BI.school_id', $school_id);
        $ci->db->where('L.user_id', $user_id);
        $ci->db->where('BI.is_returned', '1');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
        //$ci->db->get();
        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_library_books_history_student_count')) {

    function api_library_books_history_student_count($school_id,$user_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(BI.id) as count');
        $ci->db->from('book_issues AS BI');
        $ci->db->join('library_members AS L', 'L.id = BI.library_member_id');
        $ci->db->join('books AS B', 'B.id = BI.book_id');

        $ci->db->where('BI.school_id', $school_id);
        $ci->db->where('L.user_id', $user_id);
        $ci->db->where('BI.is_returned', '1');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
        //$ci->db->get();
        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}
if (!function_exists('api_library_all_books_list')) {

    function api_library_all_books_list($school_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('B.*');
        $ci->db->from('books AS B');
        $ci->db->where('B.school_id', $school_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' )";
         $ci->db->where($where);
        }
        if(isset($limit)){
        $page= ($page * 10)-10;
        $ci->db->limit($limit,$page);
        }
        //$query = $this->db->get('mytable', 10, 20);
        //$ci->db->get();

        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_library_all_books_count')) {

    function api_library_all_books_count($school_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(B.id) as count');
        $ci->db->from('books AS B');
        $ci->db->where('B.school_id', $school_id);
        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' OR B.language LIKE '%$search%' OR B.author LIKE '%$search%')";
         $ci->db->where($where);
        }
        //$query = $this->db->get('mytable', 10, 20);
        //$ci->db->get();

        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_teachers_count')) {

    function api_all_teachers_count($school_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(B.id) as count');
        $ci->db->from('books AS B');
        $ci->db->where('B.school_id', $school_id);

        if($search){
            //if keyword is present, add this condition as well
         $where = "( B.title LIKE '%$search%' OR B.language LIKE '%$search%' OR B.author LIKE '%$search%')";
         $ci->db->where($where);
        }
        //$query = $this->db->get('mytable', 10, 20);
        //$ci->db->get();

        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_route_count')) {

    function api_all_route_count($school_id,$search) {
        $ci = & get_instance();
        $ci->db->select('COUNT(DISTINCT(R.stop_name)) as count');
        $ci->db->from('route_stops AS R');
        $ci->db->where('R.school_id', $school_id);

        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.stop_name LIKE '%$search%')";
         $ci->db->where($where);
        }
        //$ci->db->get();

        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_route_details')) {

    function api_all_route_details($school_id,$limit,$page,$search) {
        $ci = & get_instance();
        $ci->db->select('DISTINCT(R.stop_name)');
        $ci->db->from('route_stops AS R');
        $ci->db->where('R.school_id', $school_id);

        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.stop_name LIKE '%$search%')";
         $ci->db->where($where);
        }

        if(isset($limit)){
            $page= ($page * 10)-10;
            $ci->db->limit($limit,$page);
            }
        //$ci->db->get();

        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_messages_count')) {

    function api_all_messages_count($school_id,$academic_year_id,$id,$teacher_id) {
        $ci = & get_instance();
        $ci->db->select('COUNT(M.id) as count');
        $ci->db->from('messages AS M');
        $ci->db->join('message_relationships AS MR', 'MR.message_id = M.id');
        $ci->db->join('users AS U', 'U.id = MR.sender_id');
        $ci->db->join('users AS UR', 'UR.id = MR.receiver_id');

        $ci->db->where('MR.school_id', $school_id);
        $ci->db->where('MR.owner_id', $id);
        $ci->db->where('(MR.sender_id = '.$teacher_id.' or MR.receiver_id='.$teacher_id.')' );
        //$ci->db->or_where('MR.receiver_id', $teacher_id);
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);


        // if($search){
        //     //if keyword is present, add this condition as well
        //  $where = "( B.title LIKE '%$search%' )";
        //  $ci->db->where($where);
        // }
        //$ci->db->get();
        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_messages_details')) {

    function api_all_messages_details($school_id,$academic_year_id,$id,$teacher_id) {
        $ci = & get_instance();
        $ci->db->select('M.id,M.subject,M.body,M.created_at as msg_created_at,MR.sender_id,MR.receiver_id,MR.owner_id,MR.is_favorite,MR.is_read,U.username as sender,UR.username as receiver');
        $ci->db->from('messages AS M');
        $ci->db->join('message_relationships AS MR', 'MR.message_id = M.id');
        $ci->db->join('users AS U', 'U.id = MR.sender_id');
        $ci->db->join('users AS UR', 'UR.id = MR.receiver_id');

        $ci->db->where('MR.school_id', $school_id);
        $ci->db->where('MR.owner_id', $id);
        $ci->db->where('(MR.sender_id = '.$teacher_id.' or MR.receiver_id='.$teacher_id.')' );
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->order_by('M.created_at', 'DESC');
        //$ci->db->get();
        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_get_teacher_id')) {

    function api_get_teacher_id($teacher_id) {
        $ci = & get_instance();
        $ci->db->select('T.user_id,U.role_id');
        $ci->db->from('teachers AS T');
        $ci->db->join('users AS U', 'U.id = T.user_id');
        $ci->db->where('T.id', $teacher_id);
        //$ci->db->get();

        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_replies_on_message_count')) {

    function api_all_replies_on_message_count($id,$teacher_id,$message_id) {
        $ci = & get_instance();
        $ci->db->select('COUNT(R.body) as count');
        $ci->db->from('replies AS R');
        $ci->db->join('messages AS M', 'M.id = R.message_id');
        $ci->db->join('users AS U', 'U.id = R.sender_id');
        $ci->db->join('users AS UR', 'UR.id = R.receiver_id');
        $ci->db->where('(R.sender_id = '.$teacher_id.' or R.receiver_id='.$teacher_id.')' );
        $ci->db->where('R.message_id', $message_id);

        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.body LIKE '%$search%')";
         $ci->db->where($where);
        }

        //$ci->db->get();
        return $ci->db->get()->row();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_all_replies_on_message_details')) {

    function api_all_replies_on_message_details($id,$teacher_id,$message_id) {
        $ci = & get_instance();
        $ci->db->select('R.body,R.receiver_id,R.created_at,R.sender_id,R.message_id,R.id,U.common_name as sender,UR.common_name as receiver');
        $ci->db->from('replies AS R');
        $ci->db->join('messages AS M', 'M.id = R.message_id');
        $ci->db->join('(SELECT sub_u.id, sub_u.role_id, sub_u.username, IF(sub_u.role_id=4,sub_s.name, sub_t.name ) as common_name
        FROM `users` as sub_u
        left join teachers as sub_t on sub_u.id=sub_t.user_id
        LEFT JOIN students as sub_s ON sub_u.id= sub_s.user_id
        where sub_u.role_id = 4 OR sub_u.role_id= 5) AS U', 'U.id = R.sender_id');
        $ci->db->join('(SELECT sub_u.id, sub_u.role_id, sub_u.username, IF(sub_u.role_id=4,sub_s.name, sub_t.name ) as common_name
        FROM `users` as sub_u
        left join teachers as sub_t on sub_u.id=sub_t.user_id
        LEFT JOIN students as sub_s ON sub_u.id= sub_s.user_id
        where sub_u.role_id = 4 OR sub_u.role_id= 5) AS UR', 'UR.id = R.receiver_id');
        $ci->db->where('(R.sender_id = '.$teacher_id.' or R.receiver_id='.$teacher_id.')' );
        $ci->db->where('R.message_id', $message_id);
        $ci->db->order_by('R.created_at', 'DESC');
        if($search){
            //if keyword is present, add this condition as well
         $where = "( R.body LIKE '%$search%')";
         $ci->db->where($where);
        }

        if(isset($limit)){
            $page= ($page * 10)-10;
            $ci->db->limit($limit,$page);
            }
        //$ci->db->get();
        return $ci->db->get()->result();
        //echo $ci->db->last_query();die();
    }
}

if (!function_exists('api_replies_on_particular_message')) {

    function api_replies_on_particular_message($id,$teacher_id,$message_id,$body) {
        $ci = & get_instance();
        $data['message_id'] = $message_id;
        $data['sender_id'] = $id;
        $data['receiver_id'] = $teacher_id;
        $data['body'] = $body;
        $data['attachment'] = '';
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $id;
        return $ci->db->insert('replies', $data);
    }
}

if (!function_exists('api_get_year_list')) {
 function api_get_year_list($school_id){
    $ci = & get_instance();
    $ci->db->select('AY.*, S.school_name');
    $ci->db->from('academic_years AS AY');
    $ci->db->join('schools AS S', 'S.id = AY.school_id', 'left');
    $ci->db->where('AY.school_id', $school_id);
    $ci->db->order_by('AY.id', 'ASC');
    return $ci->db->get()->result();
 }
}

if (!function_exists('api_get_ebook_list_count')) {
    function api_get_ebook_list_count($school_id,$class_id,$search){
       $ci = & get_instance();
       $ci->db->select('COUNT(E.id) as count');
       $ci->db->from('ebooks AS E');
       $ci->db->join('subjects AS S', 'S.id = E.subject_id');
       $ci->db->where('E.school_id', $school_id);
       $ci->db->where('E.class_id', $class_id);
       $ci->db->order_by('E.id', 'ASC');
       if($search){
            //if keyword is present, add this condition as well
         $where = "( E.name LIKE '%$search%' OR E.language LIKE '%$search%' )";
         $ci->db->where($where);
        }
       //$ci->db->get();
       return $ci->db->get()->row();
       //echo $ci->db->last_query();die();
    }
   }

   if (!function_exists('api_get_ebook_list')) {
    function api_get_ebook_list($school_id,$class_id,$search){
       $ci = & get_instance();
       $ci->db->select('E.*, S.name as subject_name');
       $ci->db->from('ebooks AS E');
       $ci->db->join('subjects AS S', 'S.id = E.subject_id');
       $ci->db->where('E.school_id', $school_id);
       $ci->db->where('E.class_id', $class_id);
       $ci->db->order_by('E.id', 'ASC');
            if($search){
                //if keyword is present, add this condition as well
            $where = "( E.name LIKE '%$search%' OR E.language LIKE '%$search%' )";
            $ci->db->where($where);
            }
       //$ci->db->get();
       return $ci->db->get()->result();
       //echo $ci->db->last_query();die();
    }
   }

   if (!function_exists('api_get_student_fees_list_count')) {
   function api_get_student_fees_list_count($school_id, $academic_year_id,$student_id,$search){
    $ci = & get_instance();
    $ci->db->select('COUNT(I.id) as count');
    $ci->db->from('invoices AS I');
    $ci->db->join('transactions AS T', 'T.invoice_id = I.id','left');

    $ci->db->join('classes AS C', 'C.id = I.class_id', 'left');
    $ci->db->join('students AS S', 'S.id = I.student_id', 'left');
    $ci->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
    $ci->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
    $ci->db->join('schools AS SC', 'SC.id = I.school_id', 'left');
    $ci->db->where('I.invoice_type !=', 'income');
    //$ci->db->where('I.paid_status !=', 'paid');
    $ci->db->where('I.student_id', $student_id);
    $ci->db->where('I.school_id', $school_id);

    $ci->db->where('I.academic_year_id', $academic_year_id);
    if($search){
        //if keyword is present, add this condition as well
    $where = " IH.title LIKE '%$search%'";
    $ci->db->where($where);
    }
    //$ci->db->order_by('I.id', 'DESC');

   //$ci->db->get();
   return $ci->db->get()->row();
   //echo $ci->db->last_query();die();
   }
}

if (!function_exists('api_get_student_fees_list_details')) {
    function api_get_student_fees_list_details($school_id, $academic_year_id,$student_id,$search){
     $ci = & get_instance();
     $ci->db->select('I.*, SC.school_name, IH.title AS head, S.name AS student_name, AY.session_year, C.name AS class_name,(SELECT SUM(`T`.amount) from `transactions` AS `T` where `T`.`invoice_id` = `I`.`id`) as `paid_amount`');
     $ci->db->from('invoices AS I');
     //$ci->db->join('transactions AS T', 'T.invoice_id = I.id','left');
     $ci->db->join('classes AS C', 'C.id = I.class_id', 'left');
     $ci->db->join('students AS S', 'S.id = I.student_id', 'left');
     $ci->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
     $ci->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
     $ci->db->join('schools AS SC', 'SC.id = I.school_id', 'left');
     $ci->db->where('I.invoice_type !=', 'income');
     //$ci->db->where('I.paid_status !=', 'paid');
     $ci->db->where('I.student_id', $student_id);
     $ci->db->where('I.school_id', $school_id);

     $ci->db->where('I.academic_year_id', $academic_year_id);
     $ci->db->order_by('I.id', 'DESC');
     if($search){
        //if keyword is present, add this condition as well
    $where = " IH.title LIKE '%$search%'";
    $ci->db->where($where);
    }
    //$ci->db->get();
    return $ci->db->get()->result();
    //echo $ci->db->last_query();die();
    }
 }

 if (!function_exists('api_change_check_password')) {
    function api_change_check_password($school_id,$user_id,$username,$old_password,$new_password){
     $ci = & get_instance();
     $ci->db->select('U.password');
     $ci->db->from('users AS U');
     $ci->db->where('U.school_id', $school_id);
     $ci->db->where('U.id', $user_id);
     $ci->db->where('U.username', $username);
    //$ci->db->get();
    return $ci->db->get()->row();
    //echo $ci->db->last_query();die();
    }
 }


 if (!function_exists('api_get_school_details')) {
    function api_get_school_details($school_id){
     $ci = & get_instance();
     $ci->db->select('S.*');
     $ci->db->from('schools AS S');
     $ci->db->where('S.id', $school_id);
     //$ci->db->get();
     return $ci->db->get()->row();
     //echo $ci->db->last_query();die();
    }
 }

 if (!function_exists('get_school_details')) {
    function get_school_details(){
     $ci = & get_instance();
     $ci->db->select('S.*');
     $ci->db->from('schools AS S');
     //$ci->db->where('S.id', $school_id);
     //$ci->db->get();
     return $ci->db->get()->row();
     //echo $ci->db->last_query();die();
    }
 }

 if (!function_exists('get_addimission_no_by_student_id')) {
    function get_addimission_no_by_student_id($insert_id){
     $ci = & get_instance();
     $ci->db->select('S.roll_no');
     $ci->db->from('schools AS S');
     $ci->db->where('S.id', $insert_id);
     //$ci->db->get();
     return $ci->db->get()->row();
     //echo $ci->db->last_query();die();
    }
 }

 if (!function_exists('authenticate_api_key')) {

    function authenticate_api_key($that)
    {
        $_POST = $that->security->xss_clean($_POST);
        $headerString = '';
        if (!empty($_SERVER['HTTP_X_API_KEY'])) {
            $headerString = $_SERVER['HTTP_X_API_KEY'];
        }

        $api_key = $that->config->item('encryption_key');
        if (empty($headerString)) {
            $message = [
                'status' => FALSE,
                'message' => "API Key missing"
            ];
            return $message;
        } else if ($headerString == $api_key) {
            $message = [
                'status' => TRUE,
                'message' => "API Key Match"
            ];
            return $message;
        } else {
            $message = [
                'status' => FALSE,
                'message' => "Invalid API Key"
            ];
            return $message;
        }
    }
}


/*STRICT DATA ACCESS END*/
