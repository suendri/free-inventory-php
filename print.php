<?php
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

if (!isset($_SESSION)) {
  session_start();
}

define('ENVIRONMENT', 'production');

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}
require_once('Connections/invconnect.php'); 
require "sis_config.php";

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Laporan</title>
<style type="text/css">
body { font-size : 12pt; padding: 0 20px 0 20px;}
table.gridtable {font-size:12pt;border-width: 1px;border-color: #000000;border-collapse: collapse;}
table.gridtable th {background-color: #000000;border-width: 1px;border-style: solid;border-color: #000000;padding: 6px; color:#FFFFFF;}
table.gridtable td {border-width: 1px;padding: 4px;border-style: solid;border-color: #000000;}

</style>
</head>

<body onload="javascript:window.print()">
<?php 

if(isset($_GET['print'])){ 
	if(file_exists($_GET['print'].".php")) {	
		require_once($_GET['print'].".php"); 
	} else { 
		echo "<h3 align=center><br>Error !!</h3><b>Maaf file <u>$_GET[print].php</u> tidak temukan !!</b>"; 
	} 
} else {
	echo " Maaf ! ada kesalahan pada proses cetak";
}
?>
</body>
</html>
