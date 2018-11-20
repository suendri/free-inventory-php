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



  
  $colname_rec_show_lap_kd = $_SESSION['kdBrg'];
  $colname_rec_show_lap_awal = $_SESSION['tgl_awal'];
  $colname_rec_show_lap_akhir = $_SESSION['tgl_akhir'];

 /*---------------------------------------------------------------------------------------------
 * Pembelian
 *
 *---------------------------------------------------------------------------------------------
 */

mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_lap1 = "SELECT pbnotabeli.noNota as NN, 
		pbnotabeli.tgl as TGL, 
		pbnotabeli.kdPemasok, 
		pbnotabeli.kdBrg, 
		pbnotabeli.jml as JML, 
		pbnotabeli.potongan as PTG, 
		pbnotabeli.ket as KET, 
		pbbarang.kode, 
		pbbarang.nmBrg as NB, 
		pbbarang.hrgBeli as HB, 
		pbpemasok.kode, 
		pbpemasok.nama as NP
		FROM pbnotabeli LEFT JOIN pbbarang ON pbnotabeli.kdBrg=pbbarang.kode 
		LEFT JOIN pbpemasok ON pbnotabeli.kdPemasok=pbpemasok.kode 
		WHERE pbnotabeli.kdBrg = '".$colname_rec_show_lap_kd."' AND pbnotabeli.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotabeli.tgl <= '".$colname_rec_show_lap_akhir."'";
		
$rec_show_lap1 = mysql_query($query_rec_show_lap1, $invconnect) or die(mysql_error());
$row_rec_show_lap1 = mysql_fetch_assoc($rec_show_lap1);
$totalRows_rec_show_lap1 = mysql_num_rows($rec_show_lap1);
 /*---------------------------------------------------------------------------------------------
 * Penjualan
 *
 *---------------------------------------------------------------------------------------------
 */
mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_lap2 = "SELECT pbnotajual.noNota as NN, 
		pbnotajual.tgl as TGL, 
		pbnotajual.kdpelanggan, 
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
		LEFT JOIN pbpelanggan ON pbnotajual.kdpelanggan=pbpelanggan.kode 
		WHERE pbnotajual.kdBrg = '".$colname_rec_show_lap_kd."' AND pbnotajual.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotajual.tgl <= '".$colname_rec_show_lap_akhir."'";
		
$rec_show_lap2 = mysql_query($query_rec_show_lap2, $invconnect) or die(mysql_error());
$row_rec_show_lap2 = mysql_fetch_assoc($rec_show_lap2);
$totalRows_rec_show_lap2 = mysql_num_rows($rec_show_lap2);

/*---------------------------------------------------------------------------------------------
 * Hitung
 *
 *---------------------------------------------------------------------------------------------
 */
$sql1 = mysql_query("SELECT SUM(pbnotabeli.jml) as TA1 FROM pbnotabeli LEFT JOIN pbbarang ON pbnotabeli.kdBrg=pbbarang.kode WHERE pbnotabeli.kdBrg = '".$colname_rec_show_lap_kd."' AND pbnotabeli.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotabeli.tgl <= '".$colname_rec_show_lap_akhir."'") ;
$TA1 = mysql_result($sql1, 0, 'TA1');

$sql2 = mysql_query("SELECT SUM(pbnotajual.jml) as TA2 FROM pbnotajual LEFT JOIN pbbarang ON pbnotajual.kdBrg=pbbarang.kode WHERE pbnotajual.kdBrg = '".$colname_rec_show_lap_kd."' AND pbnotajual.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotajual.tgl <= '".$colname_rec_show_lap_akhir."'") ;
$TA2 = mysql_result($sql2, 0, 'TA2');

 /*---------------------------------------------------------------------------------------------
 * Judul
 *
 *---------------------------------------------------------------------------------------------
 */

?>
<h2>Cetak Laporan Stok</h2>
<?php if ($totalRows_rec_show_lap1 > 0) { // Show if recordset not empty ?>
<div>Daftar Barang Masuk Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
  <table class="gridtable">
  <thead>
    <tr>
     <th>#</th>
      <th>No Nota</th>
      <th>Tanggal</th>
      <th>Pemasok</th>
      <th>Nama Barang</th>
      <th>HB</th>
      <th>JML</th>
      <th>PTG</th>
      <th>TOT</th>
      <th>KET</th>
    </tr>
   </thead>
   <tbody>
    <?php $no=0; do { $no++; 
	$tot = ($row_rec_show_lap1['HB']*$row_rec_show_lap1['JML'])-$row_rec_show_lap1['PTG'];	
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row_rec_show_lap1['NN']; ?></td>
        <td><?php echo tanggal_indonesia1($row_rec_show_lap1['TGL']); ?></td>
        <td><?php echo $row_rec_show_lap1['NP']; ?></td>
        <td><?php echo $row_rec_show_lap1['NB']; ?></td>
        <td><?php echo number_format($row_rec_show_lap1['HB'], 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap1['JML']; ?></td>
        <td><?php echo $row_rec_show_lap1['PTG']; ?></td>
        <td><?php echo number_format($tot, 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap1['KET']; ?></td>
      </tr>
      <?php } while ($row_rec_show_lap1 = mysql_fetch_assoc($rec_show_lap1)); ?>
  </tbody>
  </table><br>
  <div>
	Jumlah Total Barang Masuk : <b><?php echo number_format($TA1, 0, '', '.'); ?></b>
  </div>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rec_show_lap1 == 0) { // Show if recordset empty ?>
  <div class="alert fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Data Barang Masuk tidak ditemukan !
          </div>
  <?php } // Show if recordset empty ?>
<br/>
<?php if ($totalRows_rec_show_lap2 > 0) { // Show if recordset not empty ?>
<div>Daftar Barang Keluar Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
  <table class="gridtable">
  <thead>
    <tr>
     <th>#</th>
      <th>No Nota</th>
      <th>Tanggal</th>
      <th>Pemasok</th>
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
	$tot = ($row_rec_show_lap2['HJ']*$row_rec_show_lap2['JML'])-$row_rec_show_lap2['PTG'];	
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row_rec_show_lap2['NN']; ?></td>
        <td><?php echo tanggal_indonesia1($row_rec_show_lap2['TGL']); ?></td>
        <td><?php echo $row_rec_show_lap2['NP']; ?></td>
        <td><?php echo $row_rec_show_lap2['NB']; ?></td>
        <td><?php echo number_format($row_rec_show_lap2['HJ'], 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap2['JML']; ?></td>
        <td><?php echo $row_rec_show_lap2['PTG']; ?></td>
        <td><?php echo number_format($tot, 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap2['KET']; ?></td>
      </tr>
      <?php } while ($row_rec_show_lap2 = mysql_fetch_assoc($rec_show_lap2)); ?>
  </tbody>
  </table><br>
  <div>
	Jumlah Total Barang Keluar : <b><?php echo number_format($TA2, 0, '', '.'); ?></b>
  </div>
<?php } // Show if recordset not empty ?>
<?php if ($totalRows_rec_show_lap2 == 0) { // Show if recordset empty ?>
  <div class="alert fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Data Barang Keluar tidak ditemukan !
          </div>
  <?php } // Show if recordset empty ?>


