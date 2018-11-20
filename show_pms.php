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
$query_rec_show_pemasok = "SELECT * FROM pbpemasok ORDER BY nama ASC";
$rec_show_pemasok = mysql_query($query_rec_show_pemasok, $invconnect) or die(mysql_error());
$row_rec_show_pemasok = mysql_fetch_assoc($rec_show_pemasok);
$totalRows_rec_show_pemasok = mysql_num_rows($rec_show_pemasok);

pbtitle('Daftar Pemasok');
?>

<div class="well">
	<button class="btn btn-large btn-block btn-primary" type="button" onclick="location='page.php?modul=add_pms'"><span class="glyphicon glyphicon-plus"></span> Tambah Pemasok</button>
</div>
<table class="table table-bordered" id="datatable_id">
<thead>
  <tr>
    <th>#</th>
    <th>Kode Pemasok</th>
    <th>Nama Pemasok</th>
    <th>Alamat</th>
    <th>Telp</th>
    <th>Kota</th>
    <th>&nbsp;</th>
  </tr>
</thead>
<tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rec_show_pemasok['id']; ?></td>
      <td><?php echo $row_rec_show_pemasok['kode']; ?></td>
      <td><?php echo $row_rec_show_pemasok['nama']; ?></td>
      <td><?php echo $row_rec_show_pemasok['alamat']; ?></td>
      <td><?php echo $row_rec_show_pemasok['telp']; ?></td>
      <td><?php echo $row_rec_show_pemasok['kota']; ?></td>
      <td><a class="btn btn-primary btn-xs" href="page.php?modul=edit_pms&id=<?php echo $row_rec_show_pemasok['id']; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
    </tr>
    <?php } while ($row_rec_show_pemasok = mysql_fetch_assoc($rec_show_pemasok)); ?>
 </tbody>
</table>