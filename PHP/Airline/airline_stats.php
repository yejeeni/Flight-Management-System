<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

$airline_id = $_POST['airline_id'];
$airline_pw = $_POST['airline_pw'];
$airline_name=$_POST['airline_name'];
//$airline_name='Aair'; // 로그인 된 항공사 이름

// 월별 탑승자
$sql="  
CREATE TEMPORARY TABLE if not exists  drive_number_total_people_inner_join(
SELECT DISTINCT passenger_seat.drive_info_drive_number, COUNT(DISTINCT passenger_seat.client_passenger_reser_number) AS 'total_people'
FROM passenger_seat, drive_info
WHERE passenger_seat.client_passenger_reser_number is not NULL AND drive_info.airline_name='".$airline_name."' 
GROUP BY passenger_seat.drive_info_drive_number
);
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
CREATE TEMPORARY TABLE if not exists drive_number_total_people(
    SELECT drive_info.drive_number, drive_info.start_time, drive_number_total_people_inner_join.total_people
    FROM drive_info
        INNER JOIN drive_number_total_people_inner_join
        ON drive_info.drive_number = drive_number_total_people_inner_join.drive_info_drive_number
    WHERE drive_info.airline_name = '".$airline_name."'); -- 로그인된 항공사
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
SELECT month(drive_number_total_people.start_time) AS 'month', SUM(drive_number_total_people.total_people) AS 'total_people'
FROM drive_number_total_people GROUP BY month(drive_number_total_people.start_time);
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}

// 화면에 출력
echo "<h1>운행 통계 페이지</h1>";
echo "<br><br>";

echo "<h2>월별 탑승자 수</h2>";
echo "<table border=1>";
echo "<tr>";
echo "<th>월</th><th>총 탑승자 수</th>";
echo "</tr>";

while($row=mysqli_fetch_array($ret)){
    echo "<tr>";
    echo "<td>", $row['month'], "</td>";
    echo "<td>", $row['total_people'], "</td>";
    echo "</tr>";
}
echo "</table>";

//임시 테이블 정리
$sql="
DROP TEMPORARY TABLE if exists drive_number_total_people_inner_join;
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
DROP TEMPORARY TABLE if exists drive_number_total_people; 
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}



// 노선별 탑승자
$sql="
CREATE TEMPORARY TABLE if not exists drive_number_total_people_inner_join(
    SELECT passenger_seat.drive_info_drive_number, COUNT(DISTINCT passenger_seat.client_passenger_reser_number) AS 'total_people'
    FROM passenger_seat, drive_info
    WHERE passenger_seat.client_passenger_reser_number is not NULL AND drive_info.airline_name='".$airline_name."'
    GROUP BY passenger_seat.drive_info_drive_number
    );
    
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
-- 운행번호별 출발지, 도착지, 총 탑승자 수
    CREATE TEMPORARY TABLE if not exists drive_number_total_people(
        SELECT drive_info.drive_number, drive_info.airport_airport_name_start, drive_info.airport_airport_name_finish, drive_number_total_people_inner_join.total_people
        FROM drive_info
            INNER JOIN drive_number_total_people_inner_join
            ON drive_info.drive_number = drive_number_total_people_inner_join.drive_info_drive_number
        WHERE drive_info.airline_name = '".$airline_name."' -- 로그인된 항공사
    );
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
SELECT drive_number_total_people.airport_airport_name_start AS 'start_location', 
    drive_number_total_people.airport_airport_name_finish AS 'arrive_location', SUM(drive_number_total_people.total_people) AS 'total_people'
    FROM drive_number_total_people
    GROUP BY drive_number_total_people.airport_airport_name_start, drive_number_total_people.airport_airport_name_finish;
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}

// 화면에 출력
echo "<br><br><br>";
echo "<h2>노선별 탑승자 수</h2>";
echo "<table border=1>";
echo "<tr>";
echo "<th>출발지</th><th>도착지</th><th>총 탑승자 수</th>";
echo "</tr>";

while($row=mysqli_fetch_array($ret)){
    echo "<tr>";
    echo "<td>", $row['start_location'], "</td>";
    echo "<td>", $row['arrive_location'], "</td>";
    echo "<td>", $row['total_people'], "</td>";
    echo "</tr>";
}

//임시 테이블 정리
$sql="
DROP temporary TABLE if exists drive_number_total_people_inner_join;
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
DROP TEMPORARY TABLE if exists drive_number_total_people;
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
echo "</table>";

//mysqli_close($con);

//echo "<br><br><A href='airline_loginCheck.php'>메인으로 가기</A><br>";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Page Title</title>
    </head>
    <body>
        <form method="POST" action="http://localhost/airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
    </body>
</html>

<?php
mysqli_close($con);
?>
