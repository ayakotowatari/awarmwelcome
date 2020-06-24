<?php 
if(isset($_POST["id"])){
  $id = $_POST["id"];
  // echo $search;
}else{
  $id = "";
}

session_start();

if(
    !isset($_POST["firstname"]) || $_POST["firstname"]=="" ||
    !isset($_POST["lastname"]) || $_POST["lastname"]=="" ||
    !isset($_POST["email"]) || $_POST["email"]=="" ||
    !isset($_POST["password"]) || $_POST["password"]=="" ||
    !isset($_POST["stu_cntry"]) || $_POST["stu_cntry"]=="" ||
    !isset($_POST["inst_cntry"]) || $_POST["inst_cntry"]=="" ||
    !isset($_POST["lvl"]) || $_POST["lvl"]=="" ||
    !isset($_POST["sbj"]) || $_POST["sbj"]=="" ||
    !isset($_POST["year"]) || $_POST["year"]=="" 
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
  $stu_cntry=$_POST["stu_cntry"];
  $inst_cntry=$_POST["inst_cntry"];
  $lvl= $_POST["lvl"];
  $sbj = $_POST["sbj"];
  $year = $_POST["year"];

  $pw_hash = password_hash($password, PASSWORD_DEFAULT);
  
  // foreach ($tags as $value){
  //   $tag_id = $value.'<br />';
  //   echo $tag_id;
  // }
  
  
  // 2. DB接続します
  include("funcs.php");
  $pdo = db_conn();
  
  
  //３．データ登録SQL作成

    $sql = "INSERT INTO stuser(stuser_id,stuser_firstname,stuser_lastname,stuser_pw,stuser_email,s_stucntry_id,s_year_id,stuser_life,indate)VALUES(NULL,:firstname,:lastname,:pw,:email,:stucntry_id,:year_id,'1',sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':pw', $pw_hash, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':stucntry_id', $stu_cntry, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':year_id', $year, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute();

    // if($status==false){
    //           sql_error();
    // }else{
    //     redirect("index.php");
    // }
    $stuser_id = $pdo->lastInsertId();

    $sql = "INSERT INTO stuser_lvl_map VALUES(NULL,:stuser_id,:lvl_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':stuser_id', $stuser_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':lvl_id', $lvl, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute();

    $sql = "INSERT INTO s_year VALUES(NULL,:s_year)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':s_year', $year, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute();

    foreach($inst_cntry as $val_cntry){
        $sql = "INSERT INTO stuser_icntry_map VALUES(NULL,:stuser_id,:icntry_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':stuser_id', $stuser_id, PDO::PARAM_INT);
        $stmt->bindValue(':icntry_id', $val_cntry, PDO::PARAM_INT);
        // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
        $status = $stmt->execute();
    }

    foreach($sbj as $val_sbj){
        $sql = "INSERT INTO sbj_stuser_map VALUES(NULL,:stuser_id,:sbj_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':stuser_id', $stuser_id, PDO::PARAM_INT);
        $stmt->bindValue(':sbj_id', $val_sbj, PDO::PARAM_INT);
        // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
        $status = $stmt->execute();
    }

    $sql = "SELECT * FROM stuser WHERE stuser_id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $stuser_id, PDO::PARAM_INT);
    // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
    $status = $stmt->execute();
  
  if($status==false){
      sql_error();
  }else{
    $val = $stmt->fetch();
  
    $_SESSION["chk_ssid"] = session_id();
    // $_SESSION["kanri_flg"] = $val["kanri_flg"];
    $_SESSION["firstname"] = $val["stuser_firstname"];
    // echo $_SESSION["firstname"];
    $_SESSION["stuser_id"] = $val["stuser_id"];
    // echo $_SESSION["stuser_id"];
    if($id > 0){
      redirect("e_detail.php?id=$id");
    }else{
      redirect("index.php");
  }
  }
  exit();
  ?>
  