<script type="text/javascript">
$(document).ready(function() {
	$("#noNota").focus();
	});
</script>

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


$colname_rec_show_jual = "-1";
if (isset($_GET['noNota'])) {
  $colname_rec_show_jual = $_GET['noNota'];
  $_SESSION['noNota'] = $colname_rec_show_jual;
}
else $colname_rec_show_jual = "";
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
$sqlt = mysql_query("SELECT SUM((pbbarang.hrgJual * pbnotajual.jml) - pbnotajual.potongan) as TA, 
					SUM(pbnotajual.jml) as JMLB, SUM(pbnotajual.potongan) as PTGB 
					FROM pbnotajual LEFT JOIN pbbarang ON pbnotajual.kdBrg=pbbarang.kode 
					WHERE pbnotajual.noNota = '".$colname_rec_show_jual."' ") or die (mysql_error());
$TA = mysql_result($sqlt, 0, 'TA');
$JMLB = mysql_result($sqlt, 0, 'JMLB');
$PTGB = mysql_result($sqlt, 0, 'PTGB');

 /*---------------------------------------------------------------------------------------------
 * Judul
 *
 *---------------------------------------------------------------------------------------------
 */
pbtitle('Daftar Penjualan');
?>
<form class="form-inline well" id="form1" name="form1" method="get" action="">
<input type="hidden" name="modul" value="show_jual"/>
  <label>Cari Nomor Nota :</label>
  <span id="sprytextfield1">
	<input class="form-control" type="text" name="noNota" id="noNota" placeholder="Nomor Nota" required="">
  </span>
	<input class="btn btn-info" type="submit" name="cari" id="cari" value="Cari" />
	<input class="btn btn-success" type="button" name="button" id="button" value="Tambah Baru" onClick="location='page.php?modul=add_jual'" />
  
</form>

<?php if ($totalRows_rec_show_jual > 0) { // Show if recordset not empty ?>
  <table class="table table-bordered" border="0">
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
  </table>
  <div class="well">
  Jumlah Total Barang : <b><?php echo number_format($JMLB, 0, '', '.'); ?></b>, 
  Jumlah Total Potongan : <b><?php echo number_format($PTGB, 0, '', '.'); ?></b>, 
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>
  <div class="well">
  <a class="btn btn-large btn-block btn-primary" href="print.php?print=print_jual" target="_blank">Print</a>
  </div>
  <?php } 
  if ($totalRows_rec_show_jual == 0) {
	echo "<div class='alert alert-warning'>
		Data tidak ditemukan, silakan masukkan Nomor Nota dan klik Cari atau klik Tambah baru untuk menambahkan Nomor Nota Baru.
	</div>";
} ?>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
//-->
</script>
