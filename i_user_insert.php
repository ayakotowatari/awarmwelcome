<?php 
session_start();

if(
    !isset($_POST["firstname"]) || $_POST["firstname"]=="" ||
    !isset($_POST["lastname"]) || $_POST["lastname"]=="" ||
    !isset($_POST["email"]) || $_POST["email"]=="" ||
    !isset($_POST["password"]) || $_POST["password"]=="" ||
    !isset($_POST["jobtitle"]) || $_POST["jobtitle"]=="" ||
    !isset($_POST["department"]) || $_POST["department"]=="" ||
    !isset($_POST["inst_id"]) || $_POST["inst_id"]==""
  ){
    exit('ParamError');
  }
  
  //1. POSTデータ取得
  //$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
  //$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
  
  $firstname=$_POST["firstname"];
  $lastname=$_POST["lastname"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $jobtitle=$_POST["jobtitle"];
  $department=$_POST["department"];
  $inst_id = $_POST["inst_id"];

  $pw_hash = password_hash($password, PASSWORD_DEFAULT);
  
  // foreach ($tags as $value){
  //   $tag_id = $value.'<br />';
  //   echo $tag_id;
  // }
  
  
  // 2. DB接続します
  include("funcs.php");
  $pdo = db_conn();
  // try {
  //   //Password:MAMP='root',XAMPP=''
  //   // 最後の2つは、'id', 'password'
  //   $pdo = new PDO('mysql:dbname=ayakotowatari_bookmark_db;charset=utf8;host=mysql57.ayakotowatari.sakura.ne.jp','ayakotowatari','Shih0001');
  // } catch (PDOException $e) {
  //   exit('DBConnectError:'.$e->getMessage());
  // }
  
  //３．データ登録SQL作成
  
    $stmt = $pdo->prepare("INSERT INTO iuser(iuser_id,iuser_firstname,iuser_lastname,iuser_pw,iuser_email,j_title,dept,i_inst_id,iuser_life,indate)VALUES(NULL,:firstname,:lastname,:pw,:email,:j_title,:dept,:i_inst_id, '1',sysdate())");
    $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':pw', $pw_hash, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':j_title', $jobtitle, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':dept', $department, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':i_inst_id', $inst_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute();
  
  //４．データ登録処理後
  if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    sql_error($stmt);
  }

  $iuser_id = $pdo->lastInsertId();

  $sql = "SELECT * FROM iuser WHERE iuser_id=:id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':id', $iuser_id, PDO::PARAM_INT);
  // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
  $status = $stmt->execute();

if($status==false){
    sql_error();
}else{
  $val = $stmt->fetch();

  $_SESSION["chk_ssid"] = session_id();
  // $_SESSION["kanri_flg"] = $val["kanri_flg"];
  $_SESSION["firstname"] = $val["iuser_firstname"];
  // echo $_SESSION["firstname"];
  $_SESSION["iuser_id"] = $val["iuser_id"];
  // echo $_SESSION["iuser_id"];
  $_SESSION["i_inst_id"] = $val["i_inst_id"];
  redirect("i_dboard.php");
}
exit();
  ?>
  