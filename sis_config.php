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

require_once('Connections/invconnect.php');

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


/*---------------------------------------------------------------------------------------------
 * Fungsi Judul
 *
 *---------------------------------------------------------------------------------------------
 */
function pbtitle($title) {
echo "<div class='page-header'>
      <h2>".$title."</h2>
    </div>";
}

/*---------------------------------------------------------------------------------------------
 * Fungsi AlertYes
 *
 *---------------------------------------------------------------------------------------------
 */
function alertYes($title) {
	echo "<div class='alert alert-success'>".$title."</div>";
}

/*---------------------------------------------------------------------------------------------
 * Fungsi AlertYes
 *
 *---------------------------------------------------------------------------------------------
 */
function alertNo($title) {
	echo "<div class='alert alert-danger'>".$title."</div>";
}
/*---------------------------------------------------------------------------------------------
 * Format tanggal Indonesia
 *
 *---------------------------------------------------------------------------------------------
 */
function  tanggal_indonesia1($tgl){
	$tanggal  =  substr($tgl,8,2);
	$bulan  =  substr($tgl,5,2);
	$tahun  =  substr($tgl,0,4);
return  $tanggal.'-'.$bulan.'-'.$tahun;
}

function  tanggal_indonesia2($tgl){
	$tanggal  =  substr($tgl,8,2);
	$bulan  =  getBulan(substr($tgl,5,2));
	$tahun  =  substr($tgl,0,4);
return  $tanggal.''.$bulan.''.$tahun;
}
 
function  getBulan($bln){
	switch  ($bln){
		case  1:
		return  "Januari";
		break;
		case  2:
		return  "Februari";
		break;
		case  3:
		return  "Maret";
		break;
		case  4:
		return  "Maret";
		break;
		case  5:
		return  "Mei";
		break;
		case  6:
		return  "Juni";
		break;
		case  7:
		return  "Juli";
		break;
		case  8:
		return  "Agustus";
		break;
		case  9:
		return  "September";
		break;
		case  10:
		return  "Oktober";
		break;
		case  11:
		return  "November";
		break;
		case  12:
		return  "Desember";
		break;
	}
}

?>