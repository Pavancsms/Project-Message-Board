<?php
session_start();
?>
<html>
<head><title>Message Board</title>
<style type="text/css">
    html {
    background-color:#888888;
    }	
	fieldset {
	background-color:#505050;
	color:white;
	}
	a {
	color :#F00000 ;
	}
</style>
</head>
<body>
<form method="GET" action="login.php">
	<fieldset>
		<legend><b>Login:</b></legend>
		<label><b>User Name:</b>
		<input type="text" name="userName"/>
        </label>
		<label>
		<b>Password:</b>
		<input type="password" name="password"/>
        </label>
		<br/>
		<br/>
		<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" value="Login" name="login"/>&nbsp;&nbsp;&nbsp;
		<input type="submit" value="Register" name="register"/>
		</label>
	</fieldset>
</form>
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_GET['register'])){
header("Location:register.php");
exit;
}
//check the credentials
if(isset($_GET['login'])){
$userName = $_GET['userName'];
$password = md5($_GET['password']);
	try{
		$dbname = "C:/wamp/www/project4/mydb.sqlite";
		$dbh = new PDO("sqlite:$dbname");
		$stmt = $dbh->prepare("select username,password from users where username ='$userName' and password ='$password'");
		$stmt->execute();
		$row=$stmt->fetch();
		
	if($row){
		$_SESSION["userName"]=$userName;
		$_SESSION["password"]=$password;
		header("Location:board.php");
		exit;
	}else{
		echo "Invalid UserName/Password, Try Again";
	}
	}catch(PDOException $e){
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}
?> 
</body>
</html>
