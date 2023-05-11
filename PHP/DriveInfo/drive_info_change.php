<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//비행기 운행 정보 수정 페이지 수정버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
$airline_name=$_POST["airline_name"];
$drive_number=$_POST["drive_number"];


$sql="SELECT * FROM drive_info WHERE drive_number='".$drive_number."' ";

$ret=mysqli_query($con, $sql);
if($ret)
{
    $count=mysqli_num_rows($ret);
    if($count==0)
    {
        echo $_GET['drive_number']."정보 없음"."<br>";
    }
}
else
{
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
}

echo "<h3>입력된 운행정보 조회 결과 </h3>";
echo "<table border=1>";
echo "<tr>";
echo "<th>운행번호</th><th>비행기 번호</th><th>출발지</th><th>도착지</th><th>출발시간</th><th>도착시간</th>";
echo "<th>체크인시간</th><th>상태</th>";
echo "</tr><br>";

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

<html>
    <head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>drive_info_change</title></head>
<body>
<form method="post" action="drive_info_change_result.php">

    <input type="hidden" value=<?php echo $drive_number ?> name="drive_number" READONLY>
    <input type="hidden" value=<?php echo $airline_name ?> name="airline_name" READONLY>
    <input type="hidden" name="airline_pw" value=<?php echo $airline_pw ?> READONLY>
    <input type="hidden" name="airline_id" value=<?php echo $airline_id ?> READONLY>

    출발지:<input type="text" name="airport_airport_name_start" > &nbsp;
    도착지:<input type="text" name="airport_airport_name_finish" ><br>
    출발시간:<input type="datetime-local" name="start_time" >&nbsp;
    도착시간:<input type="datetime-local" name="end_time" ><br>
    착륙시간:<input type="datetime-local" name="landingtime" >&nbsp;
    체크인시간:<input type="datetime-local" name="checkintime" ><br>
    <input type ="submit" value="수정">
</form>
<form method="POST" action="airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
</body>
</html>

