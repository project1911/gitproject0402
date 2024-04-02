<?php
    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["title"]) && isset($mydata["content"]) && isset($mydata["creater"]) && $mydata["title"] != "" && $mydata["content"] != "" && $mydata["creater"] != ""){
            $p_title = $mydata["title"];
            $p_content = $mydata["content"];
            $p_creater = $mydata["creater"];

            $servername = "localhost";
            $username = "owner";
            $password = "123456";
            $dbname = "hw";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "INSERT INTO created(title, content, creater) VALUES('$p_title', '$p_content', '$p_creater')";
            if(mysqli_query($conn, $sql)){
                //創作成功
                echo '{"state" : true, "message" : "創作成功!"}';
            }else{
                //創作失敗
                echo '{"state" : false, "message" : "創作失敗!"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>