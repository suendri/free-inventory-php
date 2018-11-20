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

mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_plg = "SELECT * FROM pbpelanggan ORDER BY nama ASC";
$rec_show_plg = mysql_query($query_rec_show_plg, $invconnect) or die(mysql_error());
$row_rec_show_plg = mysql_fetch_assoc($rec_show_plg);
$totalRows_rec_show_plg = mysql_num_rows($rec_show_plg);

$colname_rec_show_lap = "-1";
if (isset($_GET['kd_pelanggan']) AND isset($_GET['tgl_awal']) AND isset($_GET['tgl_akhir'])) {
  $colname_rec_show_lap_kd = $_GET['kd_pelanggan'];
  $colname_rec_show_lap_awal = $_GET['tgl_awal'];
  $colname_rec_show_lap_akhir = $_GET['tgl_akhir'];
  
  $_SESSION['kd_pelanggan'] = $colname_rec_show_lap_kd;
  $_SESSION['tgl_awal'] = $colname_rec_show_lap_awal;
  $_SESSION['tgl_akhir'] = $colname_rec_show_lap_akhir;
  
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
// Hitung
$sql = mysql_query("SELECT SUM((pbbarang.hrgJual * pbnotajual.jml) - pbnotajual.potongan) as TA FROM pbnotajual LEFT JOIN pbbarang ON pbnotajual.kdBrg=pbbarang.kode WHERE pbnotajual.kdpelanggan = '".$colname_rec_show_lap_kd."' AND pbnotajual.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotajual.tgl <= '".$colname_rec_show_lap_akhir."'") ;
$TA = mysql_result($sql, 0, 'TA');
}
else {
  $colname_rec_show_lap_kd = "";
  $colname_rec_show_lap_awal = "";
  $colname_rec_show_lap_akhir = "";
}

pbtitle('Laporan Penjualan');
?>

<form class="form-inline well" id="form1" name="form1" method="get" action="">
<input type="hidden" name="modul" value="lap_jual"/>
  <table class="table table-hover">
    <tr>
      <th colspan="2">Pelanggan</th>
    </tr>
    <tr>
      <td style="width:150px;">Nama</td>
      <td><select class="form-control" name="kd_pelanggan" id="kd_pelanggan">
        <?php
do {  
?>
        <option value="<?php echo $row_rec_show_plg['kode']?>"<?php if (!(strcmp($row_rec_show_plg['kode'], $row_rec_show_plg['nama']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rec_show_plg['kode']." - ". $row_rec_show_plg['nama']; ?></option>
        <?php
} while ($row_rec_show_plg = mysql_fetch_assoc($rec_show_plg));
  $rows = mysql_num_rows($rec_show_plg);
  if($rows > 0) {
      mysql_data_seek($rec_show_plg, 0);
	  $row_rec_show_plg = mysql_fetch_assoc($rec_show_plg);
  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <th colspan="2">Periode</th>
    </tr>
    <tr>
      <td>Tanggal </td>
       <td>
	   <div style="width:300px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                <input class="form-control" type="text" name="tgl_awal" value="<?php echo $colname_rec_show_lap_awal; ?>" placeholder="Mulai Tanggal" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
			s/d
		<div style="width:300px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                <input class="form-control" type="text" name="tgl_akhir" value="<?php echo $colname_rec_show_lap_akhir; ?>" placeholder="Sampai Tanggal" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
	   </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" type="submit" name="button" id="button" value="Buat Laporan" />
      </td>
    </tr>
  </table>
</form>

<?php if ($totalRows_rec_show_lap > 0) { // Show if recordset not empty ?>
<div>:: Daftar Penjualan Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
  <table class="table table-bordered">
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
  </table>
   <div class="well well-sm">
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>
  <div class="well">
  <a class="btn btn-large btn-block btn-success" href="print.php?print=print_lap_jual" target="_blank">Print</a>
  </div>
  <?php } 
if (isset($totalRows_rec_show_lap) && $totalRows_rec_show_lap == 0)
{
	echo "<div class='alert alert-warning'>Data tidak ditemukan</div>";
}?>