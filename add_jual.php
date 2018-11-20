<script type="text/javascript" charset="utf-8">
	//mengidentifikasikan variabel yang kita gunakan
	var kode;
	var nmBrg;
	var hrgJual;
	var satuan;
	var stock;
	$(function(){
                   
		//jika ada perubahan di kode barang
		$("#kode").keyup(function(){
		kode=$("#kode").val();
                        
		//tampilkan status loading dan animasinya
		$("#status").html("<img src='Asset/images/loading2.gif'> Mencari data Barang...");
		$("#loading").show();
                        
		//lakukan pengiriman data
		$.ajax({
			url:"cek_brg.php",
			data:"op=getBrgJual&kode="+kode,
			cache:false,
			success:function(msg){
				data=msg.split("|");
                                
				//masukan isi data ke masing - masing field
				$("#nmBrg").val(data[0]);
				$("#satuan").val(data[1]);
				$("#hrgJual").val(data[2]);
				$("#stock").val(data[3]);
                                
				//hilangkan status animasi dan loading
				$("#status").html("");
				$("#loading").hide();
				}
			});
		});
		
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && $_POST['kode'] != "") {
  if(($_POST['stock'] < $_POST['jml']) or ($_POST['jml'] == 0) or ($_POST['hrgJual'] == 0))
  {
  alertNo('Syarat Penjualan Tidak Memenuhi : Harga Jual besar dari Nol, Stock Barang mencukupi, Jumlah Barang besar dari Nol');
  }
  else {
  $insertSQL = sprintf("INSERT INTO pbnotajual (noNota, tgl, kdPelanggan, kdBrg, jml, potongan, ket) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['noNota'], "text"),
                       GetSQLValueString($_POST['tgl'], "date"),
                       GetSQLValueString($_POST['kdPelanggan'], "text"),
                       GetSQLValueString($_POST['kode'], "text"),
                       GetSQLValueString($_POST['jml'], "int"),
                       GetSQLValueString($_POST['potongan'], "int"),
                       GetSQLValueString($_POST['ket'], "text"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($insertSQL, $invconnect) or die(mysql_error());
  
  /*----------------------------------------------------------------------------------------
   * Update Stock sebelumnnya - Jumlah yang dijual
   *
   *----------------------------------------------------------------------------------------
   */
  $updateSQL = "UPDATE pbbarang SET stock=stock-".$_POST['jml']." WHERE kode='".$_POST['kode']."' ";
  $r1 = mysql_query($updateSQL) or die(mysql_error());
  alertYes('Data Penjualan Berhasil Diproses');
  }
}

mysql_select_db($database_invconnect, $invconnect);
$query_rec_show_plg = "SELECT id, kode, nama FROM pbpelanggan ORDER BY nama ASC";
$rec_show_plg = mysql_query($query_rec_show_plg, $invconnect) or die(mysql_error());
$row_rec_show_plg = mysql_fetch_assoc($rec_show_plg);
$totalRows_rec_show_plg = mysql_num_rows($rec_show_plg);

pbtitle('Tambah Penjualan Barang');
?>
<div class="alert alert-info">
	Data Barang otomatis diambil dari Master Barang, Transaksi berhasil jika Stock ada.
</div>

<form class="well" id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
  <table class="table table-hover">
  	<tr>
      <td style="width:150px;">Tanggal</td>
      <td>
	  <div style="width:200px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                <input class="form-control" type="text" name="tgl" value="" placeholder="Tanggal Penjualan" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
	  </td>
    </tr>
    <tr>
      <td>No Nota</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="noNota" id="noNota" placeholder="Nomor Nota Penjualan" required="" autocomplete="off"/>
		<p class="help-block"><span id="pesan"></span><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>Pelanggan</td>
      <td><select name="kdPelanggan" class="form-control" id="kdPelanggan">
        <?php
do {  
?>
        <option value="<?php echo $row_rec_show_plg['kode']?>"><?php echo $row_rec_show_plg['kode']?> - <?php echo $row_rec_show_plg['nama']?></option>
        <?php
} while ($row_rec_show_plg = mysql_fetch_assoc($rec_show_plg));
  $rows = mysql_num_rows($rec_show_plg);
  if($rows > 0) {
      mysql_data_seek($rec_show_plg, 0);
	  $row_rec_show_plg = mysql_fetch_assoc($rec_show_plg);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td><textarea name="ket" class="form-control" id="ket" rows="3"></textarea></td>
    </tr>
    <tr>
      <td>Kode Barang</td>
      <td>
		<span id="sprytextfield2">
			<input name="kode" class="form-control" id="kode" type="text" placeholder="Kode Barang" required="" autocomplete="off">
			<div id="status"></div><span class="textfieldRequiredMsg">* Wajib diisi</span>
		</span>
	  </td>
    </tr>
    <tr>
      <td>Nama Barang</td>
      <td><input type="text" class="form-control" name="nmBrg" id="nmBrg" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Satuan</td>
      <td><input type="text" class="form-control" name="satuan" id="satuan" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Harga Jual</td>
      <td><input type="text" class="form-control" name="hrgJual" id="hrgJual" readonly="readonly"/></td>
    </tr>
	<tr>
      <td>Stok</td>
      <td><input type="text" class="form-control" name="stock" id="stock" readonly="readonly"/></td>
    </tr>
    <tr>
      <td>Jumlah</td>
      <td><span id="sprytextfield3">
      <input type="text" class="form-control" name="jml" id="jml" placeholder="Jumlah Barang" autocomplete="off"/>
      <p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
	  </tr>
    <tr>
      <td>Potongan</td>
      <td><input type="text" class="form-control" name="potongan" id="potongan" placeholder="Potongan" autocomplete="off" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" name="Submit" type="submit" value="Proses Jual">
      <input class="btn btn-danger" name="Button" type="button" value="Kembali"  onclick="location='page.php?modul=show_jual'"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["change"]});
//-->
</script>