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
if($ugroup_dtl['data_user_view'] != 'on') { ?>
	<script language="javascript">
		window.location='../home/';
	</script>
<? } ?>

<?

$user_list_ = 'SELECT * FROM user';

$user_list_ = mysql_query($user_list_);

$_GET['search_name'] = (!empty($_GET['search_name']))?$_GET['search_name']:'';
$_GET['search_idcard'] = (!empty($_GET['search_idcard']))?$_GET['search_idcard']:'';
$_GET['page'] = (!empty($_GET['page']))?$_GET['page']:'';

$string_query = " select * from user as us JOIN dex2_new_user_access as ua ON us.username=ua.`USER` WHERE  1=1 ";
	$string_query .= ($_GET['search_name'])?"AND us.names LIKE '%".$_GET['search_name']."%'":'';

$_GET['page'] = ($_GET['page'])?$_GET['page']:1;
$set_data = new f_page;
	$set_data->set_amount(15);
	$set_data->set_page($_GET['page']);
	$set_data->set_query($string_query);
	$set_data->set_paramiter("&search_name=".$_GET['search_name']);
	$set_data->set_paramiter("&search_idcard=".$_GET['search_idcard']);
	$data_set = $set_data->get_data();
?>
    
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ผู้ใช้งานในระบบสารบรรณ</div>
    <div style='border:dotted 1px #CCC; background:#f3ece4; padding:10px; line-height:35px; height:35px;'>
        <form name='form_search' method="GET">
            <div style='float:left;'>
                <input type='hidden' name='page'>
                ชื่อ - สกุล <input type='text' name='search_name' style='width:200px;' value='<?=$_GET['search_name'];?>'>
                เลขที่บัตรประชาชน <input type='text' name='search_idcard' style='width:150px;' value='<?=$_GET['search_idcard'];?>'> 
                <select style='display:none;'><option>-- ทุกระยะ --</option><? for($i=1; $i<4; $i++) { ?><option><?=$i;?></option><? } ?></select>
            </div>
            <div style='float:left; margin-left:10px;'>
                <img src='../image/btn_search.png' onclick='submit();' style='cursor:pointer;'>
                <input type='submit' style='width:0xp; height:0px; border:none;'>
            </div>
		</form>
    </div>
</td></tr>
<tr>
	<td style='height:60px;'> <? $set_data->get_pagination(); ?> </td>
	<td ></td>
</tr>
<tr><td colspan="2">


	<table style='width:100%; text-align:left;' class='tbl_style_01' cellpadding="0" cellspacing="0">
    	<tr>
        	<th style='width:50px;'>ลำดับ</th>
        	<th>ชื่อ - สกุล</th>
        	<th style='width:250px;'>กลุ่มงาน</th>
        	<th style='width:250px;'>สิทธิการใช้งาน</th>
        	<th style='width:120px;'>ข้อมูลติดต่อ</th>
        	<? if($ugroup_dtl['data_user_edit'] == 'on' || $ugroup_dtl['data_user_delete'] == 'on') { ?><th style='width:220px;'>จัดการ</th><? } ?>
        </tr>
        
			<?	
				$j=0; for($i=($set_data->get_no()+1); $user_list_ = mysql_fetch_array($data_set); $i++) { $j = ($j>1)?0:1;
					$org_dtl = mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE dep_id LIKE '".$user_list_['dep_id']."'"));
					$acc_dtl = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_access WHERE UserGroupID LIKE '".$user_list_['id_access']."'"));
            ?>
                    <tr class='<? if($j==0) { ?>mark<? }?>'>
                        <td><?=$i;?></td>
                        <td> <?=$user_list_['names'];?> </td><!-- ชื่อ - นามสกุล-->
                        <td> <?=($org_dtl)?$org_dtl['departments']:"<div style='color:#AAA;'>ไม่มีข้อมูล</div>";?> </td>	<!-- กลุ่มงาน -->
                        <td>
							<? /* if(!$acc_dtl['GroupName']) { ?><div style='color:#AAA;'>ไม่มีข้อมูล</div><? } else { echo $acc_dtl['GroupName']; } */ ?>
                            <?=($acc_dtl)?$acc_dtl['GroupName']:"<div style='color:#AAA;'>ไม่มีข้อมูล</div>";?>
                        </td>	<!-- สิทธิการใช้งาน -->
                        
                        <td>
                        	<img src='../image/btn_mail.png' style='cursor:none;' title='<?=(!empty($user_list_['Email']))?$user_list_['Email']:'ไม่มีข้อมูล E-Mail';?>'>
                            
                        	<img src='../image/btn_mobile.png' style='cursor:none;' title='ไม่มีข้อมูล เบอร์โทรติดต่อ'>
                        </td>
                        <?
						if($ugroup_dtl['data_user_edit'] == 'on' || $ugroup_dtl['data_user_delete'] == 'on') { ?><td>
                        	<? if($ugroup_dtl['data_user_edit'] == 'on') { ?><img src='../image/btn_edit.png' style='cursor:pointer;' title='แก้ไขรายการนี้' onclick='window.location="userdoc_form.php?type=EDIT&id=<?=$user_list_['id'];?>"'><? } ?>
                            <input type='button' class='btn_style_01' style='background:#E8B8B7; color:#300; border:solid 1px #600;' value='ยกเลิกสิทธิในระบบ' onclick='if(confirm("ต้องการยกเลิกสิทธิผู้ใช้งานนี้?")) { window.location="<?='process_user.php?page='.$_GET['page'].'&type=REGIST&status=OUT&id='.$user_list_['username'];?>"; }'>
                            
						</td><? } ?>
                    </tr>
        <? $j++; }  ?>
        
    </table>
</td></tr>
</table>

	<!-- InstanceEndEditable --></td>
</tr>
</table>
</body>
<!-- InstanceEnd --></html>