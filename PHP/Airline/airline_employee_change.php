
<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//직원 배치 여부 수정 페이지 조회 버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];

$airline_name = "SELECT * FROM airline_employee WHERE employee_number='".$airline_id."' ";
$ret2 = mysqli_query($con, $airline_name);
$row2 = mysqli_fetch_array($ret2);
$airline_name = $row2['airline_name'];

$drive_number= $_POST["drive_number"];
$airplane_airnumber = $_POST["airplane_airnumber"];
$start_time=$_POST["start_time"];
$end_time=$_POST["end_time"];
$airport_airport_name_start=$_POST["airport_airport_name_start"];
$airport_airport_name_finish=$_POST["airport_airport_name_finish"];

$sql="SELECT drive_number, airplane_airnumber, airport_airport_name_start, airport_airport_name_finish, 
start_time, end_time, checkintime, state
FROM drive_info JOIN airline_employee ON drive_info.airline_name = airline_employee.airline_name
WHERE airline_employee.airline_name='".$airline_name."'
AND drive_info.drive_number = '".$drive_number."'
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

echo "<h3> 조회 결과 </h3>";
echo "<TABLE border=1>";
echo "<TR>";
echo "<TH>운행번호</TH><TH>비행기 번호</TH><TH>출발지</TH><TH>도착지</TH><TH>출발시간</TH><TH>도착시간</TH>";
echo "<TH>체크인시간</TH><TH>상태</TH>";
echo "</TR>";
while($row = mysqli_fetch_array($ret))
{
    echo "<TR>";
    echo "<TD>", $row['drive_number'], "</TD>";
    echo "<TD>", $row['airplane_airnumber'], "</TD>";
    echo "<TD>", $row['airport_airport_name_start'], "</TD>";
    echo "<TD>", $row['airport_airport_name_finish'], "</TD>";
    echo "<TD>", $row['start_time'], "</TD>";
    echo "<TD>", $row['end_time'], "</TD>";
    echo "<TD>", $row['checkintime'], "</TD>";
    echo "<TD>", $row['state'], "</TD>";
    
    echo "</TR>";

} 
    echo "</TABLE>";
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
            <form method="POST" action="airline_employee_arrange.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
    </body>
</html>

<?php
mysqli_close($con); 
echo "</TABLE>";
echo "<br>조회가 완료되었습니다.<br><br>";


echo "운행 번호: <input type='number' name='drive_number', required/> &emsp; <input type='submit' value='선택'/>";
echo "<p style='font-size:small;'>*희망하시는 운행번호를 정확히 입력 후 다음으로 넘어가주세요.</p></form>";

echo "<br><a href='airline_main.html'> 메인화면 이동하기</a>";
?>