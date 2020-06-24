<?php 
session_start();

$id = $_GET["id"];
$ssid = $_SESSION["iuser_id"];

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "SELECT * 
FROM iuser
JOIN inst ON iuser.i_inst_id = inst.inst_id
JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
WHERE iuser.iuser_id = :id OR iuser.iuser_id=:ssid";
// $stmt = $pdo->prepare("SELECT * FROM iuser WHERE iuser_id=:id");
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':ssid', $ssid, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  sql_error();
}else{
  $r = $stmt->fetch();  
  }

?>


<!DOCTYPE html>
<html lang="en">

<?php include("templates/i_header01.php")?>

<div class="container">

    <h1 class="heading">Edit personal details</h1>

    <div class="row">

    <form action="i_user_update.php" method="post" class="col s12">

    <div class="row">
        <div class="input-field col s6">
            <label for="firstname"></label>
            <input type="text" name="firstname" value="<?=$r["iuser_firstname"]?>">
        </div>
        <div class="input-field col s6">
            <label for="lastname"></label>
            <input type="text" name="lastname" value="<?=$r["iuser_lastname"]?>">
        </div>
    </div>

    <div class="row">
        <div class="input-field col s6">
            <label for="email"></label>
            <input type="email" name="email" value="<?=$r["iuser_email"]?>">
        </div>
        <div class="input-field col s6">
            <label for="password"></label>
            <input type="password" name="password" value="<?=$r["iuser_pw"]?>">
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
            <label for="jobtitle"></label>
            <input type="text" name="jobtitle" value="<?=$r["j_title"]?>">
        </div>
        <div class="input-field col s6">
            <label for="department"></label>
            <input type="text" name="department" value="<?=$r["dept"]?>">
        </div>
    </div>
    <!-- <div>
        <p>Institution: <?=$r["inst_name"]?></p>
        <p>Country: <?=$r["icntry"]?></p>
    </div> -->
        <input type="hidden" name="iuser_id" value="<?=$r["iuser_id"]?>">
        <input type="submit" value="Save" class="btn-submit_i btn-filter">
    </form>

    </div>
    
</div>

    <?php include("templates/i_footer.php")?>
    
</body>
</html>