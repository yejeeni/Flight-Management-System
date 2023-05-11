<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");
$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
$airline_name=$_POST['airline_name'];

?>


<!DOCTYPE html>
<html>
    <head>
<meta charset="utf-8">
<title>client_passenger_check_home</title></head>
<body>
<h3>예매자 조회</h3>
<form method="post" action="client_passenger_check.php">

<input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
<input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
<input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>

    운행번호 &nbsp; <input type="text" name="drive_info_drive_number"><br>
    예매번호 &nbsp; <input type="text" name="reser_number">&nbsp;
    <br><br>
    <input type="submit" value="조회">
    <br>
</form>  

<form method="POST" action="airline_loginCheck.php">
<input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
<input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
<br><input type="submit" value="메인화면 이동">
</form>

</body>
</html>