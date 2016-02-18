<?php
if($_POST){
include_once('../wp-config.php');


$email = $_POST['email'];
$course_id = $_POST['course_id'];
$user = get_user_by( 'email', $email );
$user_id = $user->ID;


//echo print_r($user, true);
$enrol = ld_update_course_access($user_id, $course_id, $remove = false);
//echo print_r($enrol, true);
//header("Location: ".$_POST['link_url']);
//die();
}
//else {
//header("Location: https://app.thesmsfacademy.com.au");
//die();
//}


?>