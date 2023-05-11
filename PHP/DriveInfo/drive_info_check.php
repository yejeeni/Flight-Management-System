<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//등록된 비행기 운행 정보 확인 페이지 조회 버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];

$airplane_airnumber = $_POST["airplane_airnumber"];
$start_time=$_POST["start_time"];
$end_time=$_POST["end_time"];
$airport_airport_name_start=$_POST["airport_airport_name_start"];
$airport_airport_name_finish=$_POST["airport_airport_name_finish"];

$airline_name = "SELECT * FROM airline_employee WHERE employee_number='".$airline_id."' ";
$ret2 = mysqli_query($con, $airline_name);
$row2 = mysqli_fetch_array($ret2);
$airline_name = $row2['airline_name'];


$sql="SELECT drive_number, airplane_airnumber, airport_airport_name_start, airport_airport_name_finish,
start_time, end_time, checkintime, state FROM drive_info
WHERE drive_info.airline_name='".$airline_name."'
AND drive_info.airplane_airnumber = '".$airplane_airnumber."'
AND date_format(drive_info.start_time, '%Y-%m-%d') = '".$start_time."'
AND date_format(drive_info.end_time, '%Y-%m-%d') = '".$end_time."'
AND drive_info.airport_airport_name_start = '".$airport_airport_name_start."'
AND drive_info.airport_airport_name_finish = '".$airport_airport_name_finish."'
ORDER BY drive_number ASC";

$ret=mysqli_query($con, $sql);
if($ret)
{
    $count=mysqli_num_rows($ret);  
}
else
{
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
    exit();
}

echo "<h3>등록된 비행기 운행 정보 확인 조회 결과 </h3>";
echo "<table border=1>";
echo "<tr>";
echo "<th>운행번호</th><th>비행기 번호</th><th>출발지</th><th>도착지</th><th>출발시간</th><th>도착시간</th>";
echo "<th>체크인시간</th><th>상태</th>";
echo "</tr>";

while($row = mysqli_fetch_array($ret))
{
    echo "<tr>";
    echo "<td>", $row['drive_number'], "</td>";
    echo "<td>", $row['airplane_airnumber'], "</td>";
    echo "<td>", $row['airport_airport_name_start'], "</td>";
    echo "<td>", $row['airport_airport_name_finish'], "</td>";
    echo "<td>", $row['start_time'], "</td>";
    echo "<td>", $row['end_time'], "</td>";
    echo "<td>", $row['checkintime'], "</td>";
    echo "<td>", $row['state'], "</td>";
   
    echo "</tr>";

}
echo "</TABLE>";
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
            <form method="POST" action="drive_info_change.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
    </body>
</html>

<?php
mysqli_close($con); 
echo "<br>조회가 완료되었습니다.<br><br>";


echo "운행 번호: <input type='number' name='drive_number', required/> &emsp; <input type='submit' value='선택'/>";
echo "<p style='font-size:small;'>*희망하시는 운행번호를 정확히 입력 후 다음으로 넘어가주세요.</p></form>";

?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
        <form method="POST" action="airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
    </body>
</html>