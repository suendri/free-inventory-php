<script type="text/javascript">
$(document).ready(function() {
	$("#noNota").focus();
	});
</script>

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

$colname_rec_show_jual = $_SESSION['noNota'];
mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_jual = sprintf("SELECT pbnotajual.noNota as NN, 
		pbnotajual.tgl as TGL, 
		pbnotajual.kdPelanggan, 
		pbnotajual.kdBrg, 
		pbnotajual.jml as JML, 
		pbnotajual.potongan as PTG, 
		pbnotajual.ket as KET, 
		pbbarang.kode, 
		pbbarang.nmBrg as NB, 
		pbbarang.hrgjual as HJ, 
		pbpelanggan.kode, 
		pbpelanggan.nama as NP
		FROM pbnotajual LEFT JOIN pbbarang ON pbnotajual.kdBrg=pbbarang.kode 
		LEFT JOIN pbpelanggan ON pbnotajual.kdPelanggan=pbpelanggan.kode 
		WHERE pbnotajual.noNota = %s", GetSQLValueString($colname_rec_show_jual, "text"));
$rec_show_jual = mysql_query($query_rec_show_jual, $invconnect) or die(mysql_error());
$row_rec_show_jual = mysql_fetch_assoc($rec_show_jual);
$totalRows_rec_show_jual = mysql_num_rows($rec_show_jual);

/*---------------------------------------------------------------------------------------------
 * Hitung
 *
 *---------------------------------------------------------------------------------------------
 */
$sql = mysql_query("SELECT SUM((pbbarang.hrgJual * pbnotajual.jml) - pbnotajual.potongan) as TA, 
					SUM(pbnotajual.jml) as JMLB, SUM(pbnotajual.potongan) as PTGB 
					FROM pbnotajual LEFT JOIN pbbarang ON pbnotajual.kdBrg=pbbarang.kode 
					WHERE pbnotajual.noNota = '".$colname_rec_show_jual."' ") ;
$TA = mysql_result($sql, 0, 'TA');
$JMLB = mysql_result($sql, 0, 'JMLB');
$PTGB = mysql_result($sql, 0, 'PTGB');

 /*---------------------------------------------------------------------------------------------
 * Judul
 *
 *---------------------------------------------------------------------------------------------
 */

?>
<h2> Cetak Daftar Penjualan</h2>
<?php if ($totalRows_rec_show_jual > 0) { // Show if recordset not empty ?>
  <table class="gridtable">
  <thead>
    <tr>
      <th>#</th>
      <th>No Nota</th>
      <th>Tanggal</th>
      <th>Pelanggan</th>
      <th>Nama Barang</th>
      <th>HJ</th>
      <th>JML</th>
      <th>PTG</th>
      <th>TOT</th>
      <th>KET</th>
    </tr>
   </thead>
   <tbody>
    <?php $no=0; do { $no++;
	$tot = ($row_rec_show_jual['HJ']*$row_rec_show_jual['JML'])-$row_rec_show_jual['PTG'];	
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row_rec_show_jual['NN']; ?></td>
        <td><?php echo tanggal_indonesia1($row_rec_show_jual['TGL']); ?></td>
        <td><?php echo $row_rec_show_jual['NP']; ?></td>
        <td><?php echo $row_rec_show_jual['NB']; ?></td>
        <td><?php echo number_format($row_rec_show_jual['HJ'], 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_jual['JML']; ?></td>
        <td><?php echo $row_rec_show_jual['PTG']; ?></td>
        <td><?php echo number_format($tot, 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_jual['KET']; ?></td>
      </tr>
      <?php } while ($row_rec_show_jual = mysql_fetch_assoc($rec_show_jual)); ?>
  </tbody>
  </table><br/>
  <div class="well">
  Jumlah Total Barang : <b><?php echo number_format($JMLB, 0, '', '.'); ?></b>, 
  Jumlah Total Potongan : <b><?php echo number_format($PTGB, 0, '', '.'); ?></b>, 
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>

  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rec_show_jual == 0) { // Show if recordset empty ?>
    <div class="alert fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Data tidak ditemukan, silakan masukkan Nomor Nota dan klik Cari atau klik Tambah baru untuk menambahkan Nomor Nota Baru.
          </div>
    <?php } // Show if recordset empty ?>
    <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
//-->
    </script>
</body>
</html>
<?php
mysql_free_result($rec_show_jual);
?>
