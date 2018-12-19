<?php
namespace Controllers;
use Common;
use \PDO;

/**
* 
*/
class StudentController extends BaseController
{
	
	public function displayStudentCourse()
	{
		$_SESSION['id'] = "201608060127";
		$sth = $this->container['db']->pdo->prepare("
			SELECT
				courses.id,
				courses.course_name
			FROM
				teacher_course
			INNER JOIN students ON students.teacher_work_id = teacher_course.teacher_work_id
			AND students.stu_id = :stu_id
			AND teacher_course.is_use = 1
			INNER JOIN courses ON teacher_course.course_id = courses.id

			");
		$sth->bindParam(':stu_id',$_SESSION['id'],PDO::PARAM_INT);
		$sth->execute();
		$course = $sth->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($course);
	}

	public function updateScore()
	{
		$_SESSION['id'] = "201608060127";
		$postArr = $this->container->get('request')->getParsedBody();
		if (!(isset($postArr['status']) && isset($postArr['course_id']) && isset($postArr['score']))) {
			return $this->json_fail('fail');
		}
		if ($postArr['status'] == 0) {
			$result = $this->container['db']->insert('student_score',[
					'stu_id'=>$_SESSION['id'],
					'course_id'=>$postArr['course_id'],
					'score'=>$postArr['score']
				]);
			if ($result->rowCount() == 0) {
				return $this->json_fail('update score fail');
			}
			else{
				return $this->json_success('update score success');
			}
		}
		else{
			$result = $this->container['db']->update('student_score',[
					'score'=>$postArr['score']
				],[
					'stu_id'=>$_SESSION['id'],
					'course_id'=>$postArr['course_id']
				]);
			if ($result->rowCount() == 0) {
				return $this->json_fail('update score fail');
			}
			else{
				return $this->json_success('update score success');
			}
		}

	}
}
