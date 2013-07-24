<?	include '../script/config_database.php'; 
		$user_dtl = mysql_fetch_array(mysql_query('SELECT * FROM user WHERE username LIKE "'.$_GET['id'].'" LIMIT 0, 1'));
?>
<style type='text/css'>
.form_style_user_detail {
	line-height:20px;
	width:100%;
	text-align:left;
}

.form_style_user_detail td, .form_style_user_detail th {
	padding:5px;
}
</style>
<!-- Body -->
<? $org_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_tblorganize WHERE OrganizeId LIKE "'.$user_dtl['OrganizeId'].'" LIMIT 0, 1')); ?>
<table border='0' class='form_style_user_detail' cellpadding="0" cellspacing="0">
	<tr> <th style='background:#555; color:#FFF; border-radius:3px; padding-left:10px;' colspan="2"> ข้อมูลผู้ใช้งาน :: </th> </tr>
</table>
<BR />
<table border='0' class='form_style_user_detail' cellpadding="0" cellspacing="0">
    <tr>
    	<th style='text-align:right; width:80px;'>Username : </th>
        <td><?=$user_dtl['username'];?></td>
	</tr>
    <tr>
    	<th style='text-align:right;'>Password : </th>
        <td>******</td>
	</tr>
    <tr>
    	<th style='text-align:right;'>Name : </th>
        <td><?=$user_dtl['names'];?></td>
	</tr>
    <tr>
    	<th style='text-align:right;'>Birthdate : </th>
        <td> <? /* if($user_dtl['Birthdate'] != '0000-00-00') { ?> <? $set_date = new f_date; echo $set_date->date_th_l(strtotime($user_dtl['Birthdate']));?> <? } else { ?>ไม่มีข้อมูล<? } */ ?> - </td>
	</tr>
    <tr>
    	<th style='text-align:right;'>E-Mail : </th>
        <td> <? /* if(!$user_dtl['Email']) { ?>ไม่มีข้อมูล<? } else { echo $user_dtl['Email']; } */ ?> - </td>
	</tr>
    <tr>
    	<th style='text-align:right;'>Organize : </th>
        <td>
			<? /* if(!$org_dtl['Organize']) { ?>ไม่มีข้อมูล<? } else { echo $org_dtl['Organize']; }*/?> - 
        </td>
	</tr>
    <tr>
    	<td style='text-align:right;' colspan="2"><input type='button' class='btn_style_01' value='ย้อนกลับ' onclick='set_boxdetail("off");'/></td>
	</tr>
</table>
<!-- End Body -->