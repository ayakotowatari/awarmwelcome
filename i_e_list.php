<?php 
session_start();

$inst_id = $_SESSION["i_inst_id"];

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "SELECT *
FROM i_event 
WHERE e_inst_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $inst_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{

  if($stmt->rowCount() > 0){
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="e_list_box mb60">';  
    $view .= '<div class="e_list_cont">';
    $view .= '<span class="e-date">'.$r["e_date"].'</span>';
    $view .= '<span class="event-time">'.$r["e_start_time"].' - </span>';
    $view .= '<span class="event-time">'.$r["e_end_time"].'</span>';
    $view .= '<p class="e_title_40 e_title_large">'.$r["e_title"].'</p>';
    $view .= '<a href="i_e_detail.php?id='.$r["e_id"].'"><i class="fas fa-chevron-circle-right"></i>Details</a>';
    $view .= '</div>';
    $view .= '<div class="rsv_img">';
    $view .= '<img src="upload/'.$r["e_img"].'" class="rsv_img_size">';
    $view .= '</div>';
    $view .= "</div>";
  }
}else{
  $view .= '<p class="mb60">You have no events registered.</p>';
}
}

        // $view .= '<div class="rsv_box mb60">';
        // $view .= '<div class="rsv_cont">';
        // $view .= '<div>';
        // $view .= '<span class="e-date">'.$r["e_date"].'</span>';
        // $view .= '<span class="event-time">'.$r["e_start_time"].' - </span>';
        // $view .= '<span class="event-time">'.$r["e_end_time"].'</span>';
        // $view .= '</div>';
        // $view .= '<p class="e_inst">'.$r["inst_name"].'</p>';
        // $view .= '<p class="e_title_40">'.$r["e_title"].'</p>';
        // $view .= '<a href="e_detail.php?id='.$r["e_id"].'"><i class="fas fa-chevron-circle-right"></i>Details</a>';
        // $view .= '<a href="e_qry.php?id='.$r["e_id"].'"><i class="fas fa-chevron-circle-right"></i>Ask questions</a>';
        // $view .= '<a href="e_cxl.php?id='.$r["rsv_id"].'"><i class="fas fa-chevron-circle-right"></i>Cancel</a>';
        // $view .= '</div>';
        // $view .= '<div class="rsv_img">';
        // $view .= '<img src="upload/'.$r["e_img"].'" alt="" class="rsv_img_size">';
        // $view .= '</div>';
        // $view .= "</div>";

$sql = "SELECT * from inst WHERE inst_id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $inst_id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
    sql_error();
}else{
    $r_inst = $stmt->fetch();
}



?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/i_header01.php")?>

<div class="inner">
  <h1 class="greet"><?= $r_inst["inst_name"]?></h1>
</div>

<div class="container">
    <h1 class="heading">Events List</h1>
    
    
  
        <?= $view ?>


</div>
    <?php include("templates/i_footer.php")?>
</body>
</html>