<?php
//1.POSTでid,name,email,naiyouを取得

session_start();

$e_dtl = $_POST["e_detail"];
$id = $_POST["id"];


//2.DB接続
include("funcs.php");
$pdo = db_conn();
$file_name = fileUpload("upfile", "upload/");

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
$sql = "UPDATE i_event SET e_dtl=:e_dtl,e_img=:e_img
WHERE e_id=:e_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':e_dtl', $e_dtl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':e_img', $file_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':e_id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  sql_error($stmt);

}else{
  redirect("i_e_detail.php?id=$id");

}