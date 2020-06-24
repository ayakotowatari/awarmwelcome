<?php 

$id = $_GET["id"];

session_start();

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "SELECT * FROM i_event WHERE e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error();
}else{
  $r = $stmt->fetch();  
  $view .= '<div class="mb20">';
  $view .= '<span class="mr20">'.$r["e_date"].'</span>';
  $view .= "<span>".$r["e_start_time"]."</span> - ";
  $view .= "<span>".$r["e_end_time"]."</span>";
  $view .= '</div>';
  $view .= '<p class="e_title_large mb30">'.$r["e_title"].'</p>';
  }

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/i_header01.php")?>

<div class="container">

    <h1 class="heading">Edit event details</h1>

    <?= $view ?>

    <form action="i_e_update.php" method="post" enctype="multipart/form-data">
        <div class="mb30">
            <label for="e_detail" class="label">Event details</label>
            <textarea name="e_detail" id="" cols="30" rows="40" class="edit_textarea"><?=$r["e_dtl"]?></textarea>
        </div>
        <div>
            <label for="upfile" class="label">Event Image</label>
            <input type="file" name="upfile" value="upload/<?=$r["e_img"]?>">
            <img src="upload/<?=$r["e_img"]?>" class="edit_img mb40">
        </div>
        <input type="hidden" name="id" value="<?=$r["e_id"]?>">
        <div>
            <input type="submit" value="Update" class="btn-submit_i btn-filter">
        </div>
    </form>
  
</div>
      <?php include("templates/i_footer.php")?>

</body>
</html>