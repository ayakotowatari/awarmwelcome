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
$stmt->bindValue(':id', $id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':ssid', $ssid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
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

<?php include("templates/i_header01.php") ?>

<div class="container">

    <h1 class="heading"><?= $_SESSION["firstname"]?>'s Account</h1>

    <div class="i_user_table">
    <table class="mb40">

        <tr>
            <td class="text-right">Your Name</td>
            <td><?=$r["iuser_firstname"]?> <?=$r["iuser_lastname"]?></td>
        </tr>
        <tr>
            <td class="text-right">Email</td>
            <td><?=$r["iuser_email"]?></td>
        </tr>
        <tr>
            <td class="text-right">Password</td>
            <td><input type="hidden" value="<?=$r["iuser_pw"]?>"></td>
        </tr>
        <tr>
            <td class="text-right">Jot title</td>
            <td><?=$r["j_title"]?></td>
        </tr>
        <tr>
            <td class="text-right">Department</td>
            <td><?=$r["dept"]?></td>
        </tr>
        <tr>
            <td class="text-right">Institution</td>
            <td><?=$r["inst_name"]?></td>
        </tr>
        <tr>
            <td class="text-right">Country</td>
            <td><?=$r["icntry"]?></td>
        </tr>
    </table>
    </div>
    
    <a href="i_user_updateview.php?id=<?= $r["iuser_id"]?>" class="btn-submit_i btn-filter">Edit</a>

</div>

    <?php include("templates/i_footer.php") ?>
    
</body>
</html>