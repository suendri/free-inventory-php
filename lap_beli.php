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
$query_rec_show_pms = "SELECT * FROM pbpemasok ORDER BY nama ASC";
$rec_show_pms = mysql_query($query_rec_show_pms, $invconnect) or die(mysql_error());
$row_rec_show_pms = mysql_fetch_assoc($rec_show_pms);
$totalRows_rec_show_pms = mysql_num_rows($rec_show_pms);

$colname_rec_show_lap = "-1";
if (isset($_GET['kd_pemasok']) AND isset($_GET['tgl_awal']) AND isset($_GET['tgl_akhir'])) {
  $colname_rec_show_lap_kd = $_GET['kd_pemasok'];
  $colname_rec_show_lap_awal = $_GET['tgl_awal'];
  $colname_rec_show_lap_akhir = $_GET['tgl_akhir'];
  
  $_SESSION['kd_pemasok'] = $colname_rec_show_lap_kd;
  $_SESSION['tgl_awal'] = $colname_rec_show_lap_awal;
  $_SESSION['tgl_akhir'] = $colname_rec_show_lap_akhir;
  
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
// Hitung
$sql = mysql_query("SELECT SUM((pbbarang.hrgBeli * pbnotabeli.jml) - pbnotabeli.potongan) as TA FROM pbnotabeli LEFT JOIN pbbarang ON pbnotabeli.kdBrg=pbbarang.kode WHERE pbnotabeli.kdPemasok = '".$colname_rec_show_lap_kd."' AND pbnotabeli.tgl >= '".$colname_rec_show_lap_awal."' AND pbnotabeli.tgl <= '".$colname_rec_show_lap_akhir."'") ;
$TA = mysql_result($sql, 0, 'TA');
}
else {
  $colname_rec_show_lap_kd = "";
  $colname_rec_show_lap_awal = "";
  $colname_rec_show_lap_akhir = "";

}

pbtitle('Laporan Pembelian');
?>

<form class="form-inline well" id="form1" name="form1" method="get" action="">
<input type="hidden" name="modul" value="lap_beli"/>
  <table class="table table-hover">
    <tr>
      <th colspan="2">Pemasok</th>
    </tr>
    <tr>
      <td style="width:150px;">Nama</td>
      <td><select name="kd_pemasok" class="form-control" id="kd_pemasok">
        <?php
do {  
?>
        <option value="<?php echo $row_rec_show_pms['kode']?>"<?php if (!(strcmp($row_rec_show_pms['kode'], $row_rec_show_pms['nama']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rec_show_pms['kode']." - ". $row_rec_show_pms['nama']; ?></option>
        <?php
} while ($row_rec_show_pms = mysql_fetch_assoc($rec_show_pms));
  $rows = mysql_num_rows($rec_show_pms);
  if($rows > 0) {
      mysql_data_seek($rec_show_pms, 0);
	  $row_rec_show_pms = mysql_fetch_assoc($rec_show_pms);
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
<div>:: Daftar Pembelian Tanggal <b><?php echo tanggal_indonesia1($colname_rec_show_lap_awal); ?></b> s/d <b><?php echo tanggal_indonesia1($colname_rec_show_lap_akhir); ?></b></div>
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
  </table>
   <div class="well well-sm">
  Jumlah Total Akhir : <b><?php echo number_format($TA, 0, '', '.'); ?></b>
  </div>
  <div class="well">
  <a class="btn btn-large btn-block btn-success" href="print.php?print=print_lap_beli" target="_blank">Print</a>
  </div>
<?php } 
if (isset($totalRows_rec_show_lap) && $totalRows_rec_show_lap == 0)
{
	echo "<div class='alert alert-warning'>Data tidak ditemukan</div>";
}?>