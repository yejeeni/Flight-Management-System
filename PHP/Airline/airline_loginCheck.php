<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

$airline_id = $_POST['airline_id'];
$airline_pw = $_POST['airline_pw'];

$sql="
SELECT name, pw, airline_name
FROM airline_employee
WHERE employee_number = '".$airline_id."'
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
else{
    $count=mysqli_num_rows($ret);
    if($count==0){
        mysqli_close($con);
        echo "<h3>존재하지 않는 아이디이거나 잘못된 비밀번호입니다.</h3>"."<br>";
        echo "<br><br><A href='airline_login.html'>다시 로그인 하기</A><br>";
        exit;
    }
}

$row=mysqli_fetch_array($ret);
if($airline_pw != $row['pw']){
    mysqli_close($con);
    echo "<h3>존재하지 않는 아이디이거나 잘못된 비밀번호입니다.</h3>";
    echo "<br><br><A href='airline_login.html'>다시 로그인 하기</A><br>";
    exit;
}

echo "<h5>항공기 예매 시스템</h5>";
echo "<h1>항공사 메인 홈페이지</h1>";
echo "[", $row['airline_name'], "] ", $row['name'], " 님 로그인되었습니다! <br><br>";

/*echo "<br><br><li>", "<a href='http://localhost/airline_driveinfo_register.php?airline_name=", 
    $row['airline_name'], "'>", "비행기 운행정보 등록</a>", "</li>";
echo "<br><br><li>", "<a href='http://localhost/airline_info_check.php?airline_name=", $row['airline_name'], "'>", "등록된 비행기 운행정보 확인</a>", "</li>";
echo "<br><br><li>", "<a href='http://localhost/airline_employee_change.php?airline_name=", $row['airline_name'], "'>", "항공기 직원 배치</a>", "</li>";
echo "<br><br><li>", "<a href='http://localhost/airline_passenger_check.php?airline_name=", $row['airline_name'], "'>", "예매자 조회</a>", "</li>";
echo "<br><br><li>", "<a href='http://localhost/airline_stats.php?airline_name=", $row['airline_name'], "'>", "운행 통계 확인</a>", "</li>";
*/

//mysqli_close($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>airline_login_check</title>
    </head>
    <body>
        <ul>
        <li><form method="POST" action="http://localhost/airline_driveinfo_register.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $row['airline_name'] ?> name=airline_name READONLY>
            <input type="submit" value="비행기 운행정보 등록">
        </form></li>

        <li><form method="POST" action="http://localhost/drive_info_check_home.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $row['airline_name'] ?> name=airline_name READONLY>
            <input type="submit" value="등록된 비행기 운행정보 확인">
        </form></li>

        <li><form method="POST" action="http://localhost/airline_employee_change_home.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $row['airline_name'] ?> name=airline_name READONLY>
            <input type="submit" value="항공기 직원 배치">
        </form></li>

        <li><form method="POST" action="http://localhost/client_passenger_check_home.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $row['airline_name'] ?> name=airline_name READONLY>
            <input type="submit" value="예매자 조회">
        </form></li>

        <li><form method="POST" action="http://localhost/airline_stats.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $row['airline_name'] ?> name=airline_name READONLY>
            <input type="submit" value="운행 통계 확인">
        </form></li>
        </ul>
    </body>
</html>

<?php
mysqli_close($con);
?>

<br><A href="main.html">시작화면으로 돌아가기</a>