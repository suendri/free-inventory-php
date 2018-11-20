<script type="text/javascript">
$(document).ready(function() {
	$("#nama").focus();
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
  $updateSQL = sprintf("UPDATE pbpemasok SET nama=%s, alamat=%s, telp=%s, kota=%s, tgl_masuk=%s WHERE id=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['telp'], "text"),
                       GetSQLValueString($_POST['kota'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($updateSQL, $invconnect) or die(mysql_error());
}

$colname_rec_edit_pms = "-1";
if (isset($_GET['id'])) {
  $colname_rec_edit_pms = $_GET['id'];
}
mysql_select_db($database_invconnect, $invconnect);
$query_rec_edit_pms = sprintf("SELECT * FROM pbpemasok WHERE id = %s", GetSQLValueString($colname_rec_edit_pms, "int"));
$rec_edit_pms = mysql_query($query_rec_edit_pms, $invconnect) or die(mysql_error());
$row_rec_edit_pms = mysql_fetch_assoc($rec_edit_pms);
$totalRows_rec_edit_pms = mysql_num_rows($rec_edit_pms);

pbtitle('Edit Pemasok');
?>

<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td style="width:150px;">Kode</td>
      <td><?php echo htmlentities($row_rec_edit_pms['kode'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
	<tr>
      <td>Tanggal masuk</td>
      <td>
		<div style="width:200px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                <input class="form-control" type="text" name="tgl_masuk" value="<?php echo htmlentities($row_rec_edit_pms['tgl_masuk'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Tanggal Masuk" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
	  </td>
    </tr>
    <tr>
      <td>Nama Pemasok</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="nama" value="<?php echo htmlentities($row_rec_edit_pms['nama'], ENT_COMPAT, 'utf-8'); ?>" size="32" id="nama" required=""/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
		</span></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td><textarea name="alamat" class="form-control" value="<?php echo htmlentities($row_rec_edit_pms['alamat'], ENT_COMPAT, 'utf-8'); ?>"><?php echo htmlentities($row_rec_edit_pms['alamat'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr>
      <td>Telp</td>
      <td><input type="text" class="form-control" name="telp" value="<?php echo htmlentities($row_rec_edit_pms['telp'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Kota</td>
      <td><input type="text" class="form-control" name="kota" value="<?php echo htmlentities($row_rec_edit_pms['kota'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>    
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="button" id="button" value="Kembali" onclick="location='page.php?modul=show_pms'"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_rec_edit_pms['id']; ?>" />
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
//-->
</script>
