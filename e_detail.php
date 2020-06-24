<?php 

$id = $_GET["id"];
// echo $id;

session_start();
// echo $_SESSION["stuser_id"];

include("funcs.php");
$pdo = db_conn();

$sql = "SELECT *
FROM i_event 
JOIN inst ON i_event.e_inst_id = inst.inst_id
JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
WHERE i_event.e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
$r_e = $stmt->fetch();
    
    // $view .= '<div class="e_time">';
    // $view .= '<div>';
    // $view .= '<span class="event-date">'.$r_e["e_date"].'</span>';
    // $view .= '</div>';
    // $view .= '<div>';
    // $view .= '<span class="event-time">'.$r_e["e_start_time"].'</span>';
    // $view .= '<span> - </span>';
    // $view .= '<span class="event-time">'.$r_e["e_end_time"].'</span>';
    // $view .= '</div>';
    // $view .= '</div>';
    $view .= '<p class="univ-name">'.$r_e["inst_name"].', <span>'.$r_e["icntry"].'</span></p>';
    $view .= '<p class="event-title">'.$r_e["e_title"].'</p>';
    $view .= '<p class="event-description">'.$r_e["e_dtl"].'</p>';
   
  }
  


$sql = "SELECT *
FROM i_event 
JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
WHERE i_event.e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

$view_lvl="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view_lvl .= "<span>".$r["lvl"]."  </span>";
  }
}

$sql = "SELECT *
FROM i_event 
JOIN e_sbj_map ON i_event.e_id = e_sbj_map.es_e_id
JOIN sbj ON e_sbj_map.es_sbj_id = sbj.sbj_id
WHERE i_event.e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

$view_sbj="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view_sbj .= "<span>".$r["sbj"]." </span>";
  }
}

$sql = "SELECT *
FROM i_event 
JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
WHERE i_event.e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

$view_rgn="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view_rgn .= "<span>".$r["rgn"]." </span>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/s_header01.php")?>
<div class="inner">

    
        <div class="e_time">
          <div>
            <span class="event-date"><?=$r_e["e_date"]?></span>
          </div>
          <div>
            <span class="event-time"><?=$r_e["e_start_time"]?></span>
            <span> - </span>
            <span class="event-time"><?=$r_e["e_end_time"]?></span>
          </div>
        </div>
        <div class="e_detail">
          <div class="e_cont">
            <?= $view ?>
          </div>
          <div class="e_imgLarger">
            <img src="upload/<?=$r_e["e_img"]?>" class="event_img" alt="">
          </div>
        </div>
          <div class="e_infoLarger">Level: <span><?= $view_lvl?></span></div> 
          <div class="e_infoLarger">Subject areas: <span><?= $view_sbj?></span></div>
          <div class="e_infoLarger">Suitable for students from <span><?= $view_rgn?></span> region.</div>


<?php if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){?>
    <a href="stu_signup.php?id=<?=$id?>" class="e_book">Book</a>
<?php } else { ?>
    <a href="e_rsv.php?id=<?=$id?>" class="e_book">Book</a>
<?php } ?>
</div>
<?php include("templates/footer.php") ?>
</body>
</html>