<?php 
session_start();

$s_id = $_SESSION["stuser_id"];

//*******************************
//１．searchの値をチェック
//*******************************
if(isset($_POST["dest"])){
  $dest = $_POST["dest"];
  // echo $search;
}else{
  $dest = "";
}

if(isset($_POST["rgn"])){
  $rgn = $_POST["rgn"];
  // echo $search;
}else{
  $rgn = "";
}

if(isset($_POST["lvl"])){
  $lvl = $_POST["lvl"];
  // echo $search;
}else{
  $lvl = "";
}


include("funcs.php");
$pdo = db_conn();

// Search結果の抽出

if($dest !="" AND $rgn !="" AND $lvl !=""){

  $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
  FROM i_event 
  JOIN inst ON i_event.e_inst_id = inst.inst_id
  JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
  JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
  JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
  JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
  JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
  WHERE icntry.icntry_id = :dest AND rgn.rgn_id = :rgn AND lvl.lvl_id = :lvl";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':dest', $dest, PDO::PARAM_INT);
  $stmt->bindValue(':rgn', $rgn, PDO::PARAM_INT);
  $stmt->bindValue(':lvl', $lvl, PDO::PARAM_INT);
  $status = $stmt->execute();

}else{
  if($rgn !="" AND  $lvl !=""){

    $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
    FROM i_event 
    JOIN inst ON i_event.e_inst_id = inst.inst_id
    JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
    JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
    JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
    JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
    JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
    WHERE rgn.rgn_id = :rgn AND lvl.lvl_id = :lvl";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':rgn', $rgn, PDO::PARAM_INT);
    $stmt->bindValue(':lvl', $lvl, PDO::PARAM_INT);
    $status = $stmt->execute();

  }else if($dest !="" AND $lvl !=""){

    $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
    FROM i_event 
    JOIN inst ON i_event.e_inst_id = inst.inst_id
    JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
    JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
    JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
    JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
    JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
    WHERE icntry.icntry_id = :dest AND lvl.lvl_id = :lvl";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':dest', $dest, PDO::PARAM_INT);
    $stmt->bindValue(':lvl', $lvl, PDO::PARAM_INT);
    $status = $stmt->execute();

  }else if ($dest !="" AND $rgn !=""){
    $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
    FROM i_event 
    JOIN inst ON i_event.e_inst_id = inst.inst_id
    JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
    JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
    JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
    JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
    JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
    WHERE icntry.icntry_id = :dest AND rgn.rgn_id = :rgn";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':dest', $dest, PDO::PARAM_INT);
    $stmt->bindValue(':rgn', $rgn, PDO::PARAM_INT);
    $status = $stmt->execute();

  }else if ($dest !=""){
    $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
    FROM i_event 
    JOIN inst ON i_event.e_inst_id = inst.inst_id
    JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
    JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
    JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
    JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
    JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
    WHERE icntry.icntry_id = :dest";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':dest', $dest, PDO::PARAM_INT);
    $status = $stmt->execute();

  }else if ($rgn !=""){
    $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
    FROM i_event 
    JOIN inst ON i_event.e_inst_id = inst.inst_id
    JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
    JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
    JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
    JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
    JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
    WHERE rgn.rgn_id = :rgn";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':rgn', $rgn, PDO::PARAM_INT);
    $status = $stmt->execute();

  }else if ($lvl !=""){
    $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
    FROM i_event 
    JOIN inst ON i_event.e_inst_id = inst.inst_id
    JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
    JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
    JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
    JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
    JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id
    WHERE lvl.lvl_id = :lvl";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':lvl', $lvl, PDO::PARAM_INT);
    $status = $stmt->execute();

  }else{
  $sql = "SELECT inst_name, icntry, e_title, e_date, lvl, e_id, rgn, e_img
  FROM i_event 
  JOIN inst ON i_event.e_inst_id = inst.inst_id
  JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
  JOIN e_rgn_map ON i_event.e_id = e_rgn_map.er_e_id
  JOIN rgn ON e_rgn_map.er_rgn_id = rgn.rgn_id
  JOIN e_lvl_map ON i_event.e_id = e_lvl_map.el_e_id
  JOIN lvl ON e_lvl_map.el_lvl_id = lvl.lvl_id";
  $stmt = $pdo->prepare($sql);
  $status = $stmt->execute();
}
}


$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // .=は、+=と同じ。
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="e_list">';
    $view .= '<div class="cont_l">';
    $view .= '<p class="e_date">'.$r["e_date"].'</p>';
    $view .= '<p class="e_inst">'.$r["inst_name"].', '.$r["icntry"].'</p>';
    $view .= '<p class="e_title">'.$r["e_title"].'</p>';
    $view .= '<div class="flex">';
    $view .= '<span class="e_info">Level: '.$r["lvl"].'</span>';
    $view .= '<span class="e_info">Suitable for students in '.$r["rgn"].' region.</span>';
    $view .= "</div>";
    $view .= '</div>';
    $view .= '<div class="cont_r">';
    $view .= '<div>';
    $view .='<img src="upload/'.$r["e_img"].'" class="e_img_thumbnail" alt="">';
    $view .= '</div>';
    $view .= "<div>";
    $view .= '<a href="e_detail.php?id='.$r["e_id"].'"><i class="fas fa-angle-right"></i></a>';
    $view .= '</div>';
    $view .= "</div>";
    $view .= "</div>";
  }
}

// Select選択肢の抽出
$sql = "SELECT * FROM icntry";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view_d="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
  $view_d .= '<option value="'.$r['icntry_id'].'">'.$r['icntry'].'</option>';
//   $view .= '</optgroup>';
}
}

// Select選択肢の抽出
$sql = "SELECT * FROM rgn";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view_r="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
  $view_r .= '<option value="'.$r['rgn_id'].'">'.$r['rgn'].'</option>';
//   $view .= '</optgroup>';
}
}

// Select選択肢の抽出
$sql = "SELECT * FROM lvl";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view_l="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
  $view_l .= '<option value="'.$r['lvl_id'].'">'.$r['lvl'].'</option>';
//   $view .= '</optgroup>';
}
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/s_header01.php")?>


<!-- EYE CATCH -->
<div class="eye-catch">
  <div class="intro-box">
      <p class="intro-text">Introducing opportunities to speak to university representatives to learn about overseas study choices.</p><br>
      <p class="second-text">Your journey begins here.</p> 
  </div>
</div>

<div class="inner">

  <?php if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){ ?>
    <h1 class="greet">Welcome！</h1>
  <?php }else{ ?>
    <p class="greet">Hello, <?=$_SESSION["firstname"]?> !</p>
  <?php } ?>

</div>
  
  <div class="container">
    <h1 class="heading">Search</h1>


    <div id="search" class="row">
        <form action="index.php" method="post" id="filterResult" name="filterResult" class="col s12">
            <div class="row">
                <div class="input-field col s12">
                <select name="dest" id="selectDestination">
                  <option value="" disabled selected>Choose destination</option>
                  <?= $view_d?>
                </select>
                <label for="dest">Destination</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="rgn" id="selectArea">
                        <option value="" disabled selected>Choose your region</option>
                        <?= $view_r?>
                      </select>
                    <label for="rgn">Where you are</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="lvl" id="selectLevel">
                    <option value="" disabled selected class="choose">Choose level of study</option>
                    <?= $view_l?>
                    </select>
                    <label for="lvl">Level of study</label>
                </div>
            </div>
                <button ><span class="btn-filter">Filter</span></button>
        </form>
      </div>

      
  <?= $view ?>
  </div>
  

  <?php include("templates/footer.php") ?>

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <script>

  document.addEventListener('DOMContentLoaded', function() {
    var options = document.querySelectorAll('option');
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
  });
    
  </script>

</body>
</html>