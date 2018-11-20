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
require_once('Connections/invconnect.php');

if (isset($_POST['kdBrg'])) {
$sql = mysql_query("SELECT kode FROM pbbarang WHERE kode = '$_POST[kdBrg]'");
$ketemu = mysql_num_rows($sql);
echo $ketemu;
}

elseif (isset($_POST['kdPms'])) {
$sql = mysql_query("SELECT kode FROM pbpemasok WHERE kode = '$_POST[kdPms]'");
$ketemu = mysql_num_rows($sql);
echo $ketemu;
}

elseif (isset($_POST['kdPlg'])) {
$sql = mysql_query("SELECT kode FROM pbpelanggan WHERE kode = '$_POST[kdPlg]'");
$ketemu = mysql_num_rows($sql);
echo $ketemu;
}


?>