<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
$airline_name=$_POST["airline_name"];
$drive_number=$_POST["drive_number"];


$airplane_airnumber = "SELECT * FROM drive_info WHERE drive_number='".$drive_number."' ";
   $ret2 = mysqli_query($con, $airplane_airnumber);
   $row2 = mysqli_fetch_array($ret2);
   $airplane_airnumber= $row2['airplane_airnumber'];

$start_time=$_POST["start_time"];
$end_time=$_POST["end_time"];
$airport_airport_name_start=$_POST["airport_airport_name_start"];
$airport_airport_name_finish=$_POST["airport_airport_name_finish"];
$landingtime=$_POST["landingtime"];
$checkintime=$_POST["checkintime"];

$sql="UPDATE drive_info SET airplane_airnumber='".$airplane_airnumber."', airport_airport_name_start='".$airport_airport_name_start."', 
airport_airport_name_finish='".$airport_airport_name_finish."', start_time='".$start_time."', 
end_time='".$end_time."', landingtime='".$landingtime."', checkintime='".$checkintime."' 
WHERE drive_info.airline_name = '".$airline_name."' AND drive_number='".$drive_number."'";

$ret=mysqli_query($con, $sql);

echo "<h3> 수정 결과 </h3>";
if($ret)
{
    echo "수정 완료";
}
else{
    echo "수정 실패"."<br>";
    echo "실패 원인:".mysqli_error($con);
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
        <form method="POST" action="airline_loginCheck.php">
            <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
            <input type="hidden" value=<?php echo $airline_pw ?> name=airline_pw READONLY>
            <br><input type="submit" value="메인화면 이동">
        </form>
    </body>
</html>