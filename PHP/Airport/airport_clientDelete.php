<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

$reser_number=$_GET['reser_number'];

$sql="
SELECT DISTINCT
	client_passenger.reser_number,
	client_passenger.name,
	client_passenger.phone,
	client_passenger.age,
	client_passenger.birth,
	client_passenger.country,
	client_passenger.gender,
	client_passenger.treatment
FROM client_passenger, passenger_seat
WHERE client_passenger.reser_number='".$reser_number."'
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "조회 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}

echo "<h1> 아래의 예매 정보가 삭제되었습니다.</h1>";
echo "<table border=1>";
echo "<tr>";
echo "<th>예매번호</th><th>좌석</th><th>이름</th><th>생년월일</th><th>전화번호</th>";
echo "<th>국적</th><th>성별</th><th>우대조건</th>";
echo "</tr>";

$row=mysqli_fetch_array($ret);
$sql="SELECT seat_seatnumber FROM passenger_seat WHERE client_passenger_reser_number='".$row['reser_number']."'";
$ret2=mysqli_query($con, $sql);
if(!$ret2){
    echo "조회 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}   
$row2 = mysqli_fetch_array($ret2);

echo "<tr>";
echo "<td>", $row['reser_number'], "</td>";
echo "<td>", $row2['seat_seatnumber'], "</td>";
echo "<td>", $row['name'], "</td>";
echo "<td>", $row['birth'], "</td>";
echo "<td>", $row['phone'], "</td>";
echo "<td>", $row['country'], "</td>";
echo "<td>", $row['gender'], "</td>";
echo "<td>", $row['treatment'], "</td>";
echo "</tr>";


$sql="
UPDATE passenger_seat
SET client_passenger_reser_number=null
WHERE client_passenger_reser_number='".$reser_number."';
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "좌석 취소 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}
$sql="
DELETE FROM client_passenger WHERE client_passenger.reser_number='".$reser_number."';
";
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "예매번호 삭제 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}


mysqli_close($con);
echo "</table>";
echo "<br><br><A href='airport_clientSearch.html'>검색 페이지로 가기</A><br>";
echo "<A href='airport_main.html'>메인으로 가기</A><br>";
?>