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

require ("config.php");

if ((isset($_POST["update_akun"])) && ($_POST["update_akun"] == "form3")) {

	if ($_POST['upass'] != "") {
		$passEnkrip = $_POST['upass'];
		$str = "upass='$passEnkrip',";
	}
	else $str = "";
	
	$updateSQL = sprintf("UPDATE pbuser SET $str nama=%s, email=%s WHERE id=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = mysql_query($updateSQL, $invconnect) or die(mysql_error());
  
  header('location: page.php?modul=edit_akun');
}