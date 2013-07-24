<? include '../script/config_database.php';	$_POST['tform'] = (!empty($_POST['tform']))?$_POST['tform']:@$_GET['tform'];

$type = ($_GET['type'])?$_GET['type']:$_POST['type'];


if($type == 'REGIST') {
		if($_GET['status'] == 'IN') { 
			mysql_query("INSERT INTO dex2_new_user_access (`user`, `key`, `create`, `update`) VALUE ('".$_GET['id']."', '".md5(rand(0,1000))."', NOW(), NOW());");
		} else if($_GET['status'] == 'OUT') {
			mysql_query("DELETE FROM dex2_new_user_access WHERE `user` LIKE '".$_GET['id']."' LIMIT 1");
		} else { ?><script language="javascript">alert('การเข้าถึงไม่ถูกต้อง กรุณาติดต่อผู้ดูแลระบบ');</script><? }
		?> <script language="javascript"> history.back(1); </script> <?
	
	
} else if($type == 'EDIT' && $_POST['id']) {
		mysql_query('UPDATE `dex2_new_user_access` SET  `id_access` =  "'.$_POST['slc_acc'].'", `update` = NOW( ) WHERE  `id` LIKE "'.$_POST['id'].'" LIMIT 1 ;');
		

		?> <script language="javascript">window.location='../member/user_document.php'; </script> <?


}
?>
