<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

$drive_number=$_POST["drive_number"];
$gate=$_POST["gate"];
$state=$_POST["state"];

$sql="
UPDATE drive_info 
SET	gate = '".$gate."',
	state = '".$state."'
WHERE drive_info.drive_number = '".$drive_number."'
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}

$sql="
SELECT DISTINCT
	        drive_info.drive_number, 
	        drive_info.airline_name, 
	        drive_info.airplane_airnumber,
	        drive_info.airport_airport_name_start,
	        drive_info.airport_airport_name_finish,
	        drive_info.start_time,
	        drive_info.end_time,
            drive_info.checkintime,
	        drive_info.gate,
	        drive_info.state,
	        airplane.totalseat
FROM airplane, drive_info
WHERE drive_number='".$drive_number."'
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "조회 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}

$row=mysqli_fetch_array($ret);
echo "<h1> 비행기 정보 수정 완료</h1>";
echo "<table border=1>";
echo "<tr>";
echo "<th>운행번호</th><th>항공사</th><th>비행기번호</th><th>출발지</th><th>도착지</th>";
echo "<th>출발시간</th><th>도착시간</th><th>체크인시간</th><th>탑승구</th><th>상태</th>";
echo "<th>총좌석수</th>";
echo "</tr>";
echo "<tr>";
echo "<td>", $row['drive_number'], "</td>";
echo "<td>", $row['airline_name'], "</td>";
echo "<td>", $row['airplane_airnumber'], "</td>";
echo "<td>", $row['airport_airport_name_start'], "</td>";
echo "<td>", $row['airport_airport_name_finish'], "</td>";
echo "<td>", $row['start_time'], "</td>";
echo "<td>", $row['end_time'], "</td>";
echo "<td>", $row['checkintime'], "</td>";
echo "<td>", $row['gate'], "</td>";
echo "<td>", $row['state'], "</td>";
echo "<td>", $row['totalseat'], "</td>";
echo "</tr>";
echo "</table>";

echo "<br><br><A href='airport_airplaneSearch.html'>검색 페이지로 가기</A>";
echo "<br><A href='airport_main.html'>메인 페이지로 가기</A>";


mysqli_close($con);
?>