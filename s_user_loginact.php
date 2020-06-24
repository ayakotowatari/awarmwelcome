<?php 

if(isset($_POST["id"])){
    $id = $_POST["id"];
    // echo $search;
  }else{
    $id = "";
  }

session_start();

$suser_email = $_POST["email"];
$suser_pw = $_POST["password"];

// $pw_hash = password_hash($lpw, PASSWORD_DEFAULT);

include("funcs.php");
$pdo = db_conn();

$sql = "SELECT * FROM stuser WHERE stuser_email=:email AND stuser_life=1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $suser_email, PDO::PARAM_STR);
// $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
$status = $stmt->execute();

if($status==false){
    sql_error();
}

$val = $stmt->fetch();

if(password_verify($suser_pw, $val["stuser_pw"])){
    $_SESSION["chk_ssid"] = session_id();
    // $_SESSION["kanri_flg"] = $val["kanri_flg"];
    $_SESSION["firstname"] = $val["stuser_firstname"];
    $_SESSION["stuser_id"] = $val["stuser_id"];
    // redirect("index.php");
    if($id > 0){
        redirect("e_detail.php?id=$id");
    }else{
        redirect("index.php");
    }
}else{
    redirect("stu_login.php");
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