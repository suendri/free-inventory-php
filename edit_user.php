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
  $updateSQL = sprintf("UPDATE pbuser SET upass=%s, nama=%s, email=%s, `level`=%s WHERE id=%s",
                       GetSQLValueString($_POST['upass'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['level'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($updateSQL, $invconnect) or die(mysql_error());
}

$colname_rec_edit_user = "-1";
if (isset($_GET['id'])) {
  $colname_rec_edit_user = $_GET['id'];
}
mysql_select_db($database_invconnect, $invconnect);
$query_rec_edit_user = sprintf("SELECT * FROM pbuser WHERE id = %s", GetSQLValueString($colname_rec_edit_user, "int"));
$rec_edit_user = mysql_query($query_rec_edit_user, $invconnect) or die(mysql_error());
$row_rec_edit_user = mysql_fetch_assoc($rec_edit_user);
$totalRows_rec_edit_user = mysql_num_rows($rec_edit_user);

pbtitle('Edit User');
?>
<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td style="width:150px;">Username</td>
      <td><?php echo htmlentities($row_rec_edit_user['uname'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input type="password" class="form-control" name="upass" id="upass" placeholder="Password"></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><input type="text" class="form-control" name="nama" value="<?php echo htmlentities($row_rec_edit_user['nama'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type="text" class="form-control" name="email" value="<?php echo htmlentities($row_rec_edit_user['email'], ENT_COMPAT, 'utf-8'); ?>" /></td>
    </tr>
    <tr>
      <td>Level</td>
      <td><select name="level" class="form-control" id="level">
        <option value="1" <?php if (!(strcmp(1, $row_rec_edit_user['level']))) {echo "selected=\"selected\"";} ?>>Administrator</option>
        <option value="2" <?php if (!(strcmp(2, $row_rec_edit_user['level']))) {echo "selected=\"selected\"";} ?>>Operator</option>
      </select>
</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" name="Submit" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="Button" id="button" value="Kembali" onClick="location='page.php?modul=show_user'"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_rec_edit_user['id']; ?>" />
</form>
