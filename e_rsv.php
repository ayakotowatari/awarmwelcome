<?php 

session_start();

//1.GETでid値を取得

$id = $_GET["id"];
$s_id = $_SESSION["stuser_id"];

//2.DB接続など

include("funcs.php");
sschk();
$pdo = db_conn();

//3.SELECT * FROM i_event WHERE id=:id;
$sql = "SELECT * 
FROM i_event
JOIN inst ON i_event.e_inst_id = inst.inst_id
JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
WHERE i_event.e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4.データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  sql_error($stmt);

} else {
  //１データのみ抽出の場合はwhileループで取り出さない
  $row = $stmt->fetch();
  // $row["id"], $row["name"].....
}

$sql = "SELECT * 
FROM stuser
WHERE stuser_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $s_id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  sql_error($stmt);

} else {
  //１データのみ抽出の場合はwhileループで取り出さない
  $r = $stmt->fetch();
  // $row["id"], $row["name"].....
}



?>
<!DOCTYPE html>
<html lang="en">

<?php include("templates/s_header01.php")?>

<div class="inner">
    <h1 class="greet mb80">Hi <?=$_SESSION["firstname"]?>, you are booking for</h1>
</div>

<div class="container">
  <div class="rsv_box mb60">
    <div class="rsv_cont">
      <div>
        <span class="e-date"><?=$row["e_date"]?></span>    
        <span class="event-time"><?=$row["e_start_time"]?> - </span> 
        <span class="event-time"><?=$row["e_end_time"]?></span> 
      </div>
      <p class="e_inst"><?=$row["inst_name"]?></p>
      <p class="e_title"><?=$row["e_title"]?></p>
    </div>
    <div class="rsv_img">
      <img src="upload/<?=$row["e_img"]?>" alt="" class="rsv_img_size">
    </div>
  </div>

  <div class="row">

    <form action="e_rsv_insert.php" method="post" class="col s12">
    
      <div class="row">
        <div class="input-field col s12">
          <label>First Name</label>
          <input type="text" name="firstname" value="<?=$r["stuser_firstname"]?>" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <label>Last Name</label>
          <input type="text" name="lastname" value="<?=$r["stuser_lastname"]?>" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <label>Email</label>
          <input type="email" name="email" value="<?=$r["stuser_email"]?>" class="validate">
        </div>
      </div>
      <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
      <input type="hidden" name="st_id" value="<?=$r["stuser_id"]?>">
      <input type="submit" value="Confirm" class="btn-submit btn-filter">

    </form>

  </div>

</div>

<?php include("templates/footer.php")?>
<?php include("templates/script.php")?>

</body>
</html>