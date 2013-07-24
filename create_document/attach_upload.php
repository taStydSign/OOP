<?
	//========หาข้อมูลใน Temp ที่เป็น session ของตัวเอง========
	$directory = '../file_attach/temp/';
	$dir_list_ = scandir($directory);	$j=0;
	for($i=2; $dir_list_[$i]; $i++) {
		//Check temp ที่มี session เดียวกัน
		$exp_tmpname = explode('_', $dir_list_[$i]);
		if($exp_tmpname[0] == $_POST['user_id']) { $file_temp[$j] = $dir_list_[$i]; $j++; }
	}
	
	
	//======== กำหนดชื่อไฟล์ใหม่ ========
		//=== กำหนดนามสกุลไฟล์ ===
		$exp_name = explode('.', $_FILES['attach_file']['name']);
		
		//=== กำหนดชื่อไฟล์ ===
		$attach_name = $_POST['user_id'].'_'.date('Ymd').substr('00'.($j+1), -3, 3).'--';
			//=== Tag ชื่อไฟล์เก่า ===
			for($i=0; $i<(count($exp_name)-1); $i++){
				$attach_name .= $exp_name[$i];
			}
		$attach_name .= '.'.$exp_name[(count($exp_name)-1)];


		copy($_FILES['attach_file']['tmp_name'], $directory.$attach_name);
?>
