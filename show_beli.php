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

$colname_rec_show_beli = "-1";
if (isset($_GET['noNota'])) {
  $colname_rec_show_beli = $_GET['noNota'];
  $_SESSION['noNota'] = $colname_rec_show_beli;
}
else $colname_rec_show_beli="";

mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_beli = sprintf("SELECT pbnotabeli.noNota as NN, 
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
		WHERE pbnotabeli.noNota = %s", GetSQLValueString($colname_rec_show_beli, "text"));
$rec_show_beli = mysql_query($query_rec_show_beli, $invconnect) or die(mysql_error());
$row_rec_show_beli = mysql_fetch_assoc($rec_show_beli);
$totalRows_rec_show_beli = mysql_num_rows($rec_show_beli);

/*---------------------------------------------------------------------------------------------
 * Hitung
 *
 *---------------------------------------------------------------------------------------------
 */
$sql = mysql_query("SELECT SUM((pbbarang.hrgBeli * pbnotabeli.jml) - pbnotabeli.potongan) as TA, 
					SUM(pbnotabeli.jml) as JMLB, SUM(pbnotabeli.potongan) as PTGB 
					FROM pbnotabeli LEFT JOIN pbbarang ON pbnotabeli.kdBrg=pbbarang.kode 
					WHERE pbnotabeli.noNota = '".$colname_rec_show_beli."' ") ;

$TA = mysql_result($sql, 0, 'TA');
$JMLB = mysql_result($sql, 0, 'JMLB');
$PTGB = mysql_result($sql, 0, 'PTGB');


 /*---------------------------------------------------------------------------------------------
 * Judul
 *
 *---------------------------------------------------------------------------------------------
 */
pbtitle('Transaksi Pembelian');
?>

<form class="form-inline well" id="form1" name="form1" method="get" action="">
<input type="hidden" name="modul" value="show_beli"/>
  <label>Cari Nomor Nota :</label>
  <span id="sprytextfield1">
	<input class="form-control" type="text" name="noNota" id="noNota" placeholder="Nomor Nota" required="">
  </span>
	<input class="btn btn-info" type="submit" name="cari" id="cari" value="Cari" />
	<input class="btn btn-success" type="button" name="button" id="button" value="Tambah Baru" onClick="location='page.php?modul=add_beli'" />
</form>


<?php if ($totalRows_rec_show_beli > 0) { // Show if recordset not empty ?>
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
	$tot = ($row_rec_show_beli['HB']*$row_rec_show_beli['JML'])-$row_rec_show_beli['PTG'];	
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row_rec_show_beli['NN']; ?></td>
        <td><?php echo tanggal_indonesia1($row_rec_show_beli['TGL']); ?></td>
        <td><?php echo $row_rec_show_beli['NP']; ?></td>
        <td><?php echo $row_rec_show_beli['NB']; ?></td>
        <td><?php echo number_format($row_rec_show_beli['HB'], 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_beli['JML']; ?></td>
        <td><?php echo $row_rec_show_beli['PTG']; ?></td>
        <td><?php echo number_format($tot, 0, '', '.'); ?></td>
        <td><?php echo $row_rec_show_beli['KET']; ?></td>
      </tr>
      <?php } while ($row_rec_show_beli = mysql_fetch_assoc($rec_show_beli)); ?>
  </tbody>
  </table>
  <div class="well">
  Jumlah Total Barang : <b><?php echo number_format($JMLB, 0, '', '.'); ?></b>, 
  Jumlah Total Potongan : <b><?php echo number_format($PTGB, 0, '', '.'); ?></b>, 
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>
  <div class="well">
  <a class="btn btn-large btn-block btn-primary" href="print.php?print=print_beli" target="_blank">Print</a>
  </div>
  <?php } 
  if ($totalRows_rec_show_beli == 0) {
	echo "<div class='alert alert-warning'>
		Data tidak ditemukan, silakan masukkan Nomor Nota dan klik Cari atau klik Tambah baru untuk menambahkan Nomor Nota Baru.
	</div>";
} ?>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
//-->
</script>
