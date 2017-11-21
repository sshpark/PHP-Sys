//四个分开的文件 index.html  signup.html  signup.php  signin.php
//index.html 首页
<!DOCTYPE html>
<html>
<head>

</head>
<body>

<form action="signin.php" method="POST">
	<h1>登陆</h1>
	邮箱:<input type="text" name="email"><br>
	密码:<input type="password" name="password"><br>
	<input type="submit" value="登陆">
</form>
<a href="signup.html">注册</a>


</body>
</html>



//signup.html  注册
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
	  
	  
	  <form action="signup.php" method="post">
		  <h1>注册</h1>
		  邮箱:<input type="email" name="email"><br>
		  密码:<input type="password" name="password"><br>
		  <input type="submit" value="注册">
		  
		  </form>
	  <a href="index.html">登陆</a>

  </body>
</html>



//signin.php  验证登陆
<?php
$address = "localhost";
$user = "root";
$password = "root1234";
$db_name = "phpgroup";
$conn=mysqli_connect($address,$user,$password,$db_name);
if(!$conn){
echo "db connect failed";
}
$email=$_POST["email"];
$password=$_POST["password"];
if ( $email && $password ) {
	$sql = "SELECT * FROM users WHERE user_email = '".$email."' and user_pass='".$password."'";
	 $result = mysqli_query($conn,$sql);
	$row=mysqli_num_rows($result);
	if ($row) {
		echo "登陆成功";
		echo "<script>setTimeout(function(){window.location.href='//ncu.nediiii.com';},1000);</script>";
	} else {
		echo "登录失败";
		echo "<script>setTimeout(function(){window.location.href='index.html';},1000);</script>";
	}

}
?>




//signup.php  验证注册
<?php

$address="localhost";
$user="root";
$password="root1234";
$db_name="phpgroup";
$conn=mysqli_connect($address,$user,$password,$db_name);
if(!$conn){
	echo "db connect failed";
}
$email=$_POST["email"];
$password=$_POST["password"];

if ( $email && $password ) {
	$sql = "SELECT * FROM users WHERE user_email = '".$email."'";
	 $result = mysqli_query($conn,$sql);
	$row=mysqli_num_rows($result);
	if ($row) {
		echo "注册失败,此邮箱已被注册";
		echo "<script>setTimeout(function(){window.location.href='signup.html';},2000);</script>";
	} else {
		$sql="INSERT INTO USERS (user_email,user_pass) VALUES ('".$email."','".$password."')";
		echo "<br><a href="."index.html".">去登陆</a>";
		echo "<br/>";
		if ($conn->query($sql) == TRUE) {
    		echo "注册成功";
		} 
		else {
    		echo "注册失败,请重试";
			echo "<script>setTimeout(function(){window.location.href='signup.html';},1000);</script>";
		}
	}

}






