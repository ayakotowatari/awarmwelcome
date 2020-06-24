<?php 

session_start();

include("funcs.php");
$pdo = db_conn();
sschk();

// echo $_SESSION["stuser_id"];
$s_id = $_SESSION["stuser_id"];

$sql = "SELECT * 
FROM i_event 
JOIN rsv ON i_event.e_id = rsv.r_e_id
JOIN stuser ON rsv.r_stuser_id = stuser.stuser_id
JOIN inst ON i_event.e_inst_id = inst.inst_id
WHERE stuser.stuser_id = :id AND rsv.rsv_flg = 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $s_id, PDO::PARAM_INT);
  // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
$status = $stmt->execute();

$view = "";
if($status==false) {
    sql_error($stmt);
}else{
//   Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   .=は、+=と同じ。
    while($r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        $view .= '<div class="rsv_box mb60">';
        $view .= '<div class="rsv_cont">';
        $view .= '<div>';
        $view .= '<span class="e-date">'.$r["e_date"].'</span>';
        $view .= '<span class="event-time">'.$r["e_start_time"].' - </span>';
        $view .= '<span class="event-time">'.$r["e_end_time"].'</span>';
        $view .= '</div>';
        $view .= '<p class="e_inst">'.$r["inst_name"].'</p>';
        $view .= '<p class="e_title_40">'.$r["e_title"].'</p>';
        $view .= '<a href="e_detail.php?id='.$r["e_id"].'"><i class="fas fa-chevron-circle-right"></i>Details</a>';
        $view .= '<a href="e_qry.php?id='.$r["e_id"].'"><i class="fas fa-chevron-circle-right"></i>Ask questions</a>';
        $view .= '<a href="e_cxl.php?id='.$r["rsv_id"].'"><i class="fas fa-chevron-circle-right"></i>Cancel</a>';
        $view .= '</div>';
        $view .= '<div class="rsv_img">';
        $view .= '<img src="upload/'.$r["e_img"].'" alt="" class="rsv_img_size">';
        $view .= '</div>';
        $view .= "</div>";
    }
}

// $sql="SELECT *
// FROM i_event
// JOIN rsv ON i_event.e_id = rsv.r_e_id
// JOIN stuser ON rsv.r_stuser_id = stuser.stuser_id
// WHERE NOT stuser.stuser_id = :s_id";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':s_id', $s_id, PDO::PARAM_INT);
//   // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
// $status = $stmt->execute();

// $view2= "";
// if($status==false) {
//     sql_error($stmt);
// }else{
// //   Selectデータの数だけ自動でループしてくれる
// //   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// //   .=は、+=と同じ。
//     while($r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        
//         $view2 .= '<span class="e-date">'.$r["e_date"].'</span>';
//         $view2 .= '<span class="event-time">'.$r["e_start_time"].' - </span>';
//         $view2 .= '<span class="event-time">'.$r["e_end_time"].'</span>';
//         $view2 .= '<p>'.$r["e_title"].'</p>';
// }
// }

?>



<!DOCTYPE html>
<html lang="en">

<?php include("templates/s_header01.php")?>

<div class="inner">
    <h1 class="greet"><?=$_SESSION["firstname"]?>'s Page</h1>
</div>

<div class="container">

    <div class="heading">Your upcoming events</div>
    <?= $view?>

    <!-- <?=$view2?> -->

</div>
<?php include("templates/footer.php")?>
<?php include("templates/script.php")?>
</body>
</html>