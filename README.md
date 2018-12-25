## 软件安全大作业后台api

### 0X00 登录注册界面验证码
#### url api/captcha

### 0x01 判断是否已登录
#### method post
#### url api/is_login

#### get
* filed: id
	+ 工号/学号
* filed: password
	+ 密码
* filed: captcha
	+ 验证码

#### return
```
{
	"status":"fail",
	"message":"no login"
}
{
	"status":"fail",
	"message":"captcha error"
}
{
	"status":"success",
	"message":"have logged in"
}

```

### 0x01 老师登录
#### method post
#### url api/teacherLogin

#### get
* captcha
	+ 验证码
* id
	+ 工号
*  passward
	+ 密码
#### return

### 0x02 学生登录
#### method post
#### url api/studentLogin

#### get
* captcha
	+ 验证码
* id
	+ 学号
* password
	+ 密码

### 0x03 学生注册
#### method post
#### url api/studentRegist

#### get
* id
	+ 学号
* name
	+ 姓名
* password
	+ 密码
* repassword
	+ 确认密码
* captcha
	+ 验证码
* teacher_id
	+ 
* teacher_work_id
	+ 工号

### 0x04 老师注册
#### method post
#### url api/teacherRegist

#### get
* id
	+ 学号
* name
	+ 姓名
* password
	+ 密码
* repassword
	+ 确认密码


### 0x04老师端显示可选课程
#### method get
#### url api/displayCourse

#### return
* id
	+ 课程在数据库里唯一标识
* course_name
	+ 课程名
 
 
```
[{
	"id": "1",
	"course_name": "课程1"
}, {
	"id": "2",
	"course_name": "课程2"
}]
```

### 0x05老师端添加课程
#### method post
#### url api/addCourse

#### get
* course_id
	+ 要添加的课程在数据库中的唯一标识（数组）


### 0x06老师端显示学生成绩


### 0x07学生端显示自己的课程
#### method get
#### url api/displayStudentCourse

#### return
* id
	+ 课程id
* course_name
	+ 课程名

### 0x08 学生端考试后更新成绩
#### method post
#### url api/updateScore

### get
* status
	+ 0|没考过 1|已经考过
* course_id
	+ 课程id
* score
	+ 分数

### 0x09 注册显示老师

#### method get
#### url api/showTeacher

### return 
* id
* work_id
	+ 工号
* name
	+ 姓名

### 0x0A 老师端个人中心信息

#### method get
#### url api/teacherInfor

### return
* TeaName
	+ 名字
* StuNum
	+ 学生人数

### 0x0B 老师端未选课程
#### method get

#### url api/unselected

### return
* id
* course_name
<<<<<<< HEAD

### 0X0C 老师端显示学生成绩

#### method get
#### url api/showStudentScore

### return
* stu_id
	+ 学号
* name
	+ 姓名
* courseNum
	+ 课程数
* courses
	+ 课程名（数组）
* score
	+ 课程分数（数组）

```
[{
	"stu_id": "201608060127",
	"name": "顾文洁",
	"courseNum": "2",
	"courses": ["课程1", "课程2"],
	"score": ["-", "95"]
}, {
	"stu_id": "201608060128",
	"name": "guwenjie",
	"courseNum": "2",
	"courses": ["课程1", "课程2"],
	"score": ["-", "-"]
}]
```

### 0x0D学生端显示已考科目的成绩

#### method get
#### url api/studentScore

#### return
* course_name
	+ 课程名
* score
	+ 分数

```
[{
	"course_name": "课程1",
	"score": "90"
}, {
	"course_name": "课程2",
	"score": "95"
}]
```
### 0x0E 学生端学生信息

#### method get
#### url api/studentInfo

#### return
* name
