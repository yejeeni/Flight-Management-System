<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");
$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
?>

<!DOCTYPE html>
<html>
    <head>
<meta charset="utf-8">
<title>drive_info_check1</title>
</head>
<body>
<h3> 항공기 예매 시스템 <br>&nbsp;&nbsp; 항공사 전용 <br> 등록된 비행기 운행 정보 확인</h3>
<form method="post" action="drive_info_check.php"> 

    <input type="hidden" value=<?php echo $airline_pw ?>  name=airline_pw READONLY>
    <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>

    비행기번호 :&nbsp; <input type="text" name="airplane_airnumber"><br>
    날짜/출발시간 :&nbsp; <input type="date" name="start_time">&nbsp;
    날짜/도착시간 :&nbsp; <input type="date" name="end_time"><br>
    출발지 :&nbsp; <input type="text" name="airport_airport_name_start">&nbsp;
    도착지 :&nbsp; <input type="text" name="airport_airport_name_finish"><br>
    <br>
    <input type="submit" value="조회" >
    <br><br>
        <!--<head>
            <title> 항공기 예매 시스템 </title>
        </head>>-->
</form>
<form method="POST" action="airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
</body>
</html>