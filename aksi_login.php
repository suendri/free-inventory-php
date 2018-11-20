<?php
/*-------------------------------------------------------------------------
    Sistem Inventory Donasi.

    Program ini digunakan untuk mencatat semua transaksi inventory termasuk pembelian 
	dan penjualan barang. Tidak dibenarkan mencopy dan menyebarluaskan program ini 
	tanpa seizin phpbego. Jika anda menghargai program saya, silakan Download versi free 
	developer dari program ini dan kirimkan sedikit donasi anda untuk kelangsungan 
	blog saya di http://phpbego.wordpress.com. Namun jika tidak, anda sudah saya maafkan 
	Dunia dan Akhirat :).

    Silakan kirimkan kritik dan saran anda ke :

    phpbego@yahoo.co.id
    phpbego@gmail.com
    SMS : 085263616901

    Jika anda berniat membuat sebuah sistem seperti ini, 
	dengan modul tertentu dari anda, baik untuk komersial atau sejenisnya, 
	silakan hubungi saya di alamat email tersebut diatas.
-----------------------------------------------------------------------
*/
 
// *** Validate request to login to this site.
require_once('Connections/invconnect.php');

/*---------------------------------------------------------------------------------------------
 * Proses Login
 * 
 *---------------------------------------------------------------------------------------------
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

if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['uname']) AND isset($_POST['upass'])) {
  $loginUsername= $_POST['uname'];
  $password= mysql_real_escape_string($_POST['upass']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true ;
  mysql_select_db($database_invconnect, $invconnect);

  $LoginRS__query=sprintf("SELECT id, uname, upass, nama, level FROM pbuser WHERE uname=%s AND upass='$password' AND aktif='Y'",
    GetSQLValueString($loginUsername, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $invconnect);
  $loginFoundUser = mysql_num_rows($LoginRS);
  
  if ($loginFoundUser) {
     $loginStrGroup = "";
	 
	 // Level
	 $Uid = mysql_result($LoginRS, 0, 'id');
	 $Nama = mysql_result($LoginRS, 0, 'nama');
	 $Level = mysql_result($LoginRS, 0, 'level');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    //$_SESSION['MM_Username'] = $loginUsername;
    //$_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['Uid'] = $Uid;
	$_SESSION['uname'] = $loginUsername;
	$_SESSION['Nama'] = $Nama;  
	$_SESSION['Level'] = $Level; 	

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

?>