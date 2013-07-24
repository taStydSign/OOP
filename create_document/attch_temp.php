<?	include '../script/config_database.php';
//echo '<strong>Stamp Time : </strong>'.date('U');
//echo '<HR>';
//echo $_GET['id'];
//echo '/';
//echo $_GET['id_issue'];
//echo '<BR>';

if(!$_GET['id_issue']) { // แสดงไฟล์ใน Temp
		$directory = '../file_attach/temp/';
		$dir_list_ = scandir($directory);	$j=0;

		/*หาข้อมูลใน Temp ที่เป็น sessionของตัวเอง*/
			for($i=2; @$dir_list_[$i]; $i++) {
				//Check temp ที่มี session เดียวกัน
				$exp_tmpname = explode('_', $dir_list_[$i]);
				if($exp_tmpname[0] == $_GET['id']) { $attach_file[$j] = $dir_list_[$i]; $j++; }
			}
			
		//===== แสดงไฟล์ใน Temp =====
		for($k=0; $k<=$j; $k++) {
			$exp_name = explode('--', @$attach_file[$k]);
			?><a href='../file_attach/temp/<?=@$attach_file[$k];?>' target="_blank"><?
			echo $exp_name[(count($exp_name)-1)];
			?></a><?
			echo '<BR>';
		}
		
} else { // แสดงไฟล์ที่ระบุไว้ใน Database
	$data_list_ = mysql_query('SELECT * FROM dex2_new_attach WHERE id_parent LIKE "'.$_GET['id_issue'].'"');
	mysql_num_rows($data_list_);
	for($i=0; $data_list = mysql_fetch_array($data_list_); $i++) {
		
		$direct = '../file_attach/data/'.$data_list['name'];
		
		?><a href='<?=$direct;?>' target='_blank' style="text-decoration:blink"><?
			if(!$data_list['title']) { echo $data_list['name']; }
			else { echo $data_list['title']; }
		?></a><?
		echo '<BR>';
	}
}
?>