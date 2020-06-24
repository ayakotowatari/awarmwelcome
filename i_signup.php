<?php 
// if(isset($_POST["u_name"])){
//     $u_name = $_POST["u_name"];
// }else{
//     $u_name = "";
// }

$u_name = $_POST["u_name"];

// if(empty($u_name)){
//     $error = "Enter institution name";
// }

include("funcs.php");
$pdo = db_conn();

$sql = "SELECT inst_name FROM inst where inst_name = :u_name";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":u_name",$u_name,PDO::PARAM_STR);
$status = $stmt->execute();

// $r = $stmt->fetch();
// echo $r;

if($stmt->rowCount() > 0){

    $sql = "SELECT inst_id, inst_name, icntry
     FROM inst
     JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
     WHERE inst_name = :u_name";
        
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":u_name",$u_name,PDO::PARAM_STR);
    $status = $stmt->execute();

    $view="";
    if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    sql_error($stmt);

    }else{
    //１データのみ抽出の場合はwhileループで取り出さない
    $r = $stmt->fetch();
    // $row["id"], $row["name"].....
    }

}else{

    redirect("i_index.php");

}




// echo $uname_count;
// if($uname_count = 0){
//     redirect("u_index.php");
// }else{

//     $sql = "SELECT inst_name, icntry
//     FROM inst
//     JOIN icntry ON inst.i_icntry_id = icntry.icntry_id
//     WHERE inst_name = :u_name";
    
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindValue(":u_name",$u_name,PDO::PARAM_STR);
//     $status = $stmt->execute();
// }


// $view="";
// if($status==false) {
//   //execute（SQL実行時にエラーがある場合）
//   sql_error($stmt);

// }else{
//   //１データのみ抽出の場合はwhileループで取り出さない
//   $r = $stmt->fetch();
//   // $row["id"], $row["name"].....
// }


?>
<!DOCTYPE html>
<html lang="en">

<?php include("templates/i_header01.php")?>

<div class="inner">

    <h1 class="greet">Welcome</h1>

</div>

<div class="container">

    <p class="heading">Sign Up</p>

    <div class="mb60 text-right">
        <p><a href="i_login.php" class="login_i mb40">Log in</a> if you have an account with us.</p>
    </div>

<div class="row">

    <form action="i_user_insert.php" method="post" class="col s12">
        <div class="row">
            <div class="input-field col s6">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" class="validate">
            </div>
            <div class="input-field col s6">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <label for="email">Email</label>
                <input type="email" name="email">
            </div>
            <div class="input-field col s6">
                <label for="password">Password</label>
                <input type="password" name="password">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <label for="jobtitle">Job Title</label>
                <input type="text" name="jobtitle" class="validate">
            </div>
            <div class="input-field col s6">
                <label for="department">Department</label>
                <input type="text" name="department" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <label for="inst_name">Institution</label>
                <input type="text" name="inst_name" value="<?=$r["inst_name"]?>">
            </div>
            <div class="input-field col s6">
                <label for="i_country">Country</label>
                <input type="text" name="i_country" value="<?=$r["icntry"]?>">
            </div>
        </div>
            <input type="hidden" name="inst_id" value="<?=$r["inst_id"]?>">
            <input type="submit" value="Submit" class="btn-submit_i btn-filter">
        </form>

    </div>
    
</div>
</div>
<?php include("templates/i_footer.php")?>
<?php include("templates/script.php")?>

</body>
</html>