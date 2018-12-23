<?php
namespace Controllers;
use Common;
use \PDO;

/**
* 
*/
class TeacherController extends BaseController
{
	
	public function displayCourse()
	{
		$sth = $this->container['db']->pdo->prepare("
			SELECT
				id,
				course_name
			FROM
				courses
			WHERE
				id IN (
					SELECT
						course_id
					FROM
						teacher_course
					WHERE
						teacher_work_id = :work_id
					AND is_use = 1
				)
		");
		$sth->bindParam(':work_id',$_SESSION['id'],PDO::PARAM_INT);
		$sth->execute();
		$course = $sth->fetchAll(PDO::FETCH_ASSOC);
		var_dump(json_encode($course));
		return json_encode($course);
	}

	public function unselected()
	{
		$sth = $this->container['db']->pdo->prepare("
			SELECT
				id,
				course_name
			FROM
				courses
			WHERE
				id NOT IN (
					SELECT
						course_id
					FROM
						teacher_course
					WHERE
						teacher_work_id = :work_id
					AND is_use = 1
				)
		");
		$sth->bindParam(':work_id',$_SESSION['id'],PDO::PARAM_INT);
		$sth->execute();
		$course = $sth->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($course);
	}
	public function addCourse()
	{
		$_SESSION['id'] = "1234";
		$post = $this->container->get('request')->getParsedBody();
		if(!isset($post['course_id'])){
			return $this->json_fail('fail');
		}
		$course_id = $post['course_id'];
		foreach ($course_id as $value) {
			$result = $this->container['db']->insert('teacher_course',[
				'teacher_work_id'=>$_SESSION['id'],
				'course_id'=>$value,
				'is_use'=>1
			]);
			if ($result->rowCount() == 0) {
				return $this->json_fail('add course fail');
			}
			else{
				return $this->json_success('add course success');
			}
		}
	}
	public function teacherInfor()
	{
		$sth = $this->container['db']->pdo->prepare('
				SELECT
					teachers.`name` AS TeaName,
					COUNT(students.id) AS StuNum
				FROM
					teachers
				INNER JOIN students ON teachers.work_id = :work_id
				AND students.teacher_work_id = teachers.work_id
				GROUP BY teachers.`name`
			');
		$sth->bindParam(':work_id',$_SESSION['id'],PDO::PARAM_INT);
		$sth->execute();
		$info = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
		$info['status'] = "success";
		return json_encode($info);

	}
	/*public function showStudentScore()
	{
		$sth = $this->container['db']->pdo->prepare('
				
			')
	}*/

}