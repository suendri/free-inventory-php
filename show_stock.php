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
$query_rec_show_stock = "SELECT * FROM pbbarang ORDER BY nmBrg ASC";
$rec_show_stock = mysql_query($query_rec_show_stock, $invconnect) or die(mysql_error());
$row_rec_show_stock = mysql_fetch_assoc($rec_show_stock);
$totalRows_rec_show_stock = mysql_num_rows($rec_show_stock);

pbtitle('Data Stok Barang');
?>
<div class="alert alert-info">
	<strong>Info!</strong> Masukkan Nama atau Kode Barang pada kolom pencarian dan Klik Kode Barang untuk melakukan perobahan.
</div>
<table class="table table-bordered" id="datatable_id">
<thead>
  <tr>
    <th>#</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Satuan</th>
    <th>Stock</th>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rec_show_stock['id']; ?></td>
      <td><a href="page.php?modul=edit_stock&kode=<?php echo $row_rec_show_stock['kode']; ?>"><?php echo $row_rec_show_stock['kode']; ?></a></td>
      <td><?php echo $row_rec_show_stock['nmBrg']; ?></td>
      <td><?php echo $row_rec_show_stock['satuan']; ?></td>
      <td><?php echo $row_rec_show_stock['stock']; ?></td>
    </tr>
    <?php } while ($row_rec_show_stock = mysql_fetch_assoc($rec_show_stock)); ?>
    </tbody>
</table>