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

define('ENVIRONMENT', 'production');

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable uname set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['uname'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['uname'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){

	$_SESSION['uname'] = NULL;
	unset($_SESSION['uname']);	
	session_destroy();
		
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sistem Inventory v3.0 Donasi:: PHPBeGO Foundation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Inventory">
    <meta name="author" content="phpbego">
	<link rel="shortcut icon" href="Asset/images/favicon.png">
    <link href="Asset/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="Asset/css/bootstrap.datatable.css" rel="stylesheet" type="text/css">
	<link href="Asset/css/datepicker.css" rel="stylesheet" type="text/css">
    <link href="Asset/css/custom.css" rel="stylesheet" type="text/css">
    <link href="Asset/css/style.css" rel="stylesheet" type="text/css">   
    
    <script src="Asset/js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="Asset/js/jquery.datatable.min.js" type="text/javascript"></script>    
    <script src="Asset/js/bootstrap.datatable.js" type="text/javascript"></script>
    <script src="Asset/js/bootstrap.datepicker.js" type="text/javascript"></script>
	
	<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
	
	<script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                $('#datatable_id').dataTable();
            });
    </script>
  </head>

  <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">INVENTORY</a>
                </div>
				<div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="page.php?modul=show_brg">Barang</a></li>
								<li><a href="page.php?modul=show_pms">Pemasok</a></li>
								<li><a href="page.php?modul=show_plg">Pelanggan</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="page.php?modul=show_beli">Pembelian</a></li>
								<li><a href="page.php?modul=show_jual">Penjualan</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Stok <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="page.php?modul=show_stock">Data Stok</a></li>
								<li><a href="page.php?modul=lap_stock">History</a></li>
							</ul>
						</li>						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="page.php?modul=lap_beli">Pembelian</a></li>
								<li><a href="page.php?modul=lap_jual">Penjualan</a></li>
								<li class="divider"></li>
								<li class="dropdown-header">Laporan Per</li>
								<li><a href="page.php?modul=lap_brg">Barang</a></li>
							</ul>
						</li>
						<?php if ($_SESSION['Level'] == 1) { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sistem <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="page.php?modul=show_user">User</a></li>
							</ul>
						</li>
						<?php } ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['uname']; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="page.php?modul=edit_akun">Pengaturan Akun</a></li>
								<li><a href="page.php?doLogout=true">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
      </div>
	<div class="content">
		<div class='top'>
			<div class='container'>
				<h2 class='titletop'>
					Sistem Inventory<br />
					<span>PHPBeGO Foundation</span>
				</h2>
			</div>
		</div>
		<div class="container">
			<div class="col-md-12">
			<p>
			<?php 			
			require ("sis_config.php");
			if(isset($_GET['modul'])){ 
				if(file_exists($_GET['modul'].".php")) {	
				require_once($_GET['modul'].".php");  } 			
				else { echo "<h3><br>Error !!</h3><b>Maaf file yang anda cari tidak ditemukan!</b>"; } 
				} 
			else { 
				require ("modul.php");
			}	?>
			</p>
			</div>
			<p>Copyright &copy; 2013 - <?php echo date("Y"); ?> <a href="http://phpbego.wordpress.com" target="_blank">PHPBeGO Foundation</a>. Sistem Inventory v<?php echo VERSION; ?> Donasi.</p>
		</div>

	</div>
    <script src="Asset/js/bootstrap.min.js"></script>
	<script>
	//options method for call datepicker
	$(".input-group.date").datepicker({ autoclose: true, todayHighlight: true });	
        </script>
  </body>
</html>
