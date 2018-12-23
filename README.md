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


