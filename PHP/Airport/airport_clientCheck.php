<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

$drive_number=$_POST['drive_number'];
$reser_number=$_POST['reser_number'];

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
";
if(($drive_number!='')||($reser_number!='')){
    $sql=$sql."WHERE ";
    if($drive_number!=''){
        //$sql=$sql."passenger_seat.drive_info_drive_number = '".$drive_number."'";
        $sql=$sql."client_passenger.drive_info_drive_number = '".$drive_number."'";
        if($reser_number!=''){
            $sql=$sql." AND client_passenger.reser_number = '".$reser_number."'";
        }
    }
    else{
        if($reser_number != ''){
            $sql=$sql."client_passenger.reser_number = '".$reser_number."'";
        }
    }
}
$ret=mysqli_query($con, $sql);
if(!$ret){
    echo "조회 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con)."<br><br>";
}



echo "<h1> 탑승자 조회 결과</h1>";
echo "<table border=1>";
echo "<tr>";
echo "<th>예매번호</th><th>좌석</th><th>이름</th><th>생년월일</th><th>전화번호</th>";
echo "<th>국적</th><th>성별</th><th>우대조건</th><th>삭제</th>";
echo "</tr>";

while($row=mysqli_fetch_array($ret)){
    //$reser_number=$row['reser_number'];
    $sql="SELECT seat_seatnumber FROM passenger_seat WHERE client_passenger_reser_number='".$row['reser_number']."'";
    $ret2=mysqli_query($con, $sql);
    if(!$ret){
        echo "조회 실패"."<br>";
        echo "실패 원인: ".mysqli_error($con)."<br><br>";
    }   
    $row2 = mysqli_fetch_array($ret2);
    //$seat = $row2['seat_seatnumber'];

    echo "<tr>";
    echo "<td>", $row['reser_number'], "</td>";
    echo "<td>", $row2['seat_seatnumber'], "</td>";
    echo "<td>", $row['name'], "</td>";
    echo "<td>", $row['birth'], "</td>";
    echo "<td>", $row['phone'], "</td>";
    echo "<td>", $row['country'], "</td>";
    echo "<td>", $row['gender'], "</td>";
    echo "<td>", $row['treatment'], "</td>";
    echo "<td>", "<a href='http://localhost/airport_clientDelete.php?reser_number=", $row['reser_number'], "'>", "삭제</a>", "</td>";
    echo "</tr>";
}
mysqli_close($con);
echo "</table>";
echo "<br><br><A href='airport_clientSearch.html'>검색 페이지로 가기</A><br>";
echo "<A href='airport_main.html'>메인으로 가기</A><br>";
?>
