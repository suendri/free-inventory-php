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
$query_rec_show_pms = "SELECT * FROM pbpemasok ORDER BY nama ASC";
$rec_show_pms = mysql_query($query_rec_show_pms, $invconnect) or die(mysql_error());
$row_rec_show_pms = mysql_fetch_assoc($rec_show_pms);
$totalRows_rec_show_pms = mysql_num_rows($rec_show_pms);

  $colname_rec_show_lap_kd = $_SESSION['kd_pemasok'];
  $colname_rec_show_lap_awal = $_SESSION['tgl_awal'];
  $colname_rec_show_lap_akhir = $_SESSION['tgl_akhir'];
  
mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_lap = "SELECT pbnotabeli.noNota as NN, 
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
		WHERE pbnotabeli.kdPemasok = '".$colname_rec_show_lap_kd."' AND pbnotabeli.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotabeli.tgl <= '".$colname_rec_show_lap_akhir."'";
		
$rec_show_lap = mysql_query($query_rec_show_lap, $invconnect) or die(mysql_error());
$row_rec_show_lap = mysql_fetch_assoc($rec_show_lap);
$totalRows_rec_show_lap = mysql_num_rows($rec_show_lap);

/*---------------------------------------------------------------------------------------------
 * Hitung
 *
 *---------------------------------------------------------------------------------------------
 */
$sql = mysql_query("SELECT SUM((pbbarang.hrgBeli * pbnotabeli.jml) - pbnotabeli.potongan) as TA FROM pbnotabeli LEFT JOIN pbbarang ON pbnotabeli.kdBrg=pbbarang.kode WHERE pbnotabeli.kdPemasok = '".$colname_rec_show_lap_kd."' AND pbnotabeli.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotabeli.tgl <= '".$colname_rec_show_lap_akhir."'") ;
$TA = mysql_result($sql, 0, 'TA');

 /*---------------------------------------------------------------------------------------------
 * Judul
 *
 *---------------------------------------------------------------------------------------------
 */

?>
<h2>Cetak Laporan Pembelian</h2>
<?php if ($totalRows_rec_show_lap > 0) { // Show if recordset not empty ?>
<div>Daftar Penjualan Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
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
	$tot = ($row_rec_show_lap['HB']*$row_rec_show_lap['JML'])-$row_rec_show_lap['PTG'];	
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row_rec_show_lap['NN']; ?></td>
        <td><?php echo tanggal_indonesia1($row_rec_show_lap['TGL']); ?></td>
        <td><?php echo $row_rec_show_lap['NP']; ?></td>
        <td><?php echo $row_rec_show_lap['NB']; ?></td>
        <td><?php echo number_format($row_rec_show_lap['HB'], 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap['JML']; ?></td>
        <td><?php echo $row_rec_show_lap['PTG']; ?></td>
        <td><?php echo number_format($tot, 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_lap['KET']; ?></td>
      </tr>
      <?php } while ($row_rec_show_lap = mysql_fetch_assoc($rec_show_lap)); ?>
  </tbody>
  </table><br/>
   <div>
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rec_show_lap == 0) { // Show if recordset empty ?>
  <div class="alert fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Data tidak ditemukan !
          </div>
  <?php } // Show if recordset empty ?>
