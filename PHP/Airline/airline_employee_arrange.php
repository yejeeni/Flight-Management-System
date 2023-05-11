<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//직원 상세 페이지 조회 버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];

$airline_name = "SELECT * FROM airline_employee WHERE employee_number='".$airline_id."' ";
$ret2 = mysqli_query($con, $airline_name);
$row2 = mysqli_fetch_array($ret2);
$airline_name = $row2['airline_name'];

$drive_number=$_POST['drive_number'];
?>

<!DOCTYPE html>
<html>
    <head>
<meta charset="utf-8">
<title>airline_employee_arrange1</title>
</head>
<body>
<h3> 항공기 예매 시스템 <br>&nbsp;&nbsp; 항공사 전용 <br> 직원 배치 여부/수정</h3>

<?php
$sql="SELECT DISTINCT drive_number, airplane_airnumber, airport_airport_name_start, airport_airport_name_finish, 
start_time, end_time, checkintime, state
FROM drive_info JOIN airline_employee ON drive_info.airline_name = airline_employee.airline_name
WHERE drive_info.drive_number = '".$drive_number."'
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
    echo "</TABLE><br><br>";

$sql2= "SELECT employee_number, name, birth, phone, gender, position
FROM passenger_employee JOIN airline_employee ON airline_employee.employee_number = passenger_employee.airline_employee_employee_number
WHERE passenger_employee.drive_info_drive_number = '".$drive_number."';";

$ret2=mysqli_query($con, $sql2);
if($ret2)
{
    $count=mysqli_num_rows($ret2);      
}
else
{
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
    exit();
}

echo "<h3> 배정된 직원 </h3>";
echo "<TABLE border=1>";
echo "<TR>";
echo "<TH>사원번호</TH><TH>이름</TH><TH>생년월일</TH><TH>전화번호</TH><TH>성별</TH><TH>직급</TH>";
echo "</TR>";
while($row = mysqli_fetch_array($ret2))
{
    echo "<TR>";
    echo "<TD>", $row['employee_number'], "</TD>";
    echo "<TD>", $row['name'], "</TD>";
    echo "<TD>", $row['birth'], "</TD>";
    echo "<TD>", $row['phone'], "</TD>";
    echo "<TD>", $row['gender'], "</TD>";
    echo "<TD>", $row['position'], "</TD>";
    echo "</TR>";
}
echo "</TABLE><br>";


$sql3="SELECT employee_number, name, birth, phone, gender, position
FROM airline_employee
WHERE airline_employee.airline_name='".$airline_name."'
AND workstate='재직'
ORDER BY employee_number ASC;";

$ret3=mysqli_query($con, $sql3);
if($ret)
{
    $count=mysqli_num_rows($ret3);     
}
else
{
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
    exit();
}
?>

<form method="post" action="airline_employee_delete.php">

    <input type="hidden" value=<?php echo $airline_pw ?>  name=airline_pw READONLY>
    <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
    <input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
    <input type="hidden" value=<?php echo $drive_number ?> name=drive_number READONLY>

    사원번호:&nbsp;<input type="text" name="employee_number">

    <input type="submit" value="삭제" > 
    <br><br>     
</form>

<?php
echo "<h3> 재직 중인 직원 </h3>";
echo "<TABLE border=1>";
echo "<TR>";
echo "<TH>사원번호</TH><TH>이름</TH><TH>생년월일</TH><TH>전화번호</TH><TH>성별</TH><TH>직급</TH>";
echo "</TR>";
while($row = mysqli_fetch_array($ret3))
{
    echo "<TR>";
    echo "<TD>", $row['employee_number'], "</TD>";
    echo "<TD>", $row['name'], "</TD>";
    echo "<TD>", $row['birth'], "</TD>";
    echo "<TD>", $row['phone'], "</TD>";
    echo "<TD>", $row['gender'], "</TD>";
    echo "<TD>", $row['position'], "</TD>";

    echo "</TR>";
}
 echo "</TABLE><br>";
?>

<form method="post" action="airline_employee_add.php">

    <input type="hidden" value=<?php echo $airline_pw ?>  name=airline_pw READONLY>
    <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
    <input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
    <input type="hidden" value=<?php echo $drive_number ?> name=drive_number READONLY>

    사원번호:&nbsp;<input type="text" name="employee_number">
    <input type="submit" value="추가" > 
    <br><br>     
</form>

<form method="POST" action="airline_loginCheck.php">
        <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
        <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
        <br><input type="submit" value="메인화면 이동">
</form>

</body>
</html>