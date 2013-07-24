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
<?	$_GET['tform'] = ($_GET['tform'])?$_GET['tform']:'ADD';

		$acclayer_list = mysql_query("SELECT * FROM dex2_user_group");
		$province_list = mysql_query("SELECT * FROM dex2_provinces");

		if($_GET['tform'] == 'ADD') { $str_form = 'เพิ่ม'; }
		else if($_GET['tform'] == 'EDIT') {
			$str_form = 'แก้ไข';
			$user_dtl = mysql_fetch_array(mysql_query('SELECT * FROM user WHERE UserId LIKE "'.$_GET['id'].'" LIMIT 0, 1'));
			if($user_dtl['Birthdate'] != '0000-00-00') { $birth_value = strtotime($user_dtl['Birthdate']); }
		}
		
		if($_GET['tform'] == 'EDIT' && !$_GET['id']) { ?>
			<div>การเข้าถึงแบบฟอร์มไม่ถูกต้องกรุณาตรวจสอบ</div>
		<? } ?>
    
<table style='width:100%; padding:5px;'>
<tr><td>
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ผู้ใช้งาน (<?=$str_form?>)</div>
</td></tr>
<tr><td style='height:60px;'>
	<form method='post' action='process_user.php'>
    <input type='hidden' name='tform' value='<?=$_GET["tform"];?>'>
    <input type='hidden' name='id' value='<?=$_GET["id"];?>'>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
    
	<? if($_GET['tform'] == 'ADD') { ?>
		<tr>
        	<th style='width:240px;'>Username : </th>
            <td><input type='text' name='username'></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>Password : </th>
            <td><input type='password' name='password'></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>Re-Password : </th>
            <td><input type='password' name='repassword'></td>
        </tr>
	<? } else if($_GET['tform'] == 'EDIT') { ?>
		<tr>
        	<th style='width:240px;'>Username : </th>
            <td><?=$user_dtl['UserName'];?></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>Password : </th>
            <td>**********</td>
        </tr>
	<? } ?>
    
    	<tr>
        	<th style='width:240px;'>ชื่อจริง *</th>
            <td><input name="fname" type='text' id="fname" style='width:350px;' value='<?=$user_dtl['FirstName'];?>'></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>นามสกุล</th>
            <td><input name="lname" type='text' id="lname" style='width:350px;' value='<?=$user_dtl['LastName'];?>'></td>
        </tr>
    	<tr>
    	  <th>วัน/เดือน/ปีเกิด *</th>
			<td>
          		วัน <input name="birth_day" type='text' id="birth_day" style='width:15px;' maxlength='2'>
                เดือน <select name="birth_month" id="birth_month"><option value=''>- - Month - -</option><? for($i=1; $i<13; $i++) { ?><option value='<?=$i;?>'><?=$month_string[$i];?></option><? } ?></select>
                ปี <input name="birth_year" type='text' id="birth_year" style='width:30px;' maxlength='4'> * กรุณาระบุเป็นปี พ.ศ.
			</td>
  	  </tr>
    	<tr>
        	<th style='width:240px;'>E-Mail</th>
            <td><input name="email" type='text' style='width:350px;' value='<?=$user_dtl['Email'];?>'></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>เบอร์โทรติดต่อ</th>
            <td><input name="mobile" type='text' style='width:350px;' value=''></td>
        </tr>
    	<tr>
    	  <th>เลขที่บัตรประชาชน</th>
    	  <td><input name="idcard" type='text' id="idcard" style='width:100px;' value='<?=$user_dtl['Idcard'];?>' maxlength='13'></td>
  	  </tr>
    	<tr>
    	  <th>หน่วยงาน *</th>
    	  <td><select name='agencies' id='agencies'><option value=''> - - กรุณาเลือกหน่วยงาน - - </option><? for($i=0; $acclayer_list_ = mysql_fetch_array($acclayer_list); ) { ?><option value='<?=$acclayer_list_['UserGroupId'];?>'><?=$acclayer_list_['GroupName'];?></option><? } ?></select></td>
  	  </tr>
    	<tr>
    	  <th>จังหวัด *</th>
    	  <td><select name='province' id='province'><option value=''> - - กรุณาเลือกจังหวัด - - </option><? for($i=0; $province_list_ = mysql_fetch_array($province_list);) { ?><option><?=$province_list_['name'];?></option><? } ?></select></td>
  	  </tr>
    	<tr>
    	  <th>อำเภอ/เขต *</th>
    	  <td><select><option> - - - - - - </option></select></td>
  	  </tr>
    	<tr>
    	  <th>ตำบล/แขวง *</th>
    	  <td><select><option>กรุณาเลือกตำบล/แขวง</option></select></td>
  	  </tr>
    	<tr>
    	  <th>รหัสไปรษณีย์ *</th>
    	  <td><input name="zipcode" type='text' id="zipcode" style='width:40px;' maxlength='5' value='<?=$user_dtl['zipcode'];?>'></td>
  	  </tr>
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

<script language="javascript">
	<? if($birth_value) { ?>
				$('#birth_day').val(<?=date('d', $birth_value);?>);
				$('#birth_month').val(<?=date('m', $birth_value);?>);
				$('#birth_year').val(<?=(date('Y', $birth_value)+543);?>);
	<? } ?>
				$('#agencies').val(<?=$user_dtl['UserGroupId'];?>);
				$('#province').val('<?=$user_dtl['province'];?>');
</script>

	<!-- InstanceEndEditable --></td>
</tr>
</table>
</body>
<!-- InstanceEnd --></html>