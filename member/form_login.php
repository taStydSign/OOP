<?	session_start();	
	include '../script/config_database.php';		
	$_SESSION['USER_ID'] = (empty($_SESSION['USER_ID']) == 1)?'':$_SESSION['USER_ID'];
	
	if(empty($_SESSION['USER_ID'])) { $_SESSION['USER_ID'] = $_SESSION['ses_username']; }
?>
<!doctype html>
<html lang=”en”>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? header("Content-Type: text/html; charset=utf-8"); ?>
	<script language="javascript" src='../script/javascript/jquery_main.js'></script>
	<link href="css/form_login.css" rel="stylesheet" type="text/css">
<title>ระบบสารบรรณอิเล็กทรอนิกส์ (หนังสือภายนอก) - สำนักงานส่งเสริมสวัสดิภาพและพิทักษ์เด็ก เยาวชน ผู้ด้อยโอกาส และ ผู้สูงอายุ (สท.)</title>
</head>
<body>
<?
if($_SESSION['USER_ID'])
{
	$qry_chk_ses = "SELECT * FROM user WHERE username LIKE '".$_SESSION['USER_ID']."'";
	$chk_ses = mysql_query($qry_chk_ses);
	if(mysql_num_rows($chk_ses) == '1') { header("Location:../home/"); }
}

if($_POST)
{
	$qry_chk_user = "SELECT * FROM user WHERE username LIKE '".$_POST['txt_username']."' AND password LIKE '".encode_password($_POST['txt_password'], 'IN')."' LIMIT 0, 1";
	$chk_user = mysql_query($qry_chk_user);
	
	if(mysql_num_rows($chk_user) == 1) {
		$chk_user = mysql_fetch_array($chk_user);
		$_SESSION['USER_ID'] = $chk_user['username'];
		header("Location:../home/");
	} else {
		?> <script language="javascript"> alert("Username หรือ Password ไม่ถูกต้อง กรุณาตรวจสอบ"); </script> <?
	}
}
?>

<div id='wrapper' style='width:100%; height:100%; text-align:center; background-image:url(../image/signin_background.jpg)'>
	<form method="post" action="">
    <input type='hidden' name='ptype' value='SIGNIN'>
    <table border="0" cellpadding="0" cellspacing="0" class='form_login' id='form_login'>
        <tr>
            <th colspan="2">Sign in to your account</th>
        </tr>
        <tr>
            <td style='text-align:right;'>Username : </td>
            <td style='padding-left:5px;'><input type='text' name='txt_username' id='txt_username' style='width:200px;'></td>
        </tr>
        <tr>
            <td style='text-align:right;'>Password : </td>
            <td style='padding-left:5px;'><input type='password' name='txt_password' style='width:200px;'></td>
        </tr>
        <tr>
            <td colspan="2" style='text-align:center; font-size:10px;'><input type='checkbox' style='margin-right:5px;'> Keep me signed in for 	two weeks	</td>
        </tr>
        <tr>
            <td style='width:100px;'>Lost Password? </td>
            <td style="text-align:right;"><input type='submit' value='Sign In'></td>
        </tr>
    </table>
    </form>
</div>

</body>
</html>
<script language="javascript">
m_top = ($('#wrapper').height()/2)-$('#form_login').height();
$('#form_login').attr('style', 'margin-top:'+m_top+'px');
$('#txt_username').focus();

</script>