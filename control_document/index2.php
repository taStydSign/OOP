<?
echo $_GET['form_no'];
echo '<BR>';
echo $_GET['id'];
if(!$_GET['form_no'] || !$_GET['id']) {
} else {
	if($_GET['form_no'] == 1) { ?><script language="javascript">window.location="../create_document/index.php?tform=EDIT&id=<?=$_GET['id'];?>"</script><? }
}
?>

<!--
<img src='../image/btn_edit.png' style='cursor:pointer;' title='แก้ไขรายการนี้' onclick=''>
-->