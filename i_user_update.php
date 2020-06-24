<?php
//1.POSTでid,name,email,naiyouを取得

$firstname=$_POST["firstname"];
$lastname=$_POST["lastname"];
$email=$_POST["email"];
$password=$_POST["password"];
$jobtitle=$_POST["jobtitle"];
$department=$_POST["department"];
$iuser_id = $_POST["iuser_id"];

  $pw_hash = password_hash($password, PASSWORD_DEFAULT);


//2.DB接続
include("funcs.php");
$pdo = db_conn();

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
$stmt = $pdo->prepare("UPDATE iuser SET iuser_firstname=:firstname,iuser_lastname=:lastname,iuser_pw=:pw,iuser_email=:email,j_title=:j_title,dept=:dept WHERE iuser_id=:iuser_id");
$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pw', $pw_hash, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':j_title', $jobtitle, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':dept', $department, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':iuser_id', $iuser_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  sql_error($stmt);

}else{
  //select.phpへリダイレクト
  $_SESSION["iuser_id"] = $iuser_id;
//   echo $_SESSION["iuser_id"];
  redirect("i_user_account.php");

}