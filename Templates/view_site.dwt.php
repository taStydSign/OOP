<? session_start(); ?>
<!doctype html>
<html lang='th'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../script/css/template_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src='../script/javascript/jquery_main.js'></script>
<? header("Content-Type: text/html; charset=utf-8"); ?>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
	<td style=''><!-- TemplateBeginEditable name="txt_content" --><!-- TemplateEndEditable --></td>
</tr>
</table>
</body>
</html>