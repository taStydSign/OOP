<? include '../script/config_database.php'; ?>

<form id='attach_file' method='POST' action='prc_attachfile.php' enctype="multipart/form-data" >
    <input type='hidden' name='id' value='<?=$_GET['id'];?>' />
    <table border='0' style='width:100%;'>
    <tr><td>
        ไฟล์ที่ต้องการแนบ : <input type='file' name='files'/>
    </td></tr>
    <tr><td>
        รายละเอียด : <input type='text' name='comment'/>
    </td></tr>
    <tr><td align="right">
        <input type='submit' value='Save'/>
        <input type='button' value='Close' onclick='window.close();'/>
    </td></tr>
    </table>
</form>


<script language="javascript" src='../script/javascript/jquery_main.js'></script>
