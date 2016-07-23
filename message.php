<?php
session_start();
?>
<html>
<head><title>Create New Post</title>
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
<form method="GET" action="message.php">
<fieldset>
<legend><b>Enter Your Post Here:</b></legend>
<TEXTAREA NAME="message" 
   ROWS="4" COLS="50">
</TEXTAREA>
<input type="submit" value="Post" name="post"/>
</fieldset>
</form>

<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

if(isset($_GET['follows'])){
$_SESSION['temp'] = $_GET['follows'];
}
//get user from session and insert posts into posts table

if(isset($_GET['post'])){
$message = $_GET['message'];
$user = $_SESSION["userName"];
$follows = $_SESSION['temp'];
unset($_SESSION['temp']);
	try{
		$dbname = "C:/wamp/www/project4/mydb.sqlite";
		$dbh = new PDO("sqlite:$dbname");
		$dbh->beginTransaction();
		$stmt=$dbh->prepare('select count(id) as id from posts');
		$stmt->execute();
		$row=$stmt->fetch();
		$id = $row[0]+1;
		if($follows){
		$dbh->exec("insert into posts values('$id','$user','$follows',datetime('now'),'$message')")
		or die(print_r("Error here!", true));
		$dbh->commit();
		}else{
		$dbh->exec("insert into posts values('$id','$user','$id',datetime('now'),'$message')")
		or die(print_r("Error!", true));
		$dbh->commit();
		}
		header("Location:board.php");
		exit;
	}catch(PDOException $e){
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}  
?> 
</body>
</html>
