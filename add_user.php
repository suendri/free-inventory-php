<script type="text/javascript">
$(document).ready(function() {
	$("#uname").focus();
	});

	$(document).ready(function(){ 
        $("#upass_cek").blur(function(){
            var upass = $("#upass").val();
            var upass_cek = $("#upass_cek").val();
          
            if((upass_cek != upass) || (upass_cek == '')) {
                $("#passwordconfirm2").html("<span style='color: #CC3333'> Password tidak cocok</span>");
                $("#upass_cek").val('');
            }
            else{
                $("#passwordconfirm2").html("");
            }
        });

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && $_POST['uname'] != "") {
  $insertSQL = sprintf("INSERT INTO pbuser (uname, upass, nama, email, `level`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['upass'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['level'], "int"));

  mysql_select_db($database_invconnect, $invconnect);
  $Result1 = mysql_query($insertSQL, $invconnect) or die(mysql_error());
}

pbtitle('Tambah User');
?>

<form class="well" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table class="table table-hover">
    <tr>
      <td style="width:150px;">Username</td>
      <td><span id="sprytextfield1">
        <input type="text" class="form-control" name="uname" value="" size="32" id="uname" placeholder="Username" required=""/>
		<p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span></p>
		</span></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><span id="sprytextfield2">
      <input type="password" class="form-control" name="upass" id="upass" value="" size="32" placeholder="Password" />
      <p class="help-block"><span class="textfieldRequiredMsg">* Wajib diisi</span><span class="textfieldMinCharsMsg">Minimal 6 Karakter.</span></p></span>
      <span id="passwordconfirm1"></span></td>
    </tr>
    <tr>
      <td>Ulangi Password</td>
      <td><input type="password" class="form-control" name="upass_cek" id="upass_cek" value="" size="32" placeholder="Konfirmasi Password" />
	  <p class="help-block"><span id="passwordconfirm2"></span></p></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><input type="text" class="form-control" name="nama" value="" size="32" placeholder="Nama Lengkap" /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><input type="text" class="form-control" name="email" value="" size="32" placeholder="Alamat Email" /></td>
    </tr>
    <tr>
      <td>Level</td>
      <td><select name="level" class="form-control" id="level">
        <option value="1" selected="selected">Administrator</option>
        <option value="2">Operator</option>
      </select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input class="btn btn-primary" name="Submit" type="submit" value="Simpan Data" />
      <input class="btn btn-primary" type="button" name="button" id="button" value="Kembali" onClick="location='page.php?modul=show_user'" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"], minChars:6});
//-->
</script>
