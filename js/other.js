var code;
function createCode(){     //用来生成验证码的函数
    code = '';
    var codeLength = 4;      //验证码长度为4
    /*根据id='code'返回该对象给codeV*/
    var codeV = document.getElementById('code');
    /*设定随机值数组，共有36个数组元素，0-9，A-Z，验证码输入时不区分大小写*/
    var random = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R', 'S','T','U','V','W','X','Y','Z');
    for(var i = 0; i < codeLength; i++){
        /*Math.random()方法随机生成0-1之间的小数，将它与36相乘之后再向下取整
        通过Math.floor()方法，这样就得到了可以遍历随机数组的数值*/ 
         var index = Math.floor(Math.random()*36);
         code += random[index];        //将每次得到的随机字符进行拼接组合成4位
    }
    codeV.value = code;      //通过codeV设置id='code'的value值就是生成的验证码
}
 
function check_signForm(){    //检查注册表单
    var yzm = document.getElementById('testma').value.toUpperCase();  
    var myID=getElementById("userID").value;
    var myname=getElementById("username").value;
    var mypwd=getElementById("userpwd").value;
    var myrepwd=getElementById("repwd").value;
    var mychose=getElementById("chose");
    var index=mychose.selectedIndex;
    if(yzm!=code){
        alert('the identifying code is wrong, please input once again!');
        yzm = ' ';
        createCode(); 
        return false;
    }
    else if(mypwd != myrepwd){     //如果两次密码输入不一致
      alert("The two passwords do not match!");
      createCode();          //更换验证码
      return false;
    }
    else{
        /*
        if(mychose.options[index].value=="teacher") {

        }
        else if(mychose.options[index].value=="student"){

        }*/
        return true;
    }
    
}

function check_loginForm(){    //检查登录表单
    alert("wrong------");
    var yzm = document.getElementById('testma').value.toUpperCase();  
    if(yzm!=code){
        alert('the identifying code is wrong, please input once again!');
        yzm = ' ';
        createCode(); 
        return false;
    }
    else{
        return true;
    }
}