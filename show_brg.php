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
$query_rec_show_brg = "SELECT * FROM pbbarang ORDER BY nmBrg ASC";
$rec_show_brg = mysql_query($query_rec_show_brg, $invconnect) or die(mysql_error());
$row_rec_show_brg = mysql_fetch_assoc($rec_show_brg);
$totalRows_rec_show_brg = mysql_num_rows($rec_show_brg);

pbtitle('Daftar Barang');
?>
<div class="well">
	<button class="btn btn-large btn-block btn-primary" type="button" onclick="location='page.php?modul=add_brg'"><span class="glyphicon glyphicon-plus"></span> Tambah Barang</button>
</div>
<table class="table table-bordered" id="datatable_id">
<thead>
  <tr>
    <th>#</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Satuan</th>
    <th>Harga Beli</th>
    <th>Harga Jual</th>
    <th>Stok</th>
    <th>&nbsp;</th>
  </tr>
  </thead>
  <tbody>
  <?php $no=0; do { $no++;?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $row_rec_show_brg['kode']; ?></td>
      <td><?php echo $row_rec_show_brg['nmBrg']; ?></td>
      <td><?php echo $row_rec_show_brg['satuan']; ?></td>
      <td><?php echo number_format($row_rec_show_brg['hrgBeli'], 0, '', '.'); ?></td>
      <td><?php echo number_format($row_rec_show_brg['hrgJual'], 0, '', '.'); ?></td>
      <td><?php echo $row_rec_show_brg['stock']; ?></td>
      <td><a class="btn btn-primary btn-xs" href="page.php?modul=edit_brg&kode=<?php echo $row_rec_show_brg['kode']; ?>" title="Edit"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
    </tr>
    <?php } while ($row_rec_show_brg = mysql_fetch_assoc($rec_show_brg)); ?>
  </tbody>
</table>
