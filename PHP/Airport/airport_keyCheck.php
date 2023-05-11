<?php

$security_key=$_POST['security_key'];
if($security_key!="epdlxjqpdltm"){
    echo "<h2>보안키가 일치하지 않습니다.</h2>";
    echo "<A href='airport_key.html'>다시 입력하기</A>";
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>공항 메인 페이지</title>
        <meta charset="utf-8">
    </head>

    <body>
        <form action="airport_main.html">
            <h1>보안키가 올바릅니다.</h1>
            <input type="submit">
        </form>
        
    </body>
</html>