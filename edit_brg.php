<script type="text/javascript">
$(document).ready(function() {
	$("#nmBrg").focus();
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
  $updateSQL = sprintf("UPDATE pbbarang SET nmBrg=%s, satuan=%s, hrgBeli=%s, hrgJual=%s, tgl_robah=now() WHERE kode=%s",
                       GetSQLValueString($_POST['nmBrg'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['hrgBeli'], "int"),
                       GetSQLValueString($_POST['hrgJual'], "int"),
                       GetSQLValueString($_POST['kode'], "text"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($updateSQL, $invconnect) or die(mysql_error());
}

$colname_rec_edit_brg = "-1";
if (isset($_GET['kode'])) {
  $colname_rec_edit_brg = $_GET['kode'];
}
mysql_select_db($database_invconnect, $invconnect);
$query_rec_edit_brg = sprintf("SELECT * FROM pbbarang WHERE kode = %s", GetSQLValueString($colname_rec_edit_brg, "text"));
$rec_edit_brg = mysql_query($query_rec_edit_brg, $invconnect) or die(mysql_error());
$row_rec_edit_brg = mysql_fetch_assoc($rec_edit_brg);
$totalRows_rec_edit_brg = mysql_num_rows($rec_edit_brg);

pbtitle('Edit Data Barang');
?>

<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td>Kode:</td>
      <td><?php echo $row_rec_edit_brg['kode']; ?></td>
    </tr>
    <tr>
      <td>Nama:</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="nmBrg" value="<?php echo htmlentities($row_rec_edit_brg['nmBrg'], ENT_COMPAT, 'utf-8'); ?>" size="32" id="nmBrg"/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
		</span></td>
    </tr>
    <tr>
      <td>Satuan:</td>
      <td><input type="text" class="form-control" name="satuan" value="<?php echo htmlentities($row_rec_edit_brg['satuan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>HrgBeli:</td>
      <td><span id="sprytextfield2">
      <input type="text" class="form-control" name="hrgBeli" value="<?php echo htmlentities($row_rec_edit_brg['hrgBeli'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi.</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>HrgJual:</td>
      <td><span id="sprytextfield3">
      <input type="text" class="form-control" name="hrgJual" value="<?php echo htmlentities($row_rec_edit_brg['hrgJual'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">* Wajib diisi.</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>Stock:</td>
      <td>
		<input type="text" class="form-control" name="stock" value="<?php echo htmlentities($row_rec_edit_brg['stock'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly="readonly"/>
		<p class="help-block">Stock otomatis dari Transaksi</p>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="button" id="button" value="Kembali" onClick="location='page.php?modul=show_brg'"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kode" value="<?php echo $row_rec_edit_brg['kode']; ?>" />
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["change"]});
//-->
</script>
