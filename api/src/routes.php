<?php
$app->get('/hello', \Controllers\HelloController::class.':hello');

$app->get('/captcha', \Common\ImageCommon::class.':create_image');
$app->post('/is_login', \Controllers\LoginController::class.':is_login');
$app->post('/studentLogin', \Controllers\LoginController::class.':studentLogin');
$app->post('/teacherLogin', \Controllers\LoginController::class.':teacherLogin');
$app->post('/studentRegist', \Controllers\RegistController::class. ':studentRegist');
$app->post('/teacherRegist', \Controllers\RegistController::class. ':teacherRegist');
$app->get('/displayCourse', \Controllers\TeacherController::class. ':displayCourse');
$app->post('/addCourse', \Controllers\TeacherController::class. ':addCourse');
$app->get('/displayStudentCourse', \Controllers\StudentController::class. ':displayStudentCourse');
$app->post('/updateScore', \Controllers\StudentController::class. ':updateScore');
$app->get('/showTeacher',\Controllers\RegistController::class. ':showTeacher');
$app->get('/teacherInfor',\Controllers\TeacherController::class. ':teacherInfor');
$app->get('/unselected',\Controllers\TeacherController::class. ':unselected');
$app->get('/showStudentScore',\Controllers\TeacherController::class. ':showStudentScore');
$app->get('/studentInfo', \Controllers\StudentController::class. ':studentInfo');
$app->get('/studentScore', \Controllers\StudentController::class. ':studentScore');
$app->post('/teacherLock',\Controllers\TeacherController::class. ':teacherLock');
$app->post('/studentLock', \Controllers\StudentController::class. ':studentLock');

