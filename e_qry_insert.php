<?php 

if(
    !isset($_POST["category"]) || $_POST["category"]=="" ||
    !isset($_POST["qry"]) || $_POST["qry"]=="" 
    ){
    exit('ParamError');
    }

$qry = $_POST["qry"];
echo $qry;
$category = $_POST["category"];
$e_id = $_POST["e_id"];
$s_id = $_POST["s_id"];

session_start();

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "INSERT INTO e_qry(e_qry_id,e_qry_e_id,e_qry_stu_id,e_qry_typ_id,e_qry_cnt,indate)
VALUES(NULL,:e_id,:s_id,:category,:qry,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$stmt->bindValue(':s_id', $s_id, PDO::PARAM_INT);
$stmt->bindValue(':category', $category, PDO::PARAM_INT);
$stmt->bindValue(':qry', $qry, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
    sql_error();
}else{
  redirect("s_user_account.php");
}
exit();

?>