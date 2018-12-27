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

	public function studentInfo()
	{
		$info = $this->container['db']->select('students', 'name',[
				'stu_id'=>$_SESSION['id']
			]);
		return json_encode($info[0]);
	}

	public function studentScore()
	{
		$sth = $this->container['db']->pdo->prepare("
				SELECT
					courses.course_name,
					IFNULL(student_score.score,'-') AS score
				FROM
					students
				INNER JOIN teacher_course ON students.stu_id = :stu_id
				AND teacher_course.teacher_work_id = students.teacher_work_id
				INNER JOIN courses ON courses.id = teacher_course.course_id
				LEFT JOIN student_score ON student_score.course_id = courses.id
				AND student_score.stu_id = :stu_id
				ORDER BY courses.id ASC
			");
		$sth->bindParam(':stu_id',$_SESSION['id'],PDO::PARAM_INT);
		$sth->execute();
		$score = $sth->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($score);
	}

	public function studentLock()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		if (!isset($postArr['password'])) {
				return $this->json_fail('fail');
		}
		$result = $this->container['db']->has('students',[
				"AND"=>[
					"stu_id"=>$_SESSION['id'],
					"password"=>md5($postArr['password'])
				]
			]);
		if ($result) {
			return $this->json_success('password is correct');
			
		}
		else{
			return $this->json_fail('password is wrong');
		}
	}
}
