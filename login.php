<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
 

include("bilgi.php");
session_start();
ob_start(); //header fonksiyonunu çalıştırmak için kullandık
 
if(($_POST["user"]==$user) && ($_POST["pass"]==$pass)){
 
	$_SESSION["login"] = "true"; //login ismi verdiğimiz session kaydı
	$_SESSION["user"] = $user;
	$_SESSION["pass"] = $pass;
	 
	header("Location:alisveris.php");
 
}
else{
 
echo "Kullanıcı adı veya Şifre Yanlış.";
 
header("Refresh:0.7; url=index.php");
 
}
 
ob_end_flush();
 
?>
</body>
</html>