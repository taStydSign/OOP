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
	$_GET['page'] = (empty($_GET['page']) == 1)?'':$_GET['page'];
	$_GET['search_name'] = (empty($_GET['search_name']) == 1)?'':$_GET['search_name'];
	$_GET['search_date'] = (empty($_GET['search_date']) == 1)?'':$_GET['search_date'];
	
	$string_query = "SELECT id, book_no, book_date, title, index_control, haste, secrecy FROM dex2_new_document_01 ";
	if($_GET['search_name'] || $_GET['search_date']) { $string_query .= ' WHERE'; }
		if($_GET['search_name']) { $string_query .= " book_no LIKE '%".$_GET['search_name']."%' OR title LIKE '%".$_GET['search_name']."%'"; }
		if($_GET['search_name'] && $_GET['search_date']) { $string_query .= ' OR'; }
		if($_GET['search_date']) { $string_query.= " book_date LIKE '".$_GET['search_date']."%' OR date LIKE '".$_GET['search_date']."%'"; }
	
	
	$_GET['page'] = ($_GET['page'])?$_GET['page']:1;
	$set_data = new f_page;
		$set_data->set_amount(5);
		$set_data->set_page($_GET['page']);
		$set_data->set_query($string_query);
		$set_data->set_paramiter("&search_name=".$_GET['search_name']);
		$set_data->set_paramiter("&search_date=".$_GET['search_date']);
		$data_set = $set_data->get_data();
	?>
    
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ขั้นตอนเอกสาร</div>
    <div style='border:dotted 1px #CCC; background:#f3ece4; padding:10px; line-height:35px; height:35px;'>
        <form method="get" name='form_search' id="form_search">

            <table border='0' style='line-height:20px; margin-top:-2px;'>
                <tr>
                	<td>
						<div style='line-height:25px; display:inline-block;'> <input type='hidden' name='page' />
                            เลขที่หนังสือ/ชื่อเรื่อง  : <input type='text' name='search_name' id='search_name' style='width:200px;' value='<?=$_GET['search_name'];?>' />
                            &nbsp;&nbsp;&nbsp;
                            วันที่หนังสือ  :
                      </div>
                    </td>
                	<td style='padding-top:5px;'>
                            <div style='line-height:20px; display:inline-block;'>
                            <? set_input_date('search_date', $_GET['search_date']); ?>
                            
                            </div>
                    </td>
                    <td style='width:100px; text-align:center;'>
                    <input type='button' class='btn_style_01'  style='padding-left:5px; padding-right:5px;' value='Clear Date' onclick='$(&quot;#search_date, #search_name&quot;).val(&quot;&quot;);' />
                    </td>
                    <td>
                        <div style='float:left; margin-left:10px;'>
                            <img src='../image/btn_search.png' onclick='document.form_search.submit();' style='cursor:pointer;' />
                            	
                            <input type='submit' style='width:0px; height:0px; border:none;' />
                      </div>
                    </td>
                </tr>
            </table>
		</form>
    </div>
</td></tr>
<tr><td style='height:60px;'>
<? $set_data->get_pagination(); ?>
</td>
  <td >
  	
  </td>
</tr>
<tr><td colspan="2">

	<table style='width:100%; text-align:left;' class='tbl_style_01' cellpadding="0" cellspacing="0">
    	<tr>
        	<th style='width:50px;'></th>
        	<th style='width:50px;'>ลำดับ</th>
        	<th style='width:200px;'>เลขที่หนังสือ</th>
        	<th style='width:200px;'>วันที่หนังสือ</th>
        	<th style='width:800px;'>เรื่อง</th>
        	<th style='width:300px'>ความเร่งด่วน</th>
        	<th style='width:120px;'>ความลับ</th>
        	<th style='width:120px;'>สถานะล่าสุด</th>
        	<th style='width:200px;'>จัดการ</th>
        </tr>

        <? if(mysql_num_rows($data_set) == 0) { ?>
		<tr>
        	<td style='text-align:center;' colspan="8"> ไม่มีข้อมูลในรายการนี้ </td>
        </tr>        
        <?	} $j=0; for($i=($set_data->get_no()+1); $user_list_ = mysql_fetch_array($data_set); $i++) { $j = ($j>1)?0:1; 
				$index_control = ($user_list_['index_control'] == '9.5')?'7':$user_list_['index_control'];
				$control_dtl = mysql_fetch_array(mysql_query("SELECT name FROM dex2_new_access_layer_detail WHERE id LIKE '".$index_control."' LIMIT 0, 1"));
				$log_list = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$user_list_['id']."' ORDER BY index_control ASC");
				$log_list2 = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$user_list_['id']."' ORDER BY index_control ASC");
				$f_date = new f_date;
				
				$chk_access_ = mysql_fetch_array(mysql_query("SELECT status_add FROM dex2_new_access_layer WHERE id_access LIKE '".$ugroup_dtl['UserGroupId']."' AND id_access_ldetail LIKE '".$index_control."' LIMIT 0, 1"));
		?>
                    <tr class='<? if($j==0) { ?>mark<? }?>'>
                        <td><input type='button' class='btn_style_01' style='width:30px; padding-left:10px; padding-right:10px;' value='+' onclick='$(&quot;#<?=$user_list_['id'];?>&quot;).slideToggle(&quot;fast&quot;); if($(this).val() == &quot;+&quot;) { $(this).val(&quot;-&quot;); } else { $(this).val(&quot;+&quot;); } ;' /></td>
							<? if($user_list_['index_control'] == '10' || $user_list_['index_control'] == '11' || $user_list_['index_control'] == '12' || $user_list_['index_control'] == '13') { ?>
								<? for($i; $log_list_ = mysql_fetch_array($log_list2);) {

										if($log_list_['index_control'] == '9') {
											$index_chk = '09';	// Check to mslc_01
											$field_target = 'mslc_01';
										} else if($log_list_['index_control'] == '7') {
											$index_chk = '07';	// Check to mslc_01
											$field_target = 'mslc_01';
										} else if($log_list_['index_control'] == '4') {
											$index_chk = '04';	// Check to mslc_02
											$field_target = 'mslc_02';
										}
									}

								if($index_chk && $field_target) { 
									//หา organize list
									$orgs_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_new_document_'.$index_chk.' WHERE id_doc1 LIKE "'.$user_list_['id'].'" LIMIT 0, 1'));
										$orgs_exp = explode('|||', $orgs_dtl[$field_target]);
										for($l=0; $l<count($orgs_exp) && $orgs_exp[$l]; $l++) {
											if($orgs_exp[$l]) {
												// Head dtl - id
												$head_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_tblorganize WHERE Organize LIKE "'.$orgs_exp[$l].'" LIMIT 0, 1'));
												$orgs_list_ = mysql_query('SELECT * FROM dex2_tblorganize WHERE ParentId LIKE "'.$head_dtl['OrganizeId'].'"');
													//Organize List 
													
													for($m; $orgs_list = mysql_fetch_array($orgs_list_);) {
														if($orgs_list['OrganizeId'] == $org_dtl['OrganizeId']) 
														{ $orgacc_check = 'on'; }
													}
											}
										}
								}
//									echo $orgacc_check; // Return check organize
								?>
                            <? } ?>
                        <td><?=$i;?></td>
                        <td><?=$user_list_['book_no'];?></td>
                        <td><?=$f_date->date_th_l(strtotime($user_list_['book_date']));?></td>
                        <td><?=$user_list_['title'];?></td>
                        <td>
							<?
								if($user_list_['index_control'] == 'END') {
									echo 'สิ้นสุดกระบวนการ';
								} else {
									echo $control_dtl['name'];
								}
							?>
                        </td>
                        <td><?=$user_list_['haste'];?></td>
                        <td><?=$user_list_['secrecy'];?></td>
                        <td>
                        	<? 
							$check_control_nindex = mysql_num_rows(mysql_query('SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE "'.$chk_access_['status_add'].'" AND index_control LIKE "'.$user_list_['index_control'].'" LIMIT 0, 1'));
							
							$orgacc_check = (empty($orgacc_check ) == 1)?'':$orgacc_check;
							//if($chk_access_['status_add'] == 'on' && $orgacc_check == 'on') { 
							if($chk_access_['status_add'] == 'on' && $check_control_nindex == 0) { 
							
							?>
                        	<input type='button' class="btn_style_01" value='ดำเนินการต่อ' onclick='window.location=&quot;../control_document/index.php?form_type=ADD&amp;form_no=<?=$user_list_['index_control'];?>&amp;id=<?=$user_list_['id'];?>&quot;' />
                            <? } ?>
						</td>
                    </tr>
                    <tr style='display:none;' id='<?=$user_list_['id'];?>'>
                    	<td></td>
                    	<td colspan='8'>
								<table style='width:100%; margin-top:10px; margin-bottom:10px;'  cellpadding='0' cellspacing='0'>
                                	<tr>
                                    	<th>รับ - ส่งที่</th>
                                    	<th>วันที่ลงทะเบียนส่ง</th>
                                    	<th>สถานะ</th>
                                    	<th>ลักษณะรายละเอียด</th>
                                    	<th>จัดการ</th>
                                    </tr>
                                    <?	for($k=1; $log_list_ = mysql_fetch_array($log_list); $k++) { 
											$log_list_['index_control'] = ($log_list_['index_control']==9.5)?7:$log_list_['index_control'];
											$subcontrol_dtl = mysql_fetch_array(mysql_query("SELECT name FROM dex2_new_access_layer_detail WHERE id LIKE '".$log_list_['index_control']."' LIMIT 0, 1"));
											
											$chk_access = mysql_fetch_array(mysql_query("SELECT status_edit, status_view, status_delete FROM dex2_new_access_layer WHERE id_access LIKE '".$ugroup_dtl['UserGroupId']."' AND id_access_ldetail LIKE '".$log_list_['index_control']."' LIMIT 0, 1"));
									?>
                                    <tr>
                                    	<td style='border-left:solid 1px #CCC;'><?=$log_list_['no'];?></td>
                                    	<td style='border-left:solid 1px #CCC;'><? if($log_list_['status'] == 'WAITE') { echo '-'; } else { echo $f_date->date_th_l(strtotime($log_list_['date'])).' '.date('เวลา H:i น.', strtotime($log_list_['date'])); }?></td>
                                    	<td style='border-left:solid 1px #CCC;'><?=$subcontrol_dtl['name'];?></td>
                                    	<td style='border-left:solid 1px #CCC; line-height:18px;'><?=$log_list_['attribute'];?></td>
                                    	<td style='border-left:solid 1px #CCC; border-right:solid 1px #CCC;'>
										<? 
											$issue_no = 'dex2_new_document_'.substr('0'.$user_list_['index_control'], -2, 2);
											$last_index =  mysql_fetch_array(mysql_query('SELECT index_control FROM dex2_new_document_control WHERE id_doc1 LIKE "'.$user_list_['id'].'" ORDER BY index_control DESC LIMIT 0, 1'));
											
											echo $log_list_['index_control'];
											echo '<BR>';
											echo '<BR>';
											
											$user_list__['index_control'] = ($user_list_['index_control'] == 'END')?13:$user_list_['index_control'];
											if(($log_list_['index_control'] == $user_list__['index_control']) || ((mysql_num_rows(mysql_query('SELECT id_doc1 FROM '.$issue_no.' WHERE id_doc1 LIKE "'.$user_list_['id'].'" LIMIT 0, 1')) == 0) && ($last_index['index_control'] == $log_list_['index_control']))) { ?>
													<? if($chk_access['status_edit'] == 'on') { ?>
														<img
															src='../image/btn_edit.png'
															style='cursor:pointer;'
															title='แก้ไขรายการนี้'
															onclick='window.location=&quot;../control_document/index.php?form_type=EDIT&amp;form_no=<?=$log_list_['index_control'];?>&amp;id=<?=$user_list_['id'];?>&quot;' /> 
													<? } ?>
													<? if($chk_access['status_delete'] == 'on') { ?> 
														<img
															src='../image/btn_delete.png'
															style='cursor:pointer;'
															title='ลบรายการนี้'
															onclick="if(confirm('กรุณายืนยันการลบข้อมูล')){ window.location='process.php?id=<?=$user_list_['id']?>&amp;index=<?=$log_list_['index_control'];?>'; }" />
													<? } ?>
											<? } 
											if($chk_access['status_view'] == 'on') { ?>
													<img
														src='../image/btn_view.png'
														style='cursor:pointer;'
														title='ดูรายการนี้'
														onclick='window.location=&quot;../control_document/index.php?&amp;form_no=<?=$log_list_['index_control'];?>&amp;id=<?=$user_list_['id'];?>&quot;' />
											<? } 
										?>
                                        </td>
                                    </tr>
                                    <? } ?>
                                </table>                                
                        </td>
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