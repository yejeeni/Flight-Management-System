<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

$get_drive_number=$_GET['drive_number'];
$sql="SELECT * FROM drive_info WHERE drive_number='".$get_drive_number."'";
//$sql="SELECT * FROM drive_info WHERE drive_info.drive_number='2'";

$ret=mysqli_query($con, $sql);
if($ret){
    $count=mysqli_num_rows($ret);
    if($count==0){
        echo $get_drive_number." 비행 정보 없음"."<br>";
    }
}
else{
    echo "데이터 조회 실패"."<br>";
    echo "실패 원인: ".mysqli_error($con);
}

$row = mysqli_fetch_array($ret);
$drive_number=$row['drive_number'];
$airline_name=$row['airline_name'];
$airplane_name=$row['airplane_airnumber'];
$start_location=$row['airport_airport_name_start'];
$arrive_location=$row['airport_airport_name_finish'];
$start_time=$row['start_time'];
$arrive_time=$row['end_time'];
$checkin_time=$row['checkintime'];
$gate=$row['gate'];
$state=$row['state'];
?>

<HTML>
    <HEAD>
        <META http-equiv="content-type" content="text/html; charset=utf-8">
    </HEAD>
    <BODY>
        <h3>비행기 정보 수정 페이지</h3><br>
        <FORM METHOD="POST" ACTION="http://localhost/airport_airplaneModifyCheck.php">
            <TABLE border="1">
                <TR>
                    <TH>운행번호</TH><TH>항공사 이름</TH><TH>비행기 번호</TH><TH>출발지</TH>
                    <TH>도착지</TH><TH>출발시간</TH><TH>도착시간</TH><TH>체크인시간</TH>
                </TR>
                <TR>
                    <TD><?php echo $drive_number ?></TD>
                    <TD><?php echo $airline_name ?></TD>
                    <TD><?php echo $airplane_name ?></TD>
                    <TD><?php echo $start_location ?></TD>
                    <TD><?php echo $arrive_location ?></TD>
                    <TD><?php echo $start_time ?></TD>
                    <TD><?php echo $arrive_time ?></TD>
                    <TD><?php echo $checkin_time ?></TD>
                </TR>
            </TABLE>
            <br><br>
            <INPUT TYPE="hidden" VALUE=<?php echo $drive_number ?> name="drive_number" READONLY>
            탑승구 : <INPUT TYPE="number" min="1" name="gate" required><br>
            상태 : <INPUT TYPE="number" name="state" required><br><br>
            <INPUT TYPE="submit" VALUE="수정">
        </FORM>
        <br><br><A href="airport_airplaneSearch.html">검색 페이지로 가기</A>
        <br><A href="airport_main.html">메인 페이지로 가기</A>
    </BODY>
</HTML>

<?php
    mysqli_close($con);
?>