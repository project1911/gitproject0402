<?php
    //input: {"Username":"XX", "Password":"XXX", "Email":"XXXXX"}
    // {"state" : true, "message" : "註冊成功!"}
    // {"state" : false, "message" : "註冊失敗!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["Username"]) && isset($mydata["Password"]) && isset($mydata["Email"]) && $mydata["Username"] != "" && $mydata["Password"] != "" && $mydata["Email"] != ""){
            $p_Username = $mydata["Username"];
            //密碼加密PASSWORD_DEFAULT
            $p_Password = password_hash($mydata["Password"], PASSWORD_DEFAULT);
            $p_Email = $mydata["Email"];

            $servername = "localhost";
            $username = "owner";
            $password = "123456";
            $dbname = "hw";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "INSERT INTO member(Username, Password, Email, UID01, power) VALUES('$p_Username', '$p_Password', '$p_Email', '', '0')";
            if(mysqli_query($conn, $sql)){
                //新增成功
                echo '{"state" : true, "message" : "註冊成功!"}';
            }else{
                //新增失敗
                echo '{"state" : false, "message" : "註冊失敗!'.$p_Username.', '.$p_Password.', '.$p_Email.'"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>