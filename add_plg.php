<script type="text/javascript">
$(document).ready(function() {
	$("#kdPlg").focus();
	});
	
$(document).ready(function(){
   $("#kdPlg").keyup(function(){
		// tampilkan akdPlgasi loading saat pengecekan ke database
    $('#pesan').html('<img src="Asset/images/loading2.gif">');
    var kdPlg = $("#kdPlg").val();

    $.ajax({
     type:"POST",
     url:"cek_kode.php",
     data: "kdPlg=" + kdPlg,
     success: function(data){
       if(data==0){
          $("#pesan").html('<img src="Asset/images/tick.png"> Kode bisa digunakan');
 	        $('#kdPlg').css('border', '1px #090 solid');
       }
       else{
          $("#pesan").html('<img src="Asset/images/cross.png"> Kode sudah digunakan!');
 	        $('#kdPlg').css('border', '1px #C33 solid');
                $("#kdPlg").val('');
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pbpelanggan (kode, nama, alamat, telp, kota, tgl_masuk) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kdPlg'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['telp'], "text"),
                       GetSQLValueString($_POST['kota'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "date"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($insertSQL, $invconnect) or die(mysql_error());
}

pbtitle('Tambah Pelanggan');
?>

<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td>Kode</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="kdPlg" value="" size="32" required="" id="kdPlg" placeholder="Kode Pelanggan"/>
		<p class="help-block"><span id="pesan"></span><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
		</span></td>
    </tr>
	<tr>
      <td>Tanggal Masuk</td>
      <td>
	  <div style="width:200px;" class="input-group date" data-date="" data-date-format="yyyy-mm-dd">
                <input class="form-control" type="text" name="tgl_masuk" value="" placeholder="Tanggal Masuk" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
	  </td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><span id="sprytextfield2">
        <input class="form-control" type="text" name="nama" value="" size="32" placeholder="Nama Pelanggan" required=""/>
        <p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
		</span></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td><textarea class="form-control" name="alamat" value="" size="32" placeholder="Alamat"></textarea></td>
    </tr>
    <tr>
      <td>Telp</td>
      <td><input type="text" class="form-control" name="telp" value="" size="32"  placeholder="Nomor Telp"/></td>
    </tr>
    <tr>
      <td>Kota</td>
      <td><input type="text" class="form-control" name="kota" value="" size="32"  placeholder="Kota"/></td>
    </tr>    
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="kembali" id="kembali" value="Kembali" onClick="location='page.php?modul=show_plg'"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
//-->
</script>
