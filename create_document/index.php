<? session_start(); ?>
<!doctype html>
<html lang='th'><!-- InstanceBegin template="/Templates/view_site.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../script/css/template_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src='../script/javascript/jquery_main.js'></script>
<? header("Content-Type: text/html; charset=utf-8"); ?>
<!-- InstanceBeginEditable name="head" -->
    <!-- InstanceEndEditable -->
<title>ระบบสารบรรณอิเล็กทรอนิกส์ (หนังสือภายนอก) - สำนักงานส่งเสริมสวัสดิภาพและพิทักษ์เด็ก เยาวชน ผู้ด้อยโอกาส และ ผู้สูงอายุ (สท.)</title>
</head>
<body>
<? include '../script/config_database.php'; ?>
<!-- Check User -->
<?
	if($_SESSION['USER_ID'])
	{
		$qry_chk_ses = "SELECT * FROM user WHERE username LIKE '".$_SESSION['USER_ID']."'";
		$chk_ses = mysql_query($qry_chk_ses);

		$chk_acc = mysql_query("SELECT * FROM dex2_new_user_access WHERE USER LIKE '".$_SESSION['USER_ID']."'");

		if(mysql_num_rows($chk_ses) == '0' || mysql_num_rows($chk_acc) == '0') 
			{ 
				unset($_SESSION['USER_ID']);

				?><script language="javascript"><?
				if(mysql_num_rows($chk_ses) == '0') {
					?>alert("Username หรือ Password ไม่ถูกต้อง");<?
				} else if(mysql_num_rows($chk_acc) == '0') {
					?>alert("Username นี้ไม่ได้รับสิทธิให้เข้าใช้งาน");<?
				}
				?>window.location = '../member/form_login.php'; </script><?
			}
		else
		{
			$chk_user = mysql_fetch_array(mysql_query("SELECT username, password, names, dep_id FROM user WHERE username LIKE '".$_SESSION['USER_ID']."'"));
			$chk_acc = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_user_access WHERE USER LIKE '".$_SESSION['USER_ID']."'"));
			
			$org_dtl = mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE dep_id LIKE '".$chk_user['dep_id']."' LIMIT 0, 1"));
			$group_dtl = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_access WHERE UserGroupId LIKE '".$chk_acc['id_access']."' LIMIT 0, 1"));
		}
	} else {
		header("Location:../member/form_login.php");
	}

?>
<!-- Check User -->
<?	$date_value = new f_date; 
		$org_dtl['Organize'] = (!empty($org_dtl['Organize']))?$org_dtl['Organize']:'-';
?>

<table style="width:100%;" cellpadding="0" cellspacing="0">
<tr>
	<td style='background-image:url(../image/site_header_bg.jpg); height:120px;'>
    	<div style='display:inline-block; height:120px; width:100%; background-image:url(../image/site_header.jpg); background-repeat:no-repeat; text-align:right;'>
            <table style='display:inline-block; background:#fcebb0; line-height:15px; padding:4px; border:dashed 1px #ddce9a; margin-top:10px; margin-right:20px; text-align:left;'>
                <tr><td>เข้าใช้งานโดย : <?=$chk_user['names'];?> [<?=$org_dtl['departments'];?>] [<?=$group_dtl['GroupName'];?>]</td></tr>
                <tr><td>วันนี้ : <?=$date_value->date_th_l();?></td></tr>
                <tr><td>ใช้งานครั้งล่าสุด : <?=$date_value->date_th_l(strtotime(@$chk_useracc['update']));?> เวลา <?=date('H:i', strtotime(@$chk_useracc['update']));?> น.</td></tr>
                <tr><td><img src='../image/btn_signout.png' style='cursor:pointer;' onclick='window.location="../member/process.php?ptype=SIGNOUT"'></td></tr>
            </table>
		</div>
    </td>
</tr>
<tr>
	<td style=' line-height:34px; height:34px; background:#223344; color:#FFF; font-weight:bold; '><? include_once '../Templates/path_menu.php'; ?></td>
</tr>
<tr>
	<td style=''><!-- InstanceBeginEditable name="txt_content" -->
<?

	$_GET['tform'] = (empty($_GET['tform']) == 1)?'':$_GET['tform'];
	$_GET['id'] = (empty($_GET['id']) == 1)?'':$_GET['id'];
?>
<? if($cdocument['status_add'] != 'on') { ?>
	<script language="javascript"> window.location='../home/'; </script>
<? } ?>

<?	$_GET['tform'] = ($_GET['tform'])?$_GET['tform']:'ADD'; 

		if($_GET['tform'] != 'VIEW' && $_GET['id']) {
				$doc1_dtl = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_01 WHERE id LIKE '".$_GET['id']."' LIMIT 0, 1"));
		}
?>




<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>สร้างหนังสือ</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td colspan="2">


	
<?

	$form_type = (empty($form_type) == 1)?'':$form_type; //Mark

	 if($form_type != 'VIEW') { ?> <form method='post' action='process.php'><? } ?>
		<input type='hidden' name='tform' value='<?=$_GET["tform"];?>'>
		<input type='hidden' name='id' value='<?=$_GET["id"];?>'>
	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>

		<tr>
        	<th style='width:240px;'>เลขที่หนังสือภายนอก</th>
            <td >
                    <div style='display:inline-block; float:left; height:25px;'><input type='text' name='book_no' style='width:200px;' value='<?=@$doc1_dtl['book_no'];?>'></div>&nbsp;
                    <div style='display:inline-block; height:25px;'>
	            	<? $odata_bookdate = (!@$doc1_dtl['book_date'] || $doc1_dtl['book_date'] == '0000-00-00 00:00:00')?'':date('Y-m-d H:i:s', strtotime(@$doc1_dtl['book_date'])); ?>
					<? set_input_date('book_date', $odata_bookdate); ?></div>
			</td>
        </tr>
    	<tr>
        	<th style='width:240px;'>สท. รับ-ส่งที่ *</th>
            <td><input name="send" type='text' style='width:200px;' value='<?=@$doc1_dtl['send'];?>'></td>
        </tr>
    	<tr>
    	  <th>ลงวันที่ *</th>
			<td>
            	<? $odata_date = (!@$doc1_dtl['date'] || $doc1_dtl['date'] == '0000-00-00 00:00:00')?'':date('Y-m-d H:i:s', strtotime(@$doc1_dtl['date'])); ?>
          		<? set_input_date('date', $odata_date); ?>
			</td>
  	  </tr>
    	<tr>
        	<th style='width:240px;'>ชื่อเรื่อง *</th>
            <td><input name="title" type='text' style='width:350px;' value='<?=@$doc1_dtl['title'];?>'></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>เรียน *</th>
            <td><input name="to" type='text' style='width:350px;' value='<?=@$doc1_dtl['to'];?>'></td>
        </tr>
	<?	//Clear temp
/*
   		$directory = '../file_attach/temp/';
		$dir_list_ = scandir($directory);
		$j=0;
		for($i=2; $dir_list_[$i]; $i++) {
			$name_exp = explode('_', $dir_list_[$i]);
			if($name_exp[0] == $_SESSION['USER_ID']) 
			{	$attach_list[$j] = $dir_list_[$i];
				unlink('../file_attach/temp/'.$attach_list[$j]);
				$j++;
			}
		}	if($j != 0) { ?><script language="javascript">setTimeout(function(){ window.location=''; }, 500);</script><? }
		/**/
	?>
	<tr>
		<th style='width:250px;'>สิ่งที่ส่งมาด้วย</th>
		<td id='sector_attach'>
        	<iframe src='form_attach.php' style="width:200px; height:50px; border:none;" scrolling="no">
            </iframe>
            <? include 'file_list.php'; ?>
		</td>
	</tr>
        
        
    	<tr>
    	  <th valign="top">รายละเอียด *</th>
-    	  <td><textarea style='width:800px; height:120px;' name='detail'><?=@$doc1_dtl['detail'];?></textarea></td>
  	  </tr>
		<tr>
            <th>รับจาก</th>
            <td><input name="from" type='text' style='width:350px;' value='<?=@$doc1_dtl['from'];?>'></td>
		</tr>
    	<tr>
            <th>ความเร่งด่วน</th>
            <td>
                <input name="haste" value="ปกติ" type="radio" <? if(@$doc1_dtl['haste'] == 'ปกติ' || !@$doc1_dtl['haste']) { ?>checked<? } ?>> ปกติ
                <input name="haste" value="ด่วน" type="radio" <? if(@$doc1_dtl['haste'] == 'ด่วน') { ?>checked<? } ?>> ด่วน
                <input name="haste" value="ด่วนมาก" type="radio" <? if(@$doc1_dtl['haste'] == 'ด่วนมาก') { ?>checked<? } ?>> ด่วนมาก
                <input name="haste" value="ด่วนที่สุด" type="radio" <? if(@$doc1_dtl['haste'] == 'ด่วนที่สุด') { ?>checked<? } ?>> ด่วนที่สุด
            </td>
		</tr>
		<tr>
            <th>ความลับ</th>
            <td>
                <input name="secrecy" value="ปกติ" type="radio"  <? if(@$doc1_dtl['secrecy'] == 'ปกติ' || !@$doc1_dtl['secrecy']) { ?>checked<? } ?>> ปกติ
                <input name="secrecy" value="ลับ" type="radio"  <? if(@$doc1_dtl['secrecy'] == 'ลับ') { ?>checked<? } ?>> ลับ
            </td>
		</tr>
    	<tr>
    	  <th valign="top">หมายเหตุ</th>
    	  <td><textarea style='width:400px; height:60px;' name='comment'><?=@$doc1_dtl['comment'];?></textarea></td>
  	  </tr>
      <? if($_GET['tform'] == 'EDIT') { ?>
    	<tr>
    	  <th>วันที่</th>
    	  <td>
          	บันทึกล่าสุด : <?=@$doc1_dtl['date_save'];?>
            <? if(@$doc1_dtl['date_send'] != '0000-00-00 00:00:00') { ?> ส่งต่อ : <?=@$doc1_dtl['date_send'];?> <? } ?>
          </td>
  	  </tr>
      <? } ?>
    	<tr>
    	  <td>&nbsp;</td>
			<td>
          		<? if($form_type != 'VIEW') { ?> <input type='submit' value='บันทึก' class='btn_style_01'> <? } ?>
				<input type='button' value='ยกเลิก' class='btn_style_01' onclick='history.back(1);'>
                <? if((@$doc1_dtl['index_control'] == 1 || !@$doc1_dtl['index_control']) && $form_type != 'VIEW') { ?>
                <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on'> ส่งไปยังขั้นตอนถัดไป
                <? } ?>
			</td>
  	  </tr>
    </table>
<? if($form_type != 'VIEW') { ?> </form> <? } ?>


</td></tr>
</table>
<?	$book_date_val = strtotime(@$doc1_dtl['book_date']);
		$date_val = strtotime(@$doc1_dtl['date']);		?>
<script language="javascript">
$(function(){
	load_attach_list('<?=@$doc1_dtl['id'];?>');
});

function load_attach_list(id) {
	urlLink = 'attach_list.php';
	urlLink += '?id='+id;
	//	alert(urlLink);
	$('#attach_list').load(urlLink);
}
</script>

	<!-- InstanceEndEditable --></td>
</tr>
</table>
</body>
<!-- InstanceEnd --></html>