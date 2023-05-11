<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Page Title</title>
    </head>
    <body>
   <h5>항공기 예매 시스템</h5>
<h1>고객 로그인 페이지</h1>

<?php
$con=mysqli_connect("localhost", "root", "1024", "mydb") or die("MySQL 접속 실패");
$userid=$_POST['userID'];
$userpw=$_POST['userPW'];

$sql="SELECT * FROM member where id ='".$userid."' AND pw='".$userpw."' ";
$ret = mysqli_query($con, $sql);
if ($ret) {
  $row = mysqli_fetch_array($ret);
  if ($row){
    $username = $row["name"];
    echo $username, " 님 로그인되었습니다! <br><br>";
    echo "<form method='post' action='client_ticketing1.html'>";
    echo "<input type='hidden' name='userid' value='".$userid."'>";
    echo "<input type='hidden' name='username' value='".$username."'>";
    echo "<input type='submit' value='비행기 예매하기'>";
  }
  else { 
    echo "존재하지 않는 아이디거나 잘못된 비밀번호입니다."."<br>";
    echo "<br><br><A href='client_login.html'>다시 로그인 하기</A><br>"; 
  }
}
else {
  echo "ERROR";
  exit();
}

?>

</body>
</html>