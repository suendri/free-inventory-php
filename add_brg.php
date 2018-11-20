<script type="text/javascript">
$(document).ready(function() {
	$("#kdBrg").focus();
	});
	
$(document).ready(function(){
   $("#kdBrg").keyup(function(){
		// tampilkan akdBrgasi loading saat pengecekan ke database
    $('#pesan').html('<img src="Asset/images/loading2.gif">');
    var kdBrg = $("#kdBrg").val();

    $.ajax({
     type:"POST",
     url:"cek_kode.php",
     data: "kdBrg=" + kdBrg,
     success: function(data){
       if(data==0){
          $("#pesan").html('<img src="Asset/images/tick.png"> Kode bisa digunakan');
 	        $('#kdBrg').css('border', '1px #090 solid');
       }
       else{
          $("#pesan").html('<img src="Asset/images/cross.png"> Kode sudah digunakan!');
 	        $('#kdBrg').css('border', '1px #C33 solid');
                $("#kdBrg").val('');
       }
     }
    });
	})
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

$date = date('Y-m-d H:i:s');
$login = $_SESSION['uname'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pbbarang (kode, nmBrg, satuan, hrgBeli, hrgJual, tgl_masuk, login) VALUES (%s, %s, %s, %s, %s, '$date', '$login')",
                       GetSQLValueString($_POST['kdBrg'], "text"),
                       GetSQLValueString($_POST['nmBrg'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['hrgBeli'], "int"),
                       GetSQLValueString($_POST['hrgJual'], "int"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($insertSQL, $invconnect) or die(mysql_error());
}

pbtitle('Tambah Barang');
?>

<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td style="width:150px;">Kode Barang</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="kdBrg" value="" size="32" id="kdBrg" placeholder="Kode Barang" required=""/>
		<p class="help-block"><span id="pesan"></span><span class="textfieldRequiredMsg">* Wajib Diisi</span></p>
		</span></td>
    </tr>
    <tr>
      <td>Nama Barang</td>
      <td><span id="sprytextfield2">
        <input class="form-control" type="text" name="nmBrg" value="" size="32" placeholder="Nama Barang" required=""/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
		</span></td>
    </tr>
    <tr>
      <td>Satuan</td>
      <td><input class="form-control" type="text" name="satuan" value="" size="32"  placeholder="Satuan Barang"/></td>
    </tr>
    <tr>
      <td>Harga Beli</td>
      <td>
		<span id="sprytextfield3">
		<input class="form-control" type="text" name="hrgBeli" value="" size="32"  placeholder="Harga Beli Barang" required=""/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>Harga Jual</td>
      <td>
		<span id="sprytextfield4">
		<input class="form-control" type="text" name="hrgJual" value="" size="32"  placeholder="Harga Jual Barang" required=""/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span><span class="textfieldInvalidFormatMsg">* Hanya angka tanpa titik</span></p>
	  </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="kembali" id="kembali" value="Kembali" onclick="location='page.php?modul=show_brg'"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["change"]});
//-->
</script>
