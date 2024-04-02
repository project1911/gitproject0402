<?php
// input: {"Power":"X"}
// {"state" : true, "data": "會員資料", "message" : "管理員身分確認!"}
// {"state" : false, "message" : "非管理員身分，不可使用管理員權限!"}
// {"state" : false, "message" : "傳遞參數格式錯誤!"}
// {"state" : false, "message" : "未傳遞任何參數!"}

$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["Username"]) && isset($mydata["Power"]) && $mydata["Username"] != "" && $mydata["Power"] != "") {
        $p_Username = $mydata["Username"];
        $p_Power = $mydata["Power"];

        $servername = "localhost";
        $username = "owner";
        $password = "123456";
        $dbname = "hw";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        $sql = "SELECT Username, Power FROM member WHERE Username = '$p_Username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Power'] == $p_Power) {
                // 驗證成功
                $mydata = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $mydata[] = $row;
                }
                echo '{"state" : true, "data": ' . json_encode($mydata) . ' , "message" : "管理員身分確認!"}';
            } else {
                echo '{"state" : false, "data": ' . json_encode($mydata) . ' , "message" : "非管理員身分，不可使用管理員權限!"}';
            }
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
