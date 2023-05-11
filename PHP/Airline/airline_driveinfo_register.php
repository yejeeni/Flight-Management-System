<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");
$airline_id = $_POST["airline_id"];
$airline_pw = $_POST["airline_pw"];
$airline_name = $_POST['airline_name'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>airline_driveinfo_register</title>
</head>
<body>

<h5>항공기 예매 시스템</h5>
<h1>항공사 비행기 운행정보 등록</h1>
<br>
<form method="POST" action="airline_driveinfo_result.php">

    <fieldset>
        <legend>운행정보</legend>
        
        비행기번호: <input type="text" name="airnumber" required/> <br><br>

        출발지: <select name="start_airport_name"  size="1" required>
            <option>인천</option> <option>제주</option>
            <option>대구</option> <option>김포</option>
        </select>&emsp;&emsp;&emsp;

        도착지: <select name="end_airport_name"  size="1" required>
            <option>인천</option> <option>제주</option>
            <option>대구</option> <option>김포</option>
        </select>

        <br><br>
        출발시간: <input type="datetime-local" name="start_time" required/> &emsp;
        
        <br><br>
        체크인시간: <input type="datetime-local" name="checkin_time" required/>&emsp;

        <br><br>
        도착날짜: <input type="datetime-local" name="end_time" required/> &emsp;

        <br><br>
        착륙시간: <input type="datetime-local" name="landing_time" required/> &emsp;

    </fieldset> 
    <br><br>
    
    <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
    <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
    <input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
    <input type="submit" value="등록">
    </form>
<form method="POST" action="airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
</body>
</html>

 <?php
  mysqli_close($con);
?>
