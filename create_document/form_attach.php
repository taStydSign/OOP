<?	session_start(); 	
	if(!@$db_link) { include '../script/config_database.php'; }
		$book_id = (@$doc1_dtl['id'])?$doc1_dtl['id']:@$_GET['id'];
		echo $book_id;
		if($book_id) {	//ค้นหาจาก database
			echo 'Database';
		} else { //ค้นหาจาก Temp
//			echo 'Temp - '.$_SESSION['USER_ID'].'<BR>';	?>
            	
            	<form method='post' name='form_upload' action='attach_upload.php' target='upload_sector' enctype="multipart/form-data">
            	<table> <tr>
                	<td style='border:none; padding:0px; margin:0px;'>
                        <div style="width:32px; height:32px; background:url(../image/btn_upload.png) 0 0 no-repeat; display:inline-block; overflow:hidden; cursor:pointer;"> 
                            <input type="file" id='attach_file' name='attach_file' style='border:solid 1px #0f0; position: relative; height: 100%; width: auto; opacity:0; -moz-opacity:0;' onchange='upload_temp();'/>
                        </div>
                    </td>
                    <td style='border:none; padding:0px; margin:0px;'>
                    	<input type='hidden' name='user_id' value='<?=$_SESSION['USER_ID'];?>' />
		                <div style='display:inline-block; line-height:32px; font-family:Tahoma; font-size:14px; font-weight:bold; padding-left:10px;'>Upload Files</div>
                    </td>
				</tr></table>
                </form>
				<iframe name='upload_sector' id='upload_sector' style='border:none; height:0px; width:0px;'>
                </iframe>


			<script language='javascript'>
				/* Function upload files*/
					function upload_temp(){
						document.form_upload.submit();
						$('#log_file').val($('#attach_file').val());
					}
			</script>

		<?	}
		
		
		/*
		if($book_id) { $attach_list_ = mysql_query('SELECT * FROM new_attach WHERE id_parent LIKE "'.$book_id.'"'); ?>
        
        
    <input type='button' style='cursor:pointer; padding:5px; padding-left:10px; padding-right:10px; border:solid 1px #777; border-radius:4px;' value='เพิ่มไฟล์แนบ'
        onclick='window.open("../create_document/form_attachfile.php?id=<?=$book_id;?>","","width=500,height=150");' >
    <div id='prc_attach'></div>
    
    <table border='0' cellpadding="0" cellspacing="0" style='min-width:550px; margin-top:5px; border-top:solid 1px #777;'>
        <? if(mysql_num_rows($attach_list_) == 0) { ?>
            <tr><td style='padding:5px; line-height:20px; border:solid 1px #777; border-top:0px; text-align:center; font-weight:bold; color:#666;'>
            ยังไม่มีการเพิ่มข้อมูลในรายการนี้
            </td></tr>
        <? } ?>
    
    
         <? for($attach_list; $attach_list = mysql_fetch_array($attach_list_);) { ?>
            <tr><td style='padding:5px; line-height:20px; border:solid 1px #777; border-top:0px;'>
            <div style='float:left;'>
                <a href='../file_attach/data/<?=$attach_list['name'];?>' target="_blank"><div style='display:inline-block; font-weight:bold;'><?=$attach_list['title'];?></div></a>
                <div style='display:inline-block; font-size:10px; color:#666;'><?=$attach_list['comment'];?></div>
            </div>
            <div style='float:right;'>
                <input type='button' style='cursor:pointer; font-size:10px; padding:3px 10px; ' value='Delete' onclick='$("#prc_attach").load("prc_attachfile.php?type=DELETE&id_attach=<?=$attach_list['id'];?>&id=<?=$book_id;?>");'/>
            </div>
            </td></tr>
         <? } ?>
     </table>
     
     
     
<?	} else { $attach_list_ = mysql_query('SELECT * FROM new_attach WHERE id_parent LIKE "'.$book_id.'"'); 
		$directory = '../file_attach/temp/';
		$dir_list_ = scandir($directory);
		$j=0;
		for($i=2; $dir_list_[$i]; $i++) {
			$name_exp = explode('_', $dir_list_[$i]);
			if($name_exp[0] == $_SESSION['USER_ID']) 
			{	$attach_list[$j] = $dir_list_[$i];
				$j++;
			}
		}
		
		
//		print_r($attach_list);
?>
    <input type='button' style='cursor:pointer; padding:5px; padding-left:10px; padding-right:10px; border:solid 1px #777; border-radius:4px;' value='เพิ่มไฟล์แนบ'
        onclick='window.open("../create_document/form_attachfile.php","","width=500,height=150");' >
    <div id='prc_attach'></div>
    
    <table border='0' cellpadding="0" cellspacing="0" style='min-width:550px; margin-top:5px; border-top:solid 1px #777;'>
        <? if(count($attach_list) == 0) { ?>
            <tr><td style='padding:5px; line-height:20px; border:solid 1px #777; border-top:0px; text-align:center; font-weight:bold; color:#666;'>
            ยังไม่มีการเพิ่มข้อมูลในรายการนี้
            </td></tr>
        <? } ?>
    
    
         <? for($i=0; $attach_list[$i]; $i++) { 
		 ?>
            <tr><td style='padding:5px; line-height:20px; border:solid 1px #777; border-top:0px;'>
            <div style='float:left;'>
                <a href='../file_attach/temp/<?=$attach_list[$i];?>' target="_blank"><div style='display:inline-block; font-weight:bold;'><?=$_SESSION['file_attach'][$attach_list[$i]][0];?></div></a>
                <div style='display:inline-block; font-size:10px; color:#666;'><?=$_SESSION['file_attach'][$attach_list[$i]][1];?></div>
            </div>
            <div style='float:right;'>
                <input type='button' style='cursor:pointer; font-size:10px; padding:3px 10px; ' value='Delete' onclick='$("#prc_attach").load("prc_attachfile.php?type=DELETE&name=<?=$attach_list[$i];?>");'/>
            </div>
            </td></tr>
         <? } ?>
     </table>



<? }// echo '<BR>'.date('U').'('.$book_id.')'.'<BR>'; 
/**/
?>
