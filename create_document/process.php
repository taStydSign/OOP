<?	session_start();	include '../script/config_database.php';
$_POST['status_send'] = @$_POST['status_send'];
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '1' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

$tform = ($_POST['tform'])?$_POST['tform']:$_GET['tform'];


$book_date = $_POST['book_date'];
$date = $_POST['date'];

if(mysql_num_rows($chk_log_) == 0) {

	$str_query = "INSERT INTO dex2_new_document_01 ";
	$str_query .= "(`book_no`, `book_date`, `send`, `date`, `title`, `to`, `detail`, `from`, `haste`, `secrecy`, `comment`, `date_create`, `date_save`, `date_send`, `index_control`) VALUE ";
	$str_query .= "('".$_POST['book_no']."', '".$book_date."','".$_POST['send']."', '".$date."', '".$_POST['title']."','".$_POST['to']."', '".$_POST['detail']."', '".$_POST['from']."','".$_POST['haste']."', '".$_POST['secrecy']."', '".$_POST['comment']."', NOW(), NOW(), ";
	if($_POST['status_send']=='on') { $str_query .= "NOW(), '2'"; } else { $str_query .= "'', '1'"; }
	$str_query .= ")";
	

} else {

	$str_query = "UPDATE dex2_new_document_01 SET ";
	$str_query .= "`book_no` = '".$_POST['book_no']."', `book_date` = '".$book_date."', `send` = '".$_POST['send']."', `date` = '".$date."', `title` = '".$_POST['title']."', `to` = '".$_POST['to']."', `detail` = '".$_POST['detail']."', `from` = '".$_POST['from']."', `haste` = '".$_POST['haste']."', `secrecy` = '".$_POST['secrecy']."', `comment` = '".$_POST['comment']."', `date_save` = NOW(), ";

	if($_POST['status_send']=='on') { $str_query .= "`date_send` = NOW(), `index_control` = '2'"; } else { $str_query .= "`date_send` = ''"; }
	$str_query .= " WHERE id LIKE '".$_POST['id']."' LIMIT 1";

}



//echo $str_query;
mysql_query($str_query);





if(mysql_num_rows($chk_log_) == 0) {
	$str_dtl = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_01 WHERE book_no LIKE '".$_POST['book_no']."' ORDER BY `id` DESC LIMIT 0, 1"));

	if($_POST['status_send'] == 'on') { $str_status = 'END'; } else { $str_status = 'WAITE'; }
	
	$sub_query = "INSERT INTO dex2_new_document_control ";
	$sub_query .= "(`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ";
	$sub_query .= "('".$str_dtl['id']."', '1', '".$str_status."', '".$_POST['send']."', NOW(), '-')";
	mysql_query($sub_query);
	
	$str_dtl = mysql_fetch_array(mysql_query("SELECT id FROM dex2_new_document_01 WHERE book_no LIKE '".$_POST['book_no']."' AND index_control LIKE '1' ORDER BY id DESC LIMIT 0, 1"));
	//movetemp file from temp 2 data

		$directory = '../file_attach/temp/';
		$dir_list_ = scandir($directory);
		$j=0;
		
		for($i=2; $dir_list_[$i]; $i++) {
			$name_exp = explode('_', $dir_list_[$i]);
			if($name_exp[0] == $_SESSION['USER_ID']) 
			{	$name_exp = explode('.', $dir_list_[$i]);
				$file_name = date('U').'_'.$j.'.'.$name_exp[(count($name_exp)-1)];
				$attach_list[$j] = $dir_list_[$i];
				copy('../file_attach/temp/'.$attach_list[$j], '../file_attach/data/'.$file_name);
				unlink('../file_attach/temp/'.$attach_list[$j]);
				$exp_name = explode('--', $attach_list[$j]);
				mysql_query('INSERT INTO dex2_new_attach (`id_parent`, `name`, `title`, `comment`) VALUE ("'.$str_dtl[0].'", "'.$file_name.'", "'.$exp_name[(count($exp_name)-1)].'", "'.$_SESSION['file_attach'][$attach_list[$j]][1].'")');
				unset($_SESSION['file_attach'][$attach_list[$j]]);
				$j++; /* */
			}

		}	
} else {
	$sub_query = 'UPDATE dex2_new_document_control SET ';
	if($_POST['status_send'] == 'on') { $sub_query .= '`status` = "END", '; }
	$sub_query .= '`no` = "'.$_POST['send'].'", ';
	$sub_query .= '`date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1 ';	
	mysql_query($sub_query);
}


//mysql_query($sub_query);
?>
<script language="javascript">
window.location='../home/'; 
</script>