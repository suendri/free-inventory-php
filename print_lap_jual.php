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

mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_plg = "SELECT * FROM pbpelanggan ORDER BY nama ASC";
$rec_show_plg = mysql_query($query_rec_show_plg, $invconnect) or die(mysql_error());
$row_rec_show_plg = mysql_fetch_assoc($rec_show_plg);
$totalRows_rec_show_plg = mysql_num_rows($rec_show_plg);

  $colname_rec_show_lap_kd = $_SESSION['kd_pelanggan'];
  $colname_rec_show_lap_awal = $_SESSION['tgl_awal'];
  $colname_rec_show_lap_akhir = $_SESSION['tgl_akhir'];

mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_lap = "SELECT pbnotajual.noNota as NN, 
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
		WHERE pbnotajual.kdpelanggan = '".$colname_rec_show_lap_kd."' AND pbnotajual.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotajual.tgl <= '".$colname_rec_show_lap_akhir."'";
		
$rec_show_lap = mysql_query($query_rec_show_lap, $invconnect) or die(mysql_error());
$row_rec_show_lap = mysql_fetch_assoc($rec_show_lap);
$totalRows_rec_show_lap = mysql_num_rows($rec_show_lap);

/*---------------------------------------------------------------------------------------------
 * Hitung
 *
 *---------------------------------------------------------------------------------------------
 */
$sql = mysql_query("SELECT SUM((pbbarang.hrgJual * pbnotajual.jml) - pbnotajual.potongan) as TA FROM pbnotajual LEFT JOIN pbbarang ON pbnotajual.kdBrg=pbbarang.kode WHERE pbnotajual.kdpelanggan = '".$colname_rec_show_lap_kd."' AND pbnotajual.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotajual.tgl <= '".$colname_rec_show_lap_akhir."'") ;
$TA = mysql_result($sql, 0, 'TA');

 /*---------------------------------------------------------------------------------------------
 * Judul
 *
 *---------------------------------------------------------------------------------------------
 */

?>
<h2>Cetak Laporan Penjualan</h2>
<?php if ($totalRows_rec_show_lap > 0) { // Show if recordset not empty ?>
<div>Daftar Penjualan Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
  <table class="gridtable">
  <thead>
    <tr>
     <th>#</th>
      <th>No Nota</th>
      <th>Tanggal</th>
      <th>Pelanggan</th>
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
	$tot = ($row_rec_show_lap['HJ']*$row_rec_show_lap['JML'])-$row_rec_show_lap['PTG'];	
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row_rec_show_lap['NN']; ?></td>
        <td><?php echo tanggal_indonesia1($row_rec_show_lap['TGL']); ?></td>
        <td><?php echo $row_rec_show_lap['NP']; ?></td>
        <td><?php echo $row_rec_show_lap['NB']; ?></td>
        <td><?php echo number_format($row_rec_show_lap['HJ'], 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap['JML']; ?></td>
        <td><?php echo $row_rec_show_lap['PTG']; ?></td>
        <td><?php echo number_format($tot, 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap['KET']; ?></td>
      </tr>
      <?php } while ($row_rec_show_lap = mysql_fetch_assoc($rec_show_lap)); ?>
  </tbody>
  </table><br>
   <div class="well">
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rec_show_lap == 0) { // Show if recordset empty ?>
  <div class="alert fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Data tidak ditemukan !
          </div>
  <?php } // Show if recordset empty ?>