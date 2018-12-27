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
	public function showStudentScore()
	{
		$sth = $this->container['db']->pdo->prepare("
				SELECT
					students.stu_id,
					students.`name`,
					COUNT(courses.course_name) AS courseNum,
					GROUP_CONCAT(courses.course_name ORDER BY  courses.id ASC) AS courseName,
					GROUP_CONCAT(IFNULL(student_score.score,'-') ORDER BY  courses.id ASC) As courseScore
				FROM
					students 
				INNER JOIN teacher_course ON teacher_course.teacher_work_id = :work_id
				AND students.teacher_work_id = :work_id
				INNER JOIN courses ON courses.id = teacher_course.course_id
				LEFT JOIN student_score ON student_score.stu_id = students.stu_id
				AND student_score.course_id = teacher_course.course_id
				GROUP BY students.stu_id, students.`name`
			");
		$sth->bindParam(':work_id',$_SESSION['id'],PDO::PARAM_INT);
		$sth->execute();
		$table = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($table as $key => $value) {
			$courseArr = explode(',', $value['courseName']);
			$scoreArr = explode(',', $value['courseScore']);
			$table[$key]['courseName'] = $courseArr;
			$table[$key]['courseScore'] = $scoreArr;
		}
		return json_encode($table);

	}

	public function teacherLock()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		if (!isset($postArr['password'])) {
				return $this->json_fail('fail');
		}
		$result = $this->container['db']->has('teachers',[
				"AND"=>[
					"work_id"=>$_SESSION['id'],
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

	public function publishNotice()
	{
		$postArr = $this->container->get('request')->getParsedBody();
		if (!(isset($postArr['title']) && isset($postArr['content']) && isset($postArr['course_id']))) {
			return $this->json_fail('fail');
		}
		Common\CheckCommon::inputCheck($postArr);
		$publisher = $this->container['db']->select('teachers','name',[
				'work_id'=>$_SESSION['id']
			]);
		$result = $this->container['db']->insert('notice',[
				'teacher_work_id' => $_SESSION['id'],
				'publisher'=>$publisher[0],
				'course_id'=>$postArr['course_id'],
				'title'=>$postArr['title'],
				'content'=>$postArr['content'],
				'publish_time'=>time()
			]);
		if ($result->rowCount()) {
			return $this->json_success('publish successfully');
		}
		else{
			return $this->json_fail('publish fail');
		}
	}


}