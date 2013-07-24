<?	
	session_start();
	include '../script/config_database.php';

$_POST['txt_password'] = @encode_password($_POST['txt_password'], 'IN');


$ptype = (!empty($_GET['ptype']))?$_GET['ptype']:$_POST['ptype'];

if($ptype == 'SIGNIN') {
		$chk_user_ = mysql_query('SELECT * FROM user WHERE UserName LIKE "'.$_POST['txt_username'].'" AND Password LIKE "'.$_POST['txt_password'].'" LIMIT 0, 1');
		$chk_user = mysql_fetch_array($chk_user_);
		
			if(mysql_num_rows($chk_user_) == '1') {	// มี ข้อมูลใน user

 			$acc_id = $chk_user['username'];
 			$acc_key = md5($chk_user['username'].encode_password($chk_user['password'],'OUT'));
				$_SESSION['USER_ID'] = $acc_id;
				$_SESSION['USER_KEY'] = $acc_key;
				
			$chk_log = mysql_query("SELECT * FROM dex2_new_user_access WHERE USER LIKE '".$acc_id."' LIMIT 0, 1");
				if(mysql_num_rows($chk_log) == 0) $qry_log = "INSERT INTO `dex2_new_user_access` (`id`, `key`, `USER`, `create`, `update`) VALUES (NULL, '', '".$acc_id."', NOW(), NOW());";
				else $qry_log = 'UPDATE  `dex2_new_user_access` SET  `update` = NOW( ) WHERE  `USER` LIKE "'.$acc_id.'" LIMIT 1 ';
				mysql_query($qry_log);
			 		
			} else {	// ไม่มี ข้อมูลใน user
				?><script language="javascript">alert('Username หรือ Password ไม่ถูกต้อง');</script><?
			}
} else if($ptype == 'SIGNOUT') {
	session_destroy();
#	unset($_SESSION['USER_ID']);
#	unset($_SESSION['USER_KEY']);
}


header('Location:../member/form_login.php');
?><script language="javascrpit">window.location="../member/form_login.php";</script><?

/**/
?>