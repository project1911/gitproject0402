<?php
    // {"state" : true, "data" : "所有會員資料", "message" : "讀取成功"}
    // {"state" : false, "message" : "讀取失敗"}

    $servername = "localhost";
    $username = "owner";
    $password = "123456";
    $dbname = "hw";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        die("連線失敗".mysqli_connect_error());
    }

    $sql = "SELECT * FROM member ORDER BY ID ASC";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $mydata = array();
        while($row = mysqli_fetch_assoc($result)){
            $mydata[] = $row;
        }
        echo '{"state" : true, "data": '.json_encode($mydata).', "message" : "讀取成功"}';
    }else{
        echo '{"state" : false, "message" : "讀取失敗"}';
    }
    

    mysqli_close($conn);
?>