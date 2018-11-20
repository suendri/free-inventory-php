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
$query_rec_show_user = "SELECT * FROM pbuser ORDER BY uname ASC";
$rec_show_user = mysql_query($query_rec_show_user, $invconnect) or die(mysql_error());
$row_rec_show_user = mysql_fetch_assoc($rec_show_user);
$totalRows_rec_show_user = mysql_num_rows($rec_show_user);

pbtitle('Master User');
?>
<div class="well">
	<button class="btn btn-large btn-block btn-primary" type="button" onclick="location='page.php?modul=add_user'">Tambah User</button>
</div>
<table class="table table-bordered" id="datatable_id">
<thead>
  <tr>
    <th>#</th>
    <th>Username</th>
    <th>Nama Lengkap</th>
    <th>Email</th>
    <th>Level</th>
    <th>&nbsp;</th>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rec_show_user['id']; ?></td>
      <td><?php echo $row_rec_show_user['uname']; ?></td>
      <td><?php echo $row_rec_show_user['nama']; ?></td>
      <td><?php echo $row_rec_show_user['email']; ?></td>
      <td><?php if ($row_rec_show_user['level'] == 1) echo "Administrator"; else echo "Operator"; ?></td>
      <td><a href="page.php?modul=edit_user&id=<?php echo $row_rec_show_user['id']; ?>"><span class="glyphicon glyphicon-edit"></span></a></td>
    </tr>
    <?php } while ($row_rec_show_user = mysql_fetch_assoc($rec_show_user)); ?>
	</tbody>
	</table>

