<?	session_start(); include '../script/config_database.php'; ?>
<script language="javascript" src='../script/javascript/jquery_main.js'></script>

<?	$type = ($_GET['type'])?$_GET['type']:$_POST['type'];

if(!$type) {
	if($_FILES['files']['error'] != 0 ) { ?><script language="javascript">alert('กรุณาแนบไฟล์ก่อนการบันทึกข้อมูล'); window.location='form_attachfile.php?id=<?=$_POST['id'];?>'; </script><? }
	
	
	if(!$_POST['id']) { 
			$name_exp = explode('.', $_FILES['files']['name']);
			$file_name = $_SESSION['USER_ID'].'_'.date('U').'.'.$name_exp[(count($name_exp)-1)];
			$file_title = str_replace('.'.$name_exp[(count($name_exp)-1)], '', $_FILES['files']['name']);
			
			copy($_FILES['files']['tmp_name'], '../file_attach/temp/'.$file_name);
			$_SESSION['file_attach'][$file_name] = array($file_title, $_POST['comment']);
			
			
	} else { 
			$name_exp = explode('.', $_FILES['files']['name']);
			$file_name = date('U').'.'.$name_exp[(count($name_exp)-1)];
			$file_title = str_replace('.'.$name_exp[(count($name_exp)-1)], '', $_FILES['files']['name']);
			
			copy($_FILES['files']['tmp_name'], '../file_attach/data/'.$file_name);
			mysql_query("INSERT INTO dex2_new_attach (`id_parent`, `name`, `title`, `comment`) VALUE ('".$_POST['id']."', '".$file_name."', '".$file_title."', '".$_POST['comment']."')"); 	?>
	<? } ?>
            
            รอประมาณ 5 วินาที หน้าต่างนี้จะทำการปิดตัวเองลง ถ้าหากไม่ต้องการรอ กรุณากด <input type='button' value='ปิดหน้าต่างนี้' onclick='window.close();'/>
            <script language="javascript">
                var obj_mainpage = $('#sector_attach', window.opener.document);
                urlLink = 'form_attach.php?id=<?=$_POST['id'];?>';
                setTimeout(function() { obj_mainpage.load(urlLink); }, 1000);
                setTimeout(function() { window.close(); } , 5000);
            </script>
    

<? /**/ } else if($type == 'DELETE') { 
	
	if(!$_GET['id_attach']) { 
//		echo $type;
//		echo $_GET['name'];
		unlink('../file_attach/temp/'.$_GET['name']);
	} else {
		$attach_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_new_attach WHERE id LIKE "'.$_GET['id_attach'].'" LIMIT 0, 1'));
		if($attach_dtl['name']) { unlink('../file_attach/data/'.$attach_dtl['name']); }
		mysql_query("DELETE FROM dex2_new_attach WHERE id LIKE '".$_GET['id_attach']."' LIMIT 1"); ?>
        
	<? } ?>    
    
	<script language="javascript">
        urlLink = 'form_attach.php?id=<?=$_GET['id'];?>';
        setTimeout(function() { $('#sector_attach').load(urlLink) }, 500);
    </script>


<? } ?>