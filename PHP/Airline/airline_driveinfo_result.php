<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>airline_driveinfo_result</title>
</head>
<body>

<h5>항공기 예매 시스템</h5>
<h1>항공사 비행기 운행정보 등록</h1>
<br>

<?php
   $con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");
   $airline_id = $_POST["airline_id"]; // 로그인 아이디
   $airline_pw = $_POST["airline_pw"];
   $airline_name = $_POST['airline_name'];

   $airnumber = $_POST["airnumber"];
   $start_time = $_POST["start_time"];
   $checkin_time = $_POST["checkin_time"];
   $end_time = $_POST["end_time"];
   $landing_time = $_POST["landing_time"];
   $start_airport_name = $_POST["start_airport_name"];
   $end_airport_name = $_POST["end_airport_name"];

   $st_date = substr(((str_replace("T", " ", $start_time)).":00"), 5, 5);
   $et_date = substr(((str_replace("T", " ", $end_time)).":00"), 5, 5);
   
   // 매진 시 예상 소요일 
   // 같은 월이고 같은 요일 2001-01-01
   $sql = " SELECT AVG(datediff(soldout_date,register_date)) AS cnt FROM drive_info 
   WHERE airport_airport_name_start = '".$start_airport_name."' AND airport_airport_name_finish= '".$end_airport_name."'
   AND month(drive_info.start_time) = month('".$start_time."')
   AND DAYOFWEEK(drive_info.start_time)=DAYOFWEEK('".$start_time."')
   AND airline_name = '".$airline_name."' ";
   $ret = mysqli_query($con, $sql);
   $row= mysqli_fetch_array($ret);
   $days = $row['cnt'];

   // 운행 전적 확인
   $sql = "SELECT COUNT(*) AS cnt FROM drive_info 
   WHERE airport_airport_name_start = '".$start_airport_name."' AND airport_airport_name_finish= '".$end_airport_name."' 
   AND month(drive_info.start_time) = month('".$start_time."')
   AND DAYOFWEEK(drive_info.start_time)=DAYOFWEEK('".$start_time."')
   AND airline_name = '".$airline_name."'";
   $ret = mysqli_query($con, $sql);
   $row= mysqli_fetch_array($ret);
   $is_drive = $row['cnt'];

   // 매진 전적 확인
   $sql = "SELECT COUNT(*) AS cnt FROM drive_info 
   WHERE airport_airport_name_start = '".$start_airport_name."' AND airport_airport_name_finish= '".$end_airport_name."' 
   AND month(drive_info.start_time) = month('".$start_time."')
   AND DAYOFWEEK(drive_info.start_time)=DAYOFWEEK('".$start_time."')
   AND airline_name = '".$airline_name."'
   AND soldout_Date IS NOT NULL";
   $ret = mysqli_query($con, $sql);
   $row= mysqli_fetch_array($ret);
	$is_soldout = $row['cnt'];

   // 총 탑승자 수를 total_people에 저장
   $sql = "SELECT DISTINCT COUNT(passenger_seat.client_passenger_reser_number) INTO @total_people
   FROM passenger_seat
   WHERE passenger_seat.client_passenger_reser_number is not NULL
   AND passenger_seat.drive_info_drive_number IN(
      SELECT DISTINCT drive_info.drive_number
      FROM drive_info
      WHERE drive_info.airport_airport_name_start = '".$start_airport_name."'
      AND drive_info.airport_airport_name_finish = '".$end_airport_name."'
      AND month(drive_info.start_time) = month('".$start_time."')
      AND DAYOFWEEK(drive_info.start_time)=DAYOFWEEK('".$start_time."')
      AND drive_info.airline_name = '".$airline_name."');";           
   $ret = mysqli_query($con, $sql);
   if(!$ret){
      echo "1 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
   }   
   
   // 총 운행 수를 total_drive에 저장
   $sql = "SELECT DISTINCT COUNT(drive_info.drive_number) INTO @total_drive
   FROM drive_info
   WHERE drive_info.airport_airport_name_start = '".$start_airport_name."'
   AND drive_info.airport_airport_name_finish = '".$end_airport_name."'
   AND month(drive_info.start_time) = month('".$start_time."')
   AND DAYOFWEEK(drive_info.start_time)= DAYOFWEEK('".$start_time."')
   AND drive_info.airline_name ='".$airline_name."'";
   $ret = mysqli_query($con, $sql);
   if(!$ret){
      echo "2 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
   }   
      
   // 평균 탑승자 수를 avg_people에 저장
   $sql="SELECT @total_people/@total_drive AS '평균 탑승자 수' INTO @avg_people;";
   $ret = mysqli_query($con, $sql);
   if(!$ret){
      echo "3 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
     }   
   
   //추가할 운행의 비행기에 존재하는 총 좌석을 total_seat에 저장
   $sql=" SELECT airplane.totalseat INTO @total_seat FROM airplane WHERE airplane.airnumber='".$airnumber."'; ";
   $ret = mysqli_query($con, $sql);
   if(!$ret){
      echo "4 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
   }   

   // 추가할 운행의 좌석이 몇 퍼센트 예매될지 predict에 저장
   $sql="SELECT ROUND(@avg_people/@total_seat*100) INTO @predict; ";
   $ret = mysqli_query($con, $sql);
   if(!$ret){
      echo "5 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
   }   

   $sql="SELECT @predict AS 'ratio';";
   $ret = mysqli_query($con, $sql);
   if(!$ret){
      echo "6 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
   }   
   $row= mysqli_fetch_array($ret);

   if ($ret) {
      if ($is_soldout==0) { // 매진된 적 없지만
         if ($is_drive<>0) { // 해당 경로 운행된 적은 있음
            echo "같은 노선의 같은 출발/도착 요일 운행의 매진 수: ",  $is_soldout, ", 운행 수: ", $is_drive, " <br> 등록되었습니다. <br> <br> 등록한 운행의 예상 탑승자 비율: ", $row['ratio'], "%";
         }
         else { // 매진된 적도 없고 해당 경로 운행된 적 없음
            echo "등록되었습니다.";
         }
      }
      else { // 매진된 적 있음
         echo "같은 노선의 같은 출발/도착 요일 운행의 매진 수: ",  $is_soldout, ", 운행 수: ", $is_drive, "  <br> 등록되었습니다. <br> <br> 매진될 경우 예상 매진 소요일: ", $days, "일, 등록한 운행의 예상 탑승자 비율: ", $row['ratio'], "%";
      }
   }
   else {
      echo "ERROR: ".mysqli_error($con);
   }

   $sql = "INSERT INTO drive_info VALUES(NULL, '".$start_time."','".$end_time."','".$landing_time."','".$checkin_time."', null, 0,'".$airnumber."','".$airline_name."','".$start_airport_name."','".$end_airport_name."', curdate(), NULL) ";
   $ret=mysqli_query($con, $sql);
   if(!$ret){
      echo "등록 실패"."<br>";
      echo "실패 원인: ".mysqli_error($con)."<br><br>";
   }

   $start_time2 = (str_replace("T", " ", $start_time)).":00";
   $end_time2 = (str_replace("T", " ", $end_time)).":00";
   $landing_time2 = (str_replace("T", " ", $landing_time)).":00";
   $checkin_time2 = (str_replace("T", " ", $checkin_time)).":00";

   $sql3_1 = "SELECT LAST_INSERT_ID(drive_number) AS last_drive_number
   FROM drive_info WHERE start_time='".$start_time2."' AND end_time='".$end_time2."' 
   AND landingtime='".$landing_time2."'AND checkintime='".$checkin_time2."'
   AND airplane_airnumber='".$airnumber."'AND airline_name='".$airline_name."'
   AND airport_airport_name_start='".$start_airport_name."'AND airport_airport_name_finish='".$end_airport_name."'
   ORDER BY drive_number DESC LIMIT 1;";

   $ret3_1 = mysqli_query($con, $sql3_1);
   if(!$ret3_1){
      echo "등록 비행기 조회 안됨. 실패 원인: ".mysqli_error($con)."<br><br>";
   }

   while($row = mysqli_fetch_array($ret3_1)) {
      $last_drive_number = $row["last_drive_number"];
   }

   $sql3_2 = "SELECT * FROM seat WHERE airplane_airnumber='".$airnumber."';";
   $ret3_2 = mysqli_query($con, $sql3_2);
   if (!$ret3_2) {
      echo "비행기 좌석 조회에 실패하였습니다. 실패 원인: ", mysqli_error($con);
      exit();
   }

   while($row = mysqli_fetch_array($ret3_2)) {
      $sql4 = "INSERT INTO passenger_seat VALUES('".$last_drive_number."','".$row['seatnumber']."','".$airnumber."', NULL)";
      $ret4 = mysqli_query($con, $sql4);
      if (!$ret4) {
          echo "비행기 좌석 동기화에 실패하였습니다. 실패 원인: ", mysqli_error($con);
          exit();
      }
  }
?>

<form method="POST" action="airline_loginCheck.php">
<input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
<input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
<input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
<br><br><input type="submit" value="메인으로 가기">
</form> 

<form method="POST" action="airline_driveinfo_register.php">
<input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
<input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
<input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
<br><input type="submit" value="운행정보 등록으로 돌아가기">
</form> 

</body>
</html>

<?php
  mysqli_close($con);
?>
