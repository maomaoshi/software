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