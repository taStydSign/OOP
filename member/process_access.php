<?	include '../script/config_database.php'; 
		$tform = ($_POST['tform'])?$_POST['tform']:$_GET['tform'];
		
	if($tform == 'DELETE' && $_GET['id']) {
		$str_query = 'DELETE FROM dex2_user_group WHERE UserGroupId LIKE "'.$_GET['id'].'" LIMIT 1';
		mysql_query("DELETE FROM dex2_new_access_layer WHERE id_access LIKE '".$_GET['id']."'");	
	} else if($tform == 'ADD') {
		//ข้อมูลของสิทธิ
		$acc_ = $_POST['acc_'];
		$user_ = $_POST['user_'];
		
		$str_query = 'INSERT INTO dex2_user_group ';
		$str_query .= '(`GroupName`, `access`, `data_acc_view`, `data_acc_add`, `data_acc_edit`, `data_acc_delete`, `data_user_view`, `data_user_add`, `data_user_edit`, `data_user_delete`) VALUE ';
		$str_query .= '("'.$_POST['access'].'", "'.$_POST['acccess'].'", "'.$acc_[V].'", "'.$acc_[A].'", "'.$acc_[E].'", "'.$acc_[D].'", "'.$user_[V].'", "'.$user_[A].'", "'.$user_[E].'", "'.$user_[D].'")';
		
		mysql_query($str_query); unset($str_query);
		$dex2_user_group = mysql_fetch_array(mysql_query("SELECT UserGroupId FROM dex2_user_group ORDER BY `UserGroupId` DESC LIMIT 0, 1"));
		//ข้อมูลของสิทธิ
		
		/*
				$str_query = "UPDATE dex2_user_group SET `GroupName` = '".$_POST['access']."', `access` = '".$_POST['access_data']."', ";
		$str_query .= "`data_acc_view` = '".$acc_[V]."', `data_acc_add` = '".$acc_[A]."', `data_acc_edit` = '".$acc_[E]."', `data_acc_delete` = '".$acc_[D]."', ";
		$str_query .= "`data_user_view` = '".$user_[V]."', `data_user_add` = '".$user_[A]."', `data_user_edit` = '".$user_[E]."', `data_user_delete` = '".$user_[D]."'";
		$str_query .= " WHERE UserGroupId LIKE '".$_POST['id']."' LIMIT 1";
		*/

		//สิทธิการเข้าถึงข้อมูล		
				$_POST['id'] = $dex2_user_group['UserGroupId'];
				$acc_layer = $_POST['acc_layer'];
				$acc_layer_list = mysql_query("SELECT id FROM dex2_new_access_layer_detail");
				
				for($i=0; $acc_layer_list_ = mysql_fetch_array($acc_layer_list); $i++) {
					$acclayer = $acc_layer[$acc_layer_list_['id']];
					$chk_layer_list = mysql_num_rows(mysql_query("SELECT * FROM dex2_new_access_layer WHERE id_access LIKE '".$_POST['id']."' AND id_access_ldetail LIKE '".$acc_layer_list_['id']."' LIMIT 0, 1"));
		
					if($acclayer[V] || $acclayer[A] || $acclayer[E] || $acclayer[D]) {
							if($chk_layer_list == 0) {
								//เพิ่มข้อมูล access layer
								$sub_query = "INSERT INTO dex2_new_access_layer (`id_access`, `id_access_ldetail`, `status_view`, `status_add`, `status_edit`, `status_delete`)";
								$sub_query .= "VALUE ('".$_POST['id']."', '".$acc_layer_list_['id']."', '".$acclayer[V]."', '".$acclayer[A]."', '".$acclayer[E]."', '".$acclayer[D]."');";
								
								mysql_query($sub_query);
							} 
					}
				}
		//สิทธิการเข้าถึงข้อมูล		

	} else if($tform == 'EDIT' && $_POST['id']) {

	//ข้อมูลของสิทธิ
		$acc_ = $_POST['acc_'];
		$user = $_POST['user_'];
		
		$str_query = "UPDATE dex2_tbluser_group SET `GroupName` = '".$_POST['access']."', `access` = '".$_POST['access_data']."', ";
		$str_query .= "`data_acc_view` = '".$acc_[V]."', `data_acc_add` = '".$acc_[A]."', `data_acc_edit` = '".$acc_[E]."', `data_acc_delete` = '".$acc_[D]."', ";
		$str_query .= "`data_user_view` = '".$user_[V]."', `data_user_add` = '".$user_[A]."', `data_user_edit` = '".$user_[E]."', `data_user_delete` = '".$user_[D]."'";
		$str_query .= " WHERE UserGroupId LIKE '".$_POST['id']."' LIMIT 1";
		
	//ข้อมูลของสิทธิ
	
		
	//สิทธิการเข้าถึงข้อมูล		
			$acc_layer = $_POST['acc_layer'];
			$acc_layer_list = mysql_query("SELECT id FROM dex2_new_access_layer_detail");
			
			for($i=0; $acc_layer_list_ = mysql_fetch_array($acc_layer_list); $i++) {
				$acclayer = $acc_layer[$acc_layer_list_['id']];
				$chk_layer_list = mysql_num_rows(mysql_query("SELECT * FROM dex2_new_access_layer WHERE id_access LIKE '".$_POST['id']."' AND id_access_ldetail LIKE '".$acc_layer_list_['id']."' LIMIT 0, 1"));
	
				if($acclayer[V] || $acclayer[A] || $acclayer[E] || $acclayer[D]) {
						if($chk_layer_list == 0) {
							//เพิ่มข้อมูล access layer
							$sub_query = "INSERT INTO dex2_new_access_layer (`id_access`, `id_access_ldetail`, `status_view`, `status_add`, `status_edit`, `status_delete`)";
							$sub_query .= "VALUE ('".$_POST['id']."', '".$acc_layer_list_['id']."', '".$acclayer[V]."', '".$acclayer[A]."', '".$acclayer[E]."', '".$acclayer[D]."');";
							
							mysql_query($sub_query);
						} else {
							//แก้ไขข้อมูล access layer
							$sub_query = "UPDATE dex2_new_access_layer SET `status_view` = '".$acclayer[V]."', `status_add` = '".$acclayer[A]."', `status_edit` = '".$acclayer[E]."', `status_delete` = '".$acclayer[D]."'";
							$sub_query .= "WHERE id_access LIKE '".$_POST['id']."' AND id_access_ldetail LIKE '".$acc_layer_list_['id']."' LIMIT 1";
							
							mysql_query($sub_query);
						}
				} else {
						if($chk_layer_list==1) {
							$sub_query = "DELETE FROM dex2_new_access_layer WHERE id_access LIKE '".$_POST['id']."' AND id_access_ldetail LIKE '".$acc_layer_list_['id']."' LIMIT 1";
							
							mysql_query($sub_query);
						}
				}
			}
	//สิทธิการเข้าถึงข้อมูล		
	}
	
	echo $str_query;
	mysql_query($str_query);

	header("Location:../member/access.php");
?>
<script language="javascript">
	window.location='../member/access.php';
</script>