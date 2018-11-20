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
define('VERSION', '3.0');

$hostname_invconnect = "localhost";
$database_invconnect = "dbinventory";
$username_invconnect = "root";
$password_invconnect = "";
$invconnect = mysql_pconnect($hostname_invconnect, $username_invconnect, $password_invconnect) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_invconnect, $invconnect);
