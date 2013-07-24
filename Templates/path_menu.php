<?
$user_acc = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_user_access WHERE USER LIKE '".$_SESSION['USER_ID']."'"));
$ugroup_dtl = mysql_fetch_array(mysql_query("SELECT * FROM dex2_tbluser_group WHERE UserGroupId LIKE '".$user_acc['id_access']."' LIMIT 0, 1")); //Older data

	//สร้างหนังสือ
	$cdocument = mysql_fetch_array(mysql_query("SELECT status_add FROM dex2_new_access_layer WHERE id_access LIKE '".$user_acc['id_access']."' AND id_access_ldetail LIKE '1' LIMIT 0, 1"));
	
?>
<li class='menu_style'>
    <ul>
        <? if($cdocument['status_add'] == 'on') { ?><li onclick='window.location="../create_document/"'>สร้างหนังสือ</li><? } ?>
        <li onclick='window.location="../home/"'>ขั้นตอนเอกสาร</li>
        <? if($ugroup_dtl['data_acc_view'] == 'on' || $ugroup_dtl['data_user_view'] == 'on') { ?><li>ผู้ใช้งาน
            <ul>
                <? if($ugroup_dtl['data_acc_view'] == 'on') { ?><li onclick='menu_link("../member/access.php");'>สิทธิ์การใช้งาน</li><? } ?>
                <? if($ugroup_dtl['data_user_view'] == 'on') { ?><li onclick='menu_link("../member/user_document.php");'>ผู้ใช้งาน ระบบสารบรรณ<? } ?>
                <? if($ugroup_dtl['data_user_view'] == 'on') { ?><li onclick='menu_link("../member/user.php");'>ผู้ใช้งาน ทั้งหมด<? } ?>
            </ul>
        </li><? } ?>
    </ul>
</li>
<script language="javascript">
function menu_link(urlLink) { window.location = urlLink; }
</script>
<!-- Path_menu.php:Last update 2013-07-12 13:17 -->