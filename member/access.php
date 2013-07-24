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
<? if($ugroup_dtl['data_acc_view'] != 'on') { header("Location:../home/"); }

$_GET['page'] = (!empty($_GET['page']))?$_GET['page']:1;
$string_query = "SELECT * FROM dex2_tbluser_group";
	if(!empty($_GET['search_access'])) { $string_query .= ' WHERE GroupName LIKE "%'.$_GET['search_access'].'%"'; }


$set_data = new f_page;
	$set_data->set_amount(20);
	$set_data->set_page($_GET['page']);
	$set_data->set_query($string_query);
	$data_set = $set_data->get_data();
?>
    
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>สิทธิ์การใช้งาน</div>
    <div style='border:dotted 1px #CCC; background:#f3ece4; padding:10px; line-height:35px; height:35px;'>
        <form name='form_search' method="GET">
        	<input type='hidden' name='page' value='<?=$_GET['page'];?>'>
            <div style='float:left;'>
                ชื่อสิทธิ์การใช้งาน <input type='text' name='search_access' style='width:200px;'>
            </div>
	        <div style='float:left; margin-left:10px;'>
                <img src='../image/btn_search.png' onclick='submit();' style='cursor:pointer;'>
			</div>
        </form>
    </div>
</td></tr>
<tr>
	<td style='height:60px;'><? $set_data->get_pagination(); ?></td>
	<td style='text-align:right;'><? if($ugroup_dtl['data_acc_add'] == 'on') { ?><input type='button' class='btn_style_01' value='+ เพิ่มข้อมูล' onclick='window.location="form_access.php?tform=ADD"'><? } ?></td>
</tr>
<tr><td colspan="2">


	<table style='width:100%; text-align:left;' class='tbl_style_01' cellpadding="0" cellspacing="0">
    	<tr>
        	<th style='width:50px;'>ลำดับ</th>
        	<th>สิทธิ์การใช้งาน</th>
        	<th style='width:120px;'>ความสามารถ</th>
        	<? if($ugroup_dtl['data_acc_edit'] == 'on' || $ugroup_dtl['data_acc_delete'] == 'on') { ?><th style='width:80px;'>จัดการ</th><? } ?>
        </tr>
        
        <?	if(mysql_num_rows($data_set) == 0) { ?>
	        <tr> <td style='text-align:center; color:#333;' colspan="4">ยังไม่มีข้อมูลในรายการนี้</td> </tr>
		<? }	?>
		<?	$j=0; for($i=($set_data->get_no()+1); $user_list_ = mysql_fetch_array($data_set); $i++) {  $j = ($j>1)?0:1; ?>
                    <tr class='<? if($j==0) { ?>mark<? }?>'>
                        <td><?=$i;?></td>
                        <td><?=@$user_list_['GroupName'].' '.@$user_list_['LastName'];?></td>
                        <td>หน่วยงาน</td>
                        <? if($ugroup_dtl['data_acc_edit'] == 'on' || $ugroup_dtl['data_acc_delete'] == 'on') { ?><td>
                        	<? if($ugroup_dtl['data_acc_edit'] == 'on') { ?><img src='../image/btn_edit.png' style='cursor:pointer;' title='แก้ไขรายการนี้' onclick='window.location="form_access.php?tform=EDIT&id=<?=$user_list_['UserGroupId'];?>"'><? } ?>
                        	<? if($ugroup_dtl['data_acc_delete'] == 'on') { ?><img src='../image/btn_delete.png' style='cursor:pointer;' title='ลบรายการนี้' onclick='window.location="process_access.php?tform=DELETE&id=<?=$user_list_['UserGroupId'];?>"'><? } ?>
                        </td><? } ?>
                    </tr>
        <? 	$j++; } ?>
        
    </table>


</td></tr>
</table>
	<!-- InstanceEndEditable --></td>
</tr>
</table>
</body>
<!-- InstanceEnd --></html>