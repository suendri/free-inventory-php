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

$data=mysql_query("select * from pbbarang");
$op=isset($_GET['op'])?$_GET['op']:null;

if ($op=='getBrgBeli'){
    $kode=$_GET['kode'];
    $dt=mysql_query("select * from pbbarang where kode='$kode'");
    $d=mysql_fetch_array($dt);
    echo $d['nmBrg']."|".$d['satuan']."|".$d['hrgBeli']."|".$d['stock'];
	}
	
elseif ($op=='getBrgJual'){
    $kode=$_GET['kode'];
    $dt=mysql_query("select * from pbbarang where kode='$kode'");
    $d=mysql_fetch_array($dt);
    echo $d['nmBrg']."|".$d['satuan']."|".$d['hrgJual']."|".$d['stock'];
	}

?>