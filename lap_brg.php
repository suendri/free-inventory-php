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

$colname_rec_lap_brg = "-1";
if (isset($_GET['kode']) && $_GET['kode'] != "") {
	$colname_rec_lap_brg = $_GET['kode'];  
	$_SESSION['kode'] = $colname_rec_lap_brg;

	mysql_select_db($database_invconnect, $invconnect);
	$query_rec_lap_brg = sprintf("SELECT * FROM pbbarang WHERE kode = %s", GetSQLValueString($colname_rec_lap_brg, "text"));
	$rec_lap_brg = mysql_query($query_rec_lap_brg, $invconnect) or die(mysql_error());
	$row_rec_lap_brg = mysql_fetch_assoc($rec_lap_brg);
	$totalRows_rec_lap_brg = mysql_num_rows($rec_lap_brg);

} else {
	$colname_rec_lap_brg = "";
}

pbtitle('Laporan Per Barang');
?>

<form class="form-inline well" id="form1" name="form1" method="get" action="">
  <input type="hidden" name="modul" value="lap_brg"/>
  <label>Kode Barang :</label>
  <span id="sprytextfield1">
	<input class="form-control" type="text" name="kode" id="kode" placeholder="Kode Barang" value="<?php echo $colname_rec_lap_brg; ?>" required="">
  </span>
	<input class="btn btn-primary" type="submit" name="Submit" id="cari" value="Buat Laporan" />
	<input class="btn btn-success" type="button" name="button" id="button" value="History Stok" onClick="location='page.php?modul=lap_stock'" />

</form>


<?php if ($totalRows_rec_lap_brg > 0) { // Show if recordset not empty ?>
  <table class="table table-bordered">
  <thead>
    <tr>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Satuan</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Stock</th>
    </tr>
    </thead>
    <tbody>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rec_lap_brg['kode']; ?></td>
        <td><?php echo $row_rec_lap_brg['nmBrg']; ?></td>
        <td><?php echo $row_rec_lap_brg['satuan']; ?></td>
        <td><?php echo $row_rec_lap_brg['hrgBeli']; ?></td>
        <td><?php echo $row_rec_lap_brg['hrgJual']; ?></td>
        <td><?php echo $row_rec_lap_brg['stock']; ?></td>
      </tr>
      <?php } while ($row_rec_lap_brg = mysql_fetch_assoc($rec_lap_brg)); ?>
  </tbody>
  </table>
  
  <?php } 
  if ($totalRows_rec_lap_brg == 0) {
	echo "<div class='alert alert-warning'>
		Data tidak ditemukan, silakan masukkan Kode Barang.
	</div>";
} ?>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
//-->
</script>
