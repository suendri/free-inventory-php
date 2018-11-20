<script type="text/javascript">
$(document).ready(function() {
	$("#hrgBeli").focus();
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pbbarang SET hrgBeli=%s, hrgJual=%s WHERE kode=%s",
                       GetSQLValueString($_POST['hrgBeli'], "int"),
                       GetSQLValueString($_POST['hrgJual'], "int"),
                       GetSQLValueString($_POST['kode'], "text"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($updateSQL, $invconnect) or die(mysql_error());
}

$colname_rec_edit_stock = "-1";
if (isset($_GET['kode'])) {
  $colname_rec_edit_stock = $_GET['kode'];
}
mysql_select_db($database_invconnect, $invconnect);
$query_rec_edit_stock = sprintf("SELECT kode, nmBrg, hrgBeli, hrgJual, stock FROM pbbarang WHERE kode = %s", GetSQLValueString($colname_rec_edit_stock, "text"));
$rec_edit_stock = mysql_query($query_rec_edit_stock, $invconnect) or die(mysql_error());
$row_rec_edit_stock = mysql_fetch_assoc($rec_edit_stock);
$totalRows_rec_edit_stock = mysql_num_rows($rec_edit_stock);

pbtitle('Stok Barang');
?>

<div class="alert alert-info">
	Hanya Harga Beli dan Harga Jual yang dapat dirobah, Stock berobah otomatis sesuai Transaksi Penjualan dan Pembelian.
</div>

<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td style="width:150px;">Kode Barang</td>
      <td><b><?php echo $row_rec_edit_stock['kode']; ?></b></td>
    </tr>
    <tr>
      <td>Nama Barang</td>
      <td><b><?php echo $row_rec_edit_stock['nmBrg']; ?></b></td>
    </tr>
    <tr>
      <td>Harga Beli</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="hrgBeli" value="<?php echo htmlentities($row_rec_edit_stock['hrgBeli'], ENT_COMPAT, 'utf-8'); ?>" size="32" id="hrgBeli"/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>Harga Jual</td>
      <td><span id="sprytextfield2">
        <input type="text" class="form-control" name="hrgJual" value="<?php echo htmlentities($row_rec_edit_stock['hrgJual'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>Stock</td>
      <td>
		<input type="text" class="form-control" name="stock" value="<?php echo htmlentities($row_rec_edit_stock['stock'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly="readonly"/>
		<p class="help-block">Stock otomatis dari Transaksi</p>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" name="Submit" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="kembali" id="kembali" value="Kembali" onClick="location='page.php?modul=show_stock'"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kode" value="<?php echo $row_rec_edit_stock['kode']; ?>" />
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change"]});
//-->
</script>
