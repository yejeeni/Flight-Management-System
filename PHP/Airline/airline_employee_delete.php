
<?php 
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패!!");

//직원 상세 페이지 삭제 버튼

$airline_id=$_POST['airline_id'];
$airline_pw=$_POST['airline_pw'];
$airline_name=$_POST['airline_name'];

$employee_number= $_POST["employee_number"];
$drive_number=$_POST['drive_number'];

$sql="DELETE FROM passenger_employee 
WHERE passenger_employee.airline_employee_employee_number = '".$employee_number."'
AND passenger_employee.drive_info_drive_number = '".$drive_number."';";

$ret=mysqli_query($con, $sql);
echo "<h3> 삭제 결과 </h3>";
if($ret)
{
    echo "데이터가 성공적으로 삭제됨.";    
}
else
{
    echo "데이터 삭제 실패"."<br>";
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