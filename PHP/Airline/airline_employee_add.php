
<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//직원 상세 페이지 추가 버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
$airline_name=$_POST['airline_name'];

$employee_number= $_POST["employee_number"];
$drive_number= $_POST["drive_number"];

$sql = "SELECT workstate FROM airline_employee WHERE airline_employee.airline_name='".$airline_name."' 
           AND employee_number='".$employee_number."';";

$ret=mysqli_query($con, $sql);
if(!$ret)
{
    echo "일치하는 직원 조회 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
    exit();
}

while($row = mysqli_fetch_array($ret)){
  $workstate=$row['workstate'];
}

if($workstate='재직') {
$sql2="INSERT INTO passenger_employee VALUES ('".$drive_number."','".$employee_number."')";
}

$ret2=mysqli_query($con, $sql2);
echo "<h3> 추가 결과 </h3>";
if($ret2)
{
    echo "데이터가 성공적으로 추가됨.";     
}
else
{
    echo "데이터 입력 실패"."<br>";
    echo "실패 원인 :".mysqli_error($con);
    exit();
}

mysqli_close($con); 
?>

<form method="post" action="airline_employee_arrange.php">

    <input type="hidden" value=<?php echo $airline_pw ?>  name=airline_pw READONLY>
    <input type="hidden" value=<?php echo $airline_id ?> name=airline_id READONLY>
    <input type="hidden" value=<?php echo $airline_name ?> name=airline_name READONLY>
    <input type="hidden" value=<?php echo $drive_number ?> name=drive_number READONLY>

    <input type="submit" value="이전으로" > 
    <br><br>     
</form>