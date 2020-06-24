<?php 

$stuser_id = $_POST["st_id"];
$e_id = $_POST["e_id"];

// echo $stuser_id;
// // echo $e_id;

session_start();

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "INSERT INTO rsv(rsv_id,r_e_id,r_stuser_id,rsv_flg,indate)
VALUES(NULL,:e_id,:stuser_id,'1',sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stuser_id', $stuser_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();
  
  //４．データ登録処理後
  if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    sql_error($stmt);
  }else{
      redirect("s_user_account.php");
  }
  exit();








?>