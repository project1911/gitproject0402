<?php
    //inpu: {"ID":"XX", "Email":"XXXXX"}
    //{"state" : true, "message" : "更新成功!"}
    //{"state" : false, "message" : "更新失敗!"}
    //{"state" : false, "message" : "傳遞參數格式錯誤!"}
    //{"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["id"]) && isset($mydata["title"]) && isset($mydata["content"]) && $mydata["id"] != "" && $mydata["title"] != "" && $mydata["content"] != ""){
            $p_id = $mydata["id"];
            $p_title = $mydata["title"];
            $p_content = $mydata["content"];

            $servername = "localhost";
            $username = "owner";
            $password = "123456";
            $dbname = "hw";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "UPDATE created SET title = '$p_title', content = '$p_content' WHERE id = '$p_id'";
            if(mysqli_query($conn, $sql)){
                //更新成功
                echo '{"state" : true, "message" : "更新成功!"}';
            }else{
                //更新失敗
                echo '{"state" : false, "message" : "更新失敗!'.$sql.'"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>