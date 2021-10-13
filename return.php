<?php

// 创建连接
$conn = mysqli_connect($host,$servername,$password,$username );
if(!$conn){
    return $this->respText("Database connection fails");
}

$q = mysqli_query($conn,'SELECT code FROM `invitation_code` WHERE `status_wechat` = 0 limit 1 for update');


if($q == false){
    return $this->respText("数据库有错误，请联系管理员".PHP_EOL."微信号:******");
}

$query = $q->fetch_assoc();
$code = $query["code"];
// ret($conn,$code);
if($code == 0){
    return $this->respText("今日邀请码已派发完毕，请明早10点后重新发送".PHP_EOL."邀请码".PHP_EOL."关键词进行获取");
}

$sentry = mysqli_query($conn,"UPDATE `invitation_code` SET `status_wechat`='1' WHERE  `code`=".$code);
if(!$sentry){
    
    return $this->respText("邀请码为" .PHP_EOL.$code.PHP_EOL. "数据库有错误，请联系管理员手动派发。".PHP_EOL."微信号:******");
    // return $this->respText($code);
}
else {
    return $this->respText("您的邀请码是".PHP_EOL.$code.PHP_EOL."请注意尽快进行注册。");
    // return $this->respText($code);
}
$conn->close();
return ;
?>
