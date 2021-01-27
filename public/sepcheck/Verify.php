<form action="https://mazraeh-barakat.ir/sep/verify.php" method="get" id="frm">
    <input type="hidden" name="State" value="<?=$_POST['State']; ?>" />
    <input type="hidden" name="StateCode" value="<?=$_POST['StateCode']; ?>" />
    <input type="hidden" name="ResNum" value="<?=$_POST['ResNum']; ?>" />
    <input type="hidden" name="MID" value="<?=$_POST['MID']; ?>" />
    <input type="hidden" name="RefNum" value="<?=$_POST['RefNum']; ?>" />
    <input type="hidden" name="CID" value="<?=$_POST['CID'] ?>" />
    <input type="hidden" name="TRACENO" value="<?=$_POST['TRACENO'] ?>" />
    <input type="hidden" name="SecurePan" value="<?=$_POST['SecurePan'] ?>" />
</form>
<script src="https://mazraeh-barakat.ir/js/jquery-3.3.1.js"></script>
<script>
$("#frm").submit();
</script>