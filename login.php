<?php 

require_once('Connections/invconnect.php'); 

/*
 * Sistem Inventory Donasi.
 *
 * Tidak dibenarkan menyebarkan, memperbanyak, menggandakan Program ini
 * untuk kepentingan pribadi, kelompok atau instansi yang dijadikan 
 * program komersial maupun gratisan kepada pihak ketiga. Namun dibenarkan 
 * merobah program, menambah atau mengurangi sebahagian atau seluruh program 
 * hanya bagi Donator kami, tanpa menghilangkan atribut lisensi yang ada
 * pada tiap-tiap file program.
 
 * Website : www.gosoftware.web.id
 * Blog    : http://phpbego.wordpress.com
 * Hotline : 0623 456 2221
 * SMS     : 0852 6361 6901 
 * Email   : cs@gosoftware.web.id
 * Facebook: https://www.facebook.com/gosoftwarego
 * Twitter : @phpbego
 *
*/


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['uname'])) {
  $loginUsername=$_POST['uname'];
  $password=$_POST['upass'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_invconnect, $invconnect);
  
  $LoginRS__query=sprintf("SELECT id, uname, upass, nama, level FROM pbuser WHERE uname=%s AND upass=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $invconnect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
	 
	 //SESSION USER
	 $Uid = mysql_result($LoginRS, 0, 'id');
	 $Nama = mysql_result($LoginRS, 0, 'nama');
	 $Level = mysql_result($LoginRS, 0, 'level');
    
    //declare two session variables and assign them
	$_SESSION['Uid'] = $Uid;
	$_SESSION['uname'] = $loginUsername;
	$_SESSION['Nama'] = $Nama;  
	$_SESSION['Level'] = $Level; 
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Inventory">
    <meta name="author" content="phpbego">
	<link rel="shortcut icon" href="Asset/images/favicon.png">
    <link href="Asset/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="Asset/css/style.css" rel="stylesheet" type="text/css">
    <style type="text/css">
		body {
			margin-top: 50px;
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f1f1f1;
		}
	    p {
			text-align:center;
	    }

		.form-signin {
			max-width: 300px;
			padding: 19px 29px 29px;
			margin: 0 auto 20px;
			background-color: #fff;
			border: 1px solid #CCC;
			border-radius: 4px;
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
			margin-bottom: 10px;
		}
		.form-signin input[type="text"],
		.form-signin input[type="password"] {
			height: auto;
			margin-bottom: 15px;
			padding: 7px 9px;
		}
    </style>
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="POST" action="<?php echo $loginFormAction; ?>">
        <h3 class="form-signin-heading"><span class="glyphicon glyphicon-lock"></span> Login Sistem</h3>
		    <input type="hidden" name="direct" value="prevent" />
        <input type="text" name="uname" id="uname" class="form-control" autocomplete="off" placeholder="UserID" required="" >
        <input type="password" name="upass" class="form-control" placeholder="Password" required="">
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
	<p>Copyright &copy; 2013 - <?php echo date("Y"); ?> <a href="http://phpbego.wordpress.com" target="_blank">PHPBeGO Foundation</a>. Sistem Inventory v<?php echo VERSION; ?> Donasi.</p>
    </div>
  </body>
</html>
