<?php 

$id = $_GET["id"];

session_start();

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "UPDATE rsv SET rsv_flg=0 WHERE rsv_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    sql_error($stmt);
  
  }else{
  
    redirect("s_user_account.php");
  
  }
?>