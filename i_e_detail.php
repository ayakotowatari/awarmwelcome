<?php 

$id = $_GET["id"];

session_start();

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
    // $view .= '<p class="univ-name">'.$r_e["inst_name"].', <span>'.$r_e["icntry"].'</span></p>';
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

//参加者数
$sql = "SELECT COUNT(*) as reg_num
FROM rsv
WHERE r_e_id = :id AND rsv_flg=1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

$view_num="";
if($status==false) {
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
    $r_num = $stmt->fetch();
}

// 質問数

$sql = "SELECT COUNT(*) as qry_num
FROM e_qry WHERE e_qry_e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
  sql_error($stmt);
}else{
  $r_qry = $stmt->fetch();
}

// 質問タイプと内容
$sql = "SELECT e_qry_typ,e_qry_cnt
FROM e_qry_typ
JOIN e_qry ON e_qry_typ.ee_qry_typ_id = e_qry.e_qry_typ_id
WHERE e_qry.e_qry_e_id = :id
ORDER BY ee_qry_typ_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$view_qc = "";
if($status==false) {
  sql_error($stmt);
}else{
  while($r_qc = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view_qc .= "<tr>";
    $view_qc .= "<td>".$r_qc["e_qry_typ"]." </td>";
    $view_qc .= "<td>".$r_qc["e_qry_cnt"]." </td>";
    $view_qc .= "</tr>";
  }
}

// 参加者リスト
$sql = "SELECT * 
FROM rsv
JOIN stuser ON rsv.r_stuser_id = stuser.stuser_id
JOIN stu_cntry ON stuser.s_stucntry_id = stu_cntry.stucntry_id
JOIN stuser_lvl_map ON stuser_lvl_map.sl_stuser_id = rsv.r_stuser_id
JOIN lvl ON stuser_lvl_map.sl_lvl_id = lvl.lvl_id
JOIN s_year ON stuser.s_year_id = s_year.year_id
WHERE rsv.r_e_id = :id AND rsv.rsv_flg=1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

$view_rgts="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view_rgts .= "<tr>";
    $view_rgts .= "<td>".$r["stuser_firstname"]." </td>";
    $view_rgts .= "<td>".$r["stuser_lastname"]." </td>";
    $view_rgts .= "<td>".$r["stuser_email"]." </td>";
    $view_rgts .= "<td>".$r["stucntry"]." </td>";
    $view_rgts .= "<td>".$r["lvl"]." </td>";
    $view_rgts .= "<td>".$r["year_start"]." </td>";
    $view_rgts .= "</tr>";
  }
}
?>

<!DOCTYPE html>

<?php include("templates/i_header01.php")?>

<div class="inner">

  <h1 class="heading">Event Details</h1>

  <a href="i_e_updateview.php?id=<?=$id?>" class="e_edit"><i class="fas fa-chevron-circle-right"></i>Edit event details</a>

  <div class="mb60">
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
        <div class="e_detail_small">
          <div class="e_cont">
            <?= $view ?>
          </div>
          <div class="e_imgLarger">
            <img src="upload/<?=$r_e["e_img"]?>" class="event_img" alt="">
          </div>
        </div>
        <div class="e_infoSmaller">Level: <span><?= $view_lvl?></span></div> 
        <div class="e_infoSmaller">Subject areas: <span><?= $view_sbj?></span></div>
        <div class="e_infoSmaller">Suitable for students from <span><?= $view_rgn?></span> region.</div>
  </div>
    
  <div class="reg mb60">
      <h2 class="sub_heading">Participants</h2>
      <?php if($r_num["reg_num"]>0){?>
      <div class="mb20">You have <?= $r_num["reg_num"]?> registerants for this event.</div>

          <?php if($r_num["reg_num"]>0){?>
          <div id="p_list" class="pointer mb20"><i class="fas fa-chevron-circle-right"></i>Participants list</div>

          <div class="reg_table" id="p_table">
            <table >
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Level of Study</th>
                    <th>Year to Start</th>
                </tr>
                
                    <?= $view_rgts ?>
            </table>
          </div>

            <div class="pointer mb20"><i class="fas fa-chevron-circle-right"></i><a href="i_e_chart.php?id=<?=$id?>">Student statistics</a></div>

          <?php } ?>

        <?php }else{ ?>
            <div>You have no registrants for this event.</div>
        <?php } ?>
  </div>

    <div class="reg mb80">
      <h2 class="sub_heading">Questions from students</h2>
      <?php if($r_qry["qry_num"]>0){?>
        <div class="mb20">You have <?=$r_qry["qry_num"]?> questions sent from students.</div>

        <div id="q_list" class="pointer mb20"><i class="fas fa-chevron-circle-right"></i>List of questions</div>

        <div class="q_table" id="q_table">
          <table>
            <tr>
                <th>Category</th>
                <th>Content</th>
            </tr>
                <?= $view_qc ?>
          </table>
        </div>
    

      <?php }else{ ?>
      <div>You have no questions sent from students.</div>
      <?php } ?>
    </div>

</div>

<?php include("templates/i_footer.php")?>
<?php include("templates/script.php")?>

<script>

const pList = document.querySelector("#p_list");

pList.addEventListener("click", function(){
  const pTable = document.querySelector("#p_table");
  
    if(pTable.style.display =="none"){
      pTable.style.display = "block";
    }else{
      pTable.style.display = "none";
    }
})

const qList = document.querySelector("#q_list");

qList.addEventListener("click", function(){
  const qTable = document.querySelector("#q_table");

    if(qTable.style.display =="none"){
      qTable.style.display = "block";
    }else{
      qTable.style.display = "none";
    }
})


</script>
    
</body>
</html>