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


$colname_rec_show_lap = "-1";
if (isset($_GET['kdBrg']) AND isset($_GET['tgl_awal']) AND isset($_GET['tgl_akhir'])) {
  $colname_rec_show_lap_kd = $_GET['kdBrg'];
  $colname_rec_show_lap_awal = $_GET['tgl_awal'];
  $colname_rec_show_lap_akhir = $_GET['tgl_akhir'];
  
  $_SESSION['kdBrg'] = $colname_rec_show_lap_kd;
  $_SESSION['tgl_awal'] = $colname_rec_show_lap_awal;
  $_SESSION['tgl_akhir'] = $colname_rec_show_lap_akhir;
  
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

}
else {
	$colname_rec_show_lap_kd = "";
	$colname_rec_show_lap_awal = "";
	$colname_rec_show_lap_akhir = "";
}

pbtitle('History Stok Barang');
?>

<form class="form-inline well" id="form1" name="form1" method="get" action="">
<input type="hidden" name="modul" value="lap_stock"/>
  <table class="table table-hover">
    <tr>
      <th colspan="2">Barang</th>
    </tr>
    <tr>
      <td style="width:150px;">Kode Barang</td>
      <td><input class="form-control" type="text" name="kdBrg" id="kdBrg" placeholder="Kode Barang" value="<?php echo $colname_rec_show_lap_kd; ?>" required="" /></td>
    </tr>
    <tr>
      <th colspan="2">Periode</th>
    </tr>
    <tr>
      <td>Tanggal </td>
       <td>
	   
		<div style="width:300px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
			<input class="form-control" type="text" name="tgl_awal"  value="<?php echo $colname_rec_show_lap_awal; ?>" placeholder="Mulai Tanggal" readonly>
			<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div> s/d 
		
		<div style="width:300px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
			<input class="form-control" type="text" name="tgl_akhir" value="<?php echo $colname_rec_show_lap_akhir; ?>" placeholder="Sampai Tanggal" readonly>
			<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		</div>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" type="submit" name="button" id="button" value="Buat Laporan" /></td>
    </tr>
  </table>
</form>


<?php if (isset($totalRows_rec_show_lap1) && $totalRows_rec_show_lap1 > 0) { // Show if recordset not empty ?>
<div>:: Daftar Barang Masuk Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
  <table class="table table-bordered">
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
  </table>
  <div class="well well-sm">
	Jumlah Total Barang Masuk : <b><?php echo number_format($TA1, 0, '', '.'); ?></b>
  </div>
<?php } 
if (isset($totalRows_rec_show_lap1) && $totalRows_rec_show_lap1 == 0)
{
	echo "<div class='alert alert-warning'>Data Barang Masuk tidak ditemukan</div>";
}?>

<?php if (isset($totalRows_rec_show_lap2) && $totalRows_rec_show_lap2 > 0) { // Show if recordset not empty ?>
<div>:: Daftar Barang Keluar Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
  <table class="table table-bordered">
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
  </table>
  <div class="well well-sm">
	Jumlah Total Barang Keluar : <b><?php echo number_format($TA2, 0, '', '.'); ?></b>
  </div>
<?php } 
if (isset($totalRows_rec_show_lap2) && $totalRows_rec_show_lap2 == 0)
{
	echo "<div class='alert alert-info'>Data Barang Keluar tidak ditemukan</div>";
}?>

<div class="well">
  <a class="btn btn-large btn-block btn-success" href="print.php?print=print_stock" target="_blank">Print</a>
</div>

