<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");
$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
?>

<!DOCTYPE html>
<html>
    <head>
<meta charset="utf-8">
<title>airline_employee_change1</title>
</head>
<body>
<h3> 항공기 예매 시스템 <br>&nbsp;&nbsp; 항공사 전용 <br> 직원 배치 여부/수정</h3>
<form method="post" action="airline_employee_arrange.php">

    <input type="hidden" value=<?php echo $airline_pw ?>  name=airline_pw READONLY>
    <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>

    운행번호 :&nbsp; <input type="text" name="drive_number" required>&nbsp;
    <br>
    <!--<input type="submit" value="조회" required>-->
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