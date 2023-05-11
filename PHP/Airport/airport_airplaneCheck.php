<?php
    $con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");

    $start_date=$_POST["start_date"];
    $arrive_date=$_POST["arrive_date"];
    $start_location=$_POST["start_location"];
    $arrive_location=$_POST["arrive_location"];
    $airline_name=$_POST["airline_name"];
    $drive_number=$_POST["drive_number"];
    /*$start_date="2021-12-12";
    $arrive_date="2021-12-12";
    $start_location="Daegu";
    $arrive_location="Jeju";
    $airline_name="Aair";
    $drive_number="2";*/
    /*$start_date="";
    $arrive_date="";
    $start_location="Daegu";
    $arrive_location="Jeju";
    $airline_name="";
    $drive_number="";*/

    
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
        WHERE
        ";
        if($start_date!=''){
            $sql=$sql."Date(drive_info.start_time) = '".$start_date."' AND ";
        }
        if($arrive_date!=''){
            $sql=$sql."Date(drive_info.end_time) = '".$arrive_date."' AND ";
        }
        $sql=$sql."
         drive_info.airport_airport_name_start = '".$start_location."'
         AND drive_info.airport_airport_name_finish = '".$arrive_location."' ";
        if($airline_name!=''){
            $sql=$sql." AND drive_info.airline_name = '".$airline_name."'";
        }
        if($drive_number!=''){
            $sql=$sql." AND drive_info.drive_number = '".$drive_number."'";
        }
        //AND drive_info.airplane_airnumber = airplane.airnumber

    
    
    $ret=mysqli_query($con, $sql);
    if(!$ret){
        echo "실패"."<br>";
        echo "실패 원인: ".mysqli_error($con)."<br><br>";
    }

    
    echo "<h1> 비행기 조회 결과</h1>";
    echo "<table border=1>";
    echo "<tr>";
    echo "<th>운행번호</th><th>항공사</th><th>비행기번호</th><th>출발지</th><th>도착지</th>";
    echo "<th>출발시간</th><th>도착시간</th><th>체크인시간</th><th>탑승구</th><th>상태</th>";
    echo "<th>총좌석수</th><th>수정</th>";
    echo "</tr>";
    while($row=mysqli_fetch_array($ret)){
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
        echo "<td>", "<a href='http://localhost/airport_airplaneModify.php?drive_number=", $row['drive_number'], "'>", "수정</a>", "</td>";
        echo "</tr>";
    }

    mysqli_close($con);
    echo "</table>";
    echo "<br><br><A href='airport_airplaneSearch.html'>이전으로 가기</A><br>";
    echo "<A href='airport_main.html'>메인으로 가기</A><br>";
?>
