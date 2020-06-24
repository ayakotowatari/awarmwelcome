<?php 
session_start();

$iuser_email = $_POST["email"];
$iuser_pw = $_POST["password"];

// $pw_hash = password_hash($lpw, PASSWORD_DEFAULT);

include("funcs.php");
$pdo = db_conn();

$sql = "SELECT * FROM iuser WHERE iuser_email=:email AND iuser_life=1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $iuser_email, PDO::PARAM_STR);
// $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
$status = $stmt->execute();

if($status==false){
    sql_error();
}

$val = $stmt->fetch();

if(password_verify($iuser_pw, $val["iuser_pw"])){
    $_SESSION["chk_ssid"] = session_id();
    // $_SESSION["kanri_flg"] = $val["kanri_flg"];
    $_SESSION["firstname"] = $val["iuser_firstname"];
    $_SESSION["iuser_id"] = $val["iuser_id"];
    $_SESSION["i_inst_id"] = $val["i_inst_id"];
    redirect("i_dboard.php");
}else{
    redirect("i_login.php");
}

// if($val["id"] !=""){
//     $_SESSION["chk_ssid"] = session_id();
//     $_SESSION["kanri_flg"] = $val["kanri_flg"];
//     $_SESSION["name"] = $val["name"];
//     redirect("index.php");
// }else{
//     redirect("login.php");
// }

exit();

?>