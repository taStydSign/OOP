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
<?	$dex2_user_group  = mysql_query("SELECT * FROM dex2_new_access_layer_detail");	


		$_GET['tform'] = ($_GET['tform'])?$_GET['tform']:'ADD';
		if($_GET['tform'] == 'ADD') { $str_form = 'เพิ่ม'; }
		else if($_GET['tform'] == 'EDIT') {
			$str_form = 'แก้ไข';
			$user_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_tbluser_group WHERE UserGroupId LIKE "'.$_GET['id'].'" LIMIT 0, 1'));
			if(@$user_dtl['Birthdate'] != '0000-00-00') { $birth_value = strtotime(@$user_dtl['Birthdate']); }
		}
		
		if($_GET['tform'] == 'EDIT' && !$_GET['id']) { ?>
			<div>การเข้าถึงแบบฟอร์มไม่ถูกต้องกรุณาตรวจสอบ</div>
		<? } ?>


<table style='width:100%; padding:5px;'>
<tr><td>
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>สิทธิ์การใช้งาน (<?=$str_form?>)</div>
</td></tr>
<tr><td style='height:60px;'>
	<form method='post' action='process_access.php'>
    <input type='hidden' name='tform' value='<?=@$_GET["tform"];?>'>
    <input type='hidden' name='id' value='<?=@$_GET["id"];?>'>
	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
    
		<tr>
        	<th style='width:450px;'>ชื่อสิทธิการใช้งาน * : </th>
            <td><input type='text' name='access' style='width:280px;' value='<?=@$user_dtl['GroupName'];?>'></td>
        </tr>
		<tr>
        	<th>ระดับ * : </th>
            <td><input type='text' name='username' style='width:30px;'></td>
        </tr>
		<tr>
        	<th>การเข้าถึงข้อมูล : </th>
            <td>
                <div style='display:inline-block; margin-right:20px;'><input type='radio' name='access_data' value='all' <? if(@$user_dtl['access'] == 'all') { ?>checked<? }?>> ทั้งหมด	</div>
                <div style='display:inline-block; margin-right:20px;'><input type='radio' name='access_data' value='inst' <? if(@$user_dtl['access'] == 'inst') { ?>checked<? }?>> เฉพาะหน่วยงาน</div>
                <div style='display:inline-block; margin-right:20px;'><input type='radio' name='access_data' value='self' <? if(@$user_dtl['access'] == 'self') { ?>checked<? }?>> เฉพาะตนเอง</div>
            </td>
        </tr>
		<tr>
        	<th>สิทธิการใช้งาน : </th>
            <td>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_[V]' <? if(@$user_dtl['data_acc_view']=='on') { ?>checked<? } ?>> ดู	</div>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_[A]' <? if(@$user_dtl['data_acc_add']=='on') { ?>checked<? } ?>> เพิ่ม</div>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_[E]' <? if(@$user_dtl['data_acc_edit']=='on') { ?>checked<? } ?>> แก้ไข</div>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_[D]' <? if(@$user_dtl['data_acc_delete']=='on') { ?>checked<? } ?>> ลบ</div>
            </td>
        </tr>
		<tr>
        	<th>ผู้ใช้งาน : </th>
            <td>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='user_[V]' <? if(@$user_dtl['data_user_view']=='on') { ?>checked<? } ?>> ดู	</div>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='user_[A]' <? if(@$user_dtl['data_user_add']=='on') { ?>checked<? } ?>> เพิ่ม</div>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='user_[E]' <? if(@$user_dtl['data_user_edit']=='on') { ?>checked<? } ?>> แก้ไข</div>
                <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='user_[D]' <? if(@$user_dtl['data_user_delete']=='on') { ?>checked<? } ?>> ลบ</div>
            </td>
        </tr>
		<tr>
        	<th colspan="2" style='color:#000; font-weight:bold; width:240px;'>ขั้นตอนเอกสาร</th>
        </tr>
				<?	
				for($i=0; $dex2_user_group_ = mysql_fetch_array($dex2_user_group); $i++) { 
						$acc_layer = @mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_access_layer WHERE id_access LIKE '".@$_GET['id']."' AND id_access_ldetail LIKE '".@$dex2_user_group_['id']."' LIMIT 0, 1"));
				?>
                    <tr>
                        <th><?=$dex2_user_group_['name'];?> : </th>
                        <td>
                        	<div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_layer[<?=$dex2_user_group_['id'];?>][V]' <? if($acc_layer['status_view'] == 'on') { ?>checked<? } ?>> ดู	</div>
                            <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_layer[<?=$dex2_user_group_['id'];?>][A]' <? if($acc_layer['status_add'] == 'on') { ?>checked<? } ?>> เพิ่ม</div>
                            <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_layer[<?=$dex2_user_group_['id'];?>][E]' <? if($acc_layer['status_edit'] == 'on') { ?>checked<? } ?>> แก้ไข</div>
                            <div style='display:inline-block; margin-right:20px;'><input type='checkbox' name='acc_layer[<?=$dex2_user_group_['id'];?>][D]' <? if($acc_layer['status_delete'] == 'on') { ?>checked<? } ?>> ลบ</div>
                        </td>
                    </tr>
                <? } ?>
    	<tr>
    	  <td>&nbsp;</td>
			<td>
          		<input type='submit' value='บันทึก' class='btn_style_01'>
				<input type='button' value='ยกเลิก' class='btn_style_01' onclick='history.back(1);'>
			</td>
  	  </tr>
    </table>
    </form>
</td></tr>
</table>

	<!-- InstanceEndEditable --></td>
</tr>
</table>
</body>
<!-- InstanceEnd --></html>