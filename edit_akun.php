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

$colname_rec_edit_user = $_SESSION['Uid'];

$query_rec_edit_user = sprintf("SELECT * FROM pbuser WHERE id = %s", GetSQLValueString($colname_rec_edit_user, "int"));
$rec_edit_user = mysql_query($query_rec_edit_user, $invconnect) or die(mysql_error());
$row_rec_edit_user = mysql_fetch_assoc($rec_edit_user);
$totalRows_rec_edit_user = mysql_num_rows($rec_edit_user);

pbtitle('Edit User');
?>
	
<form class="well" action="aksi_user.php" method="post" name="form3" id="form3">
<input type="hidden" name="id" value="<?php echo $_SESSION['Uid']; ?>"  />
  <table class="table table-hover">
    <tr>
      <td style="width:150px;">Username</td>
      <td><?php echo htmlentities($row_rec_edit_user['uname'], ENT_COMPAT, 'utf-8'); ?></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name="upass" class="form-control" type="password" id="upass" value="" size="32" maxlength="15" placeholder="Password"/>
       <p class="help-block">Kosongkan jika tidak merobah Password</p></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><input name="nama" class="form-control" type="text" value="<?php echo htmlentities($row_rec_edit_user['nama'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="50" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input name="email" class="form-control" type="text" value="<?php echo htmlentities($row_rec_edit_user['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="25" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" name="Submit" type="submit" value="Simpan Data" /></td>
    </tr>
  </table>
  <input type="hidden" name="update_akun" value="form3" />
</form>
