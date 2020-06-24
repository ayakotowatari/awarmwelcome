<?php 
session_start();

if(
!isset($_POST["e_title"]) || $_POST["e_title"]=="" ||
!isset($_POST["date"]) || $_POST["date"]=="" ||
!isset($_POST["starttime"]) || $_POST["starttime"]=="" ||
!isset($_POST["endtime"]) || $_POST["endtime"]=="" ||
!isset($_POST["e_detail"]) || $_POST["e_detail"]=="" ||
!isset($_POST["lvl"]) || $_POST["lvl"]=="" ||
!isset($_POST["sbj"]) || $_POST["sbj"]=="" ||
!isset($_POST["rgn"]) || $_POST["rgn"]=="" ||
!isset($_POST["inst_id"]) || $_POST["inst_id"]=="" ||
!isset($_POST["iuser_id"]) || $_POST["iuser_id"]=="" 
){
exit('ParamError');
}
  
  //1. POSTデータ取得
  //$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
  //$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
  
  $e_title=$_POST["e_title"];
//   echo $e_title;
  $date=$_POST["date"];
//   echo $date;
  $starttime=$_POST["starttime"];
//   echo $starttime;
  $endtime=$_POST["endtime"];
//   echo $endtime;
  $e_detail=$_POST["e_detail"];
//   echo $e_detail;
  $lvl=$_POST["lvl"];
//   echo $lvl;
  $sbj=$_POST["sbj"];
//   echo $sbj;
  $rgn= $_POST["rgn"];
//   echo $rgn;
  $inst_id = $_POST["inst_id"];
//   echo $inst_id;
  $iuser_id = $_POST["iuser_id"];
//   echo $iuser_id;
  
  // foreach ($tags as $value){
  //   $tag_id = $value.'<br />';
  //   echo $tag_id;
  // }
  
  
  // 2. DB接続します
  include("funcs.php");
  sschk();
  $pdo = db_conn();
  $file_name = fileUpload("upfile", "upload/");
  
  
  //３．データ登録SQL作成

    $sql = "INSERT INTO i_event(e_id,e_title,e_inst_id,e_date,e_start_time,e_end_time,e_dtl,e_img,e_status,e_iuser_id,indate)VALUES(NULL,:title,:inst_id,:e_date,:e_stime,:e_etime,:e_dtl,:e_img,'1',:iuser_id,sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $e_title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':inst_id', $inst_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':e_date', $date, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':e_stime', $starttime, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':e_etime', $endtime, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':e_dtl', $e_detail, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':e_img', $file_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':iuser_id', $iuser_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute();

    // if($status==false){
    //           sql_error();
    // }else{
    //     redirect("index.php");
    // }
    $e_id = $pdo->lastInsertId();

    foreach($lvl as $val_lvl){
        $sql = "INSERT INTO e_lvl_map VALUES(NULL,:e_id,:lvl_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':lvl_id', $val_lvl, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $status = $stmt->execute();
    }  

    foreach($sbj as $val_sbj){
        $sql = "INSERT INTO e_sbj_map VALUES(NULL,:e_id,:sbj_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);
        $stmt->bindValue(':sbj_id', $val_sbj, PDO::PARAM_INT);
        // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
        $status = $stmt->execute();
    }

    foreach($rgn as $val_rgn){
        $sql = "INSERT INTO e_rgn_map VALUES(NULL,:e_id,:rgn_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);
        $stmt->bindValue(':rgn_id', $val_rgn, PDO::PARAM_INT);
        // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
        $status = $stmt->execute();
    }

  if($status==false){
      sql_error();
  }else{
    redirect("i_e_list.php");
  }
  exit();
  ?>

  
  






