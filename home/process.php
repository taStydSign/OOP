<?	include '../script/config_database.php';

	if($_GET['id'] && $_GET['index']) {
		//1 ลบ doc_control ที่มี index, id เท่ากับ $_GET['id'], $_GET['index']
		mysql_query("DELETE FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_GET['id']."' AND index_control LIKE '".$_GET['index']."' LIMIT 1");
		echo "DELETE FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_GET['id']."' AND index_control LIKE '".$_GET['index']."' LIMIT 1";
			
		//2 ถ้า index != 1 { UPDATE doc_01 index = (index-1) WHERE id = $_GET['id'] }
			if($_GET['index'] != 1) {
			mysql_query("UPDATE dex2_new_document_01 SET `index_control` = '".($_GET['index']-1)."' WHERE id LIKE '".$_GET['id']."' LIMIT 1");
			echo '<BR>';
			echo "UPDATE dex2_new_document_01 SET `index_control` = '".($_GET['index']-1)."' WHERE id LIKE '".$_GET['id']."' LIMIT 1";
			}
			
		//3 ลบ document_['index'] { id_doc1 = $_GET['id'] }
			$del_tbl = 'dex2_new_document_'.substr('0'.$_GET['index'], -2 , 2);
			if($_GET['index'] != 1)
				{ $del_sql_3 = 'DELETE FROM '.$del_tbl.' WHERE id_doc1 LIKE "'.$_GET['id'].'" LIMIT 1'; }
			else
				{ $del_sql_3 = 'DELETE FROM '.$del_tbl.' WHERE id LIKE "'.$_GET['id'].'" LIMIT 1'; }
			mysql_query($del_sql_3);
			echo '<BR>';
			echo $del_sql_3;
	}
?>
<script language="javascript">
 window.location="../home/";
</script>