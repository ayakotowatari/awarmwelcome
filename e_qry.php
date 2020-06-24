<?php 

$e_id = $_GET["id"];

session_start();

$s_id = $_SESSION["stuser_id"];

include("funcs.php");
sschk();

$pdo = db_conn();

// $sql = "SELECT inst.inst_name
// FROM i_event 
// WHERE i_event.e_id = :id
// JOIN inst ON i_event.e_inst_id = inst.inst_id";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $e_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $status = $stmt->execute();

$sql = "SELECT inst_name
FROM inst
JOIN i_event ON inst.inst_id = i_event.e_inst_id
WHERE i_event.e_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $e_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();


if($status==false) {
  sql_error();
}else{
  $r = $stmt->fetch();  
  }

$sql = "SELECT * FROM e_qry_typ";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

$view="";
if($status==false) {
    sql_error();
  }else{
    while( $rq = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        
          $view .= '<option value="'.$rq['ee_qry_typ_id'].'">'.$rq['e_qry_typ'];
          $view .= '</option>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/s_header01.php")?>

<div class="inner">

  <h1 class="greet"><?=$_SESSION["firstname"]?>, you are asking a question about ...</h1>

</div>

<div class="container">

    <div class="heading"><?=$r["inst_name"]?></div>

    <div class="row">
      <form action="e_qry_insert.php" method="post" class="col s12">

      <div class="row">
        <div class="input-field col s12">
            <select name="category" id="">
              <option value="" disabled selected>Select category</option>
                <?= $view?>
            </select>
            <label for="category">Select category</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea id="textarea1" name="qry" class="materialize-textarea"></textarea>
          <label for="textarea1">What would you like to ask?</label>
        </div>
      </div>
          <input type="hidden" name="e_id" value="<?=$e_id?>">
          <input type="hidden" name="s_id" value="<?=$s_id?>">
          <input type="submit" value="Send" class="btn-submit btn-filter">
      </form>
    </div>
</div>
  <?php include("templates/footer.php")?>
  <?php include("templates/script.php")?>
</body>
</html>