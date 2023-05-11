
<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//예매자 조회 페이지 조회 버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
$airline_name=$_POST['airline_name'];

$drive_info_drive_number= $_POST["drive_info_drive_number"];
$reser_number = $_POST["reser_number"];

/*if(($drive_info_drive_number !='')||($reser_number !=''))
{
    if($drive_info_drive_number =='')
    {
        $sql="SELECT DISTINCT
        client_passenger.reser_number,
        client_passenger.drive_info_drive_number,
        passenger_seat.seat_airplane_airnumber,
        passenger_seat.seat_seatnumber,
        client_passenger.name,
        client_passenger.phone,
        client_passenger.age,
        client_passenger.birth,
        client_passenger.country,
        client_passenger.gender,
        client_passenger.treatment
        FROM client_passenger JOIN passenger_seat ON  client_passenger.reser_number = passenger_seat.client_passenger_reser_number
        WHERE client_passenger.drive_info_drive_number 
        IN( SELECT passenger_seat.drive_info_drive_number
        FROM passenger_seat
        WHERE passenger_seat.client_passenger_reser_number = '".$reser_number."'
        AND passenger_seat.drive_info_drive_number is not NULL)";
    }
    else if($reser_number =='')
    {
            $sql="SELECT DISTINCT
            client_passenger.reser_number,
            client_passenger.drive_info_drive_number,
            passenger_seat.seat_airplane_airnumber,
            passenger_seat.seat_seatnumber,
            client_passenger.name,
            client_passenger.phone,
            client_passenger.age,
            client_passenger.birth,
            client_passenger.country,
            client_passenger.gender,
            client_passenger.treatment
            FROM client_passenger JOIN passenger_seat ON client_passenger.drive_info_drive_number = passenger_seat.drive_info_drive_number
            WHERE client_passenger.reser_number 
            IN( SELECT passenger_seat.client_passenger_reser_number
            FROM passenger_seat
            WHERE passenger_seat.drive_info_drive_number = '".$drive_info_drive_number."'
            AND passenger_seat.client_passenger_reser_number is not NULL)";
    }
    else
    {
        $sql="SELECT DISTINCT
       client_passenger.reser_number,
        client_passenger.drive_info_drive_number,
        passenger_seat.seat_airplane_airnumber,
        passenger_seat.seat_seatnumber,
       client_passenger.name,
       client_passenger.phone,
       client_passenger.age,
       client_passenger.birth,
       client_passenger.country,
       client_passenger.gender,
       client_passenger.treatment
        FROM client_passenger JOIN passenger_seat ON client_passenger.reser_number = passenger_seat.client_passenger_reser_number
        WHERE client_passenger.reser_number = '".$reser_number."' 
        AND passenger_seat.drive_info_drive_number = '".$drive_info_drive_number."'";
    }
}*/

$sql="
SELECT DISTINCT
	client_passenger.reser_number,
    	client_passenger.drive_info_drive_number,
	client_passenger.name,
	client_passenger.phone,
	client_passenger.age,
	client_passenger.birth,
	client_passenger.country,
	client_passenger.gender,
	client_passenger.treatment
FROM client_passenger, passenger_seat
WHERE client_passenger.drive_info_drive_number IN(
	SELECT drive_info.drive_number
	FROM drive_info
	WHERE drive_info.airline_name='".$airline_name."'
)
";
if(($drive_info_drive_number!='')||($reser_number!='')){
    if($drive_info_drive_number!=''){
        $sql=$sql." AND client_passenger.drive_info_drive_number = '".$drive_info_drive_number."'";
    }
    if($reser_number != ''){
        $sql=$sql." AND client_passenger.reser_number = '".$reser_number."'";
    }
}

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

echo "<h3>예매자 조회 결과 </h3>";
echo "<TABLE border=1>";
echo "<TR>";

echo "<TH>예매번호</TH><TH>운행번호</TH>";
//echo "<TH>비행기번호</TH><TH>좌석</TH>";
echo "<TH>이름</TH><TH>전화번호</TH><TH>나이</TH><TH>생년월일</TH>";
echo "<TH>국적</TH><TH>성별</TH><TH>우대조건</TH>";

echo "</TR>";
while($row = mysqli_fetch_array($ret))
{
    echo "<TR>";
    echo "<TD>", $row['reser_number'], "</TD>";
    echo "<TD>", $row['drive_info_drive_number'], "</TD>";
    //echo "<TD>", $row['seat_airplane_airnumber'], "</TD>";
    //echo "<TD>", $row['seat_seatnumber'], "</TD>";
    echo "<TD>", $row['name'], "</TD>";
    echo "<TD>", $row['phone'], "</TD>";
    echo "<TD>", $row['age'], "</TD>";
    echo "<TD>", $row['birth'], "</TD>";
    echo "<TD>", $row['country'], "</TD>";
    echo "<TD>", $row['gender'], "</TD>";
    echo "<TD>", $row['treatment'], "</TD>";

    echo "</TR>";

}
?>


<?php
mysqli_close($con); 
echo "</TABLE>";
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
        <form method="POST" action="http://localhost/airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
    </body>
</html>