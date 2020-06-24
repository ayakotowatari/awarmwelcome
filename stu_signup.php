<?php 

$id = $_GET["id"];

include("funcs.php");
$pdo = db_conn();

// $sql = "SELECT stu_cntry.stucntry_id, stu_cntry.stucntry, rgn.rgn
// FROM stu_cntry 
// JOIN rgn ON stu_cntry.s_rgn_id = rgn.rgn_id
// GROUP BY s_rgn_id";

// students' countries
$sql = "SELECT * FROM stu_cntry";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
//   $view .= '<optgroup label="'.$r['rgn'].'">';
//   $view .= '<option value="'.$r['stucntry_id'].'">'.$r['stucntry'];
//   $view .= '</option>';
//   $view .= '</optgroup>';

//   $view .= '<optgroup label="'.$r['rgn'].'">';
  $view .= '<option value="'.$r['stucntry_id'].'">'.$r['stucntry'];
  $view .= '</option>';
//   $view .= '</optgroup>';
}
}

// destinations
$sql = "SELECT * FROM icntry";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view2="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
//   $view .= '<optgroup label="'.$r['rgn'].'">';
//   $view .= '<option value="'.$r['stucntry_id'].'">'.$r['stucntry'];
//   $view .= '</option>';
//   $view .= '</optgroup>';

  $view2 .= '<option value="'.$r['icntry_id'].'">'.$r['icntry'];
  $view2 .= '</option>';
}
}

// lvl
$sql = "SELECT * FROM lvl";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view3="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
//   $view .= '<optgroup label="'.$r['rgn'].'">';
//   $view .= '<option value="'.$r['stucntry_id'].'">'.$r['stucntry'];
//   $view .= '</option>';
//   $view .= '</optgroup>';

  $view3 .= '<option value="'.$r['lvl_id'].'">'.$r['lvl'];
  $view3 .= '</option>';
}
}

// subjects
$sql = "SELECT * FROM sbj";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view4="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
//   $view .= '<optgroup label="'.$r['rgn'].'">';
//   $view .= '<option value="'.$r['stucntry_id'].'">'.$r['stucntry'];
//   $view .= '</option>';
//   $view .= '</optgroup>';

  $view4 .= '<option value="'.$r['sbj_id'].'">'.$r['sbj'];
  $view4 .= '</option>';
}
}

// year
$sql = "SELECT * FROM s_year";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view5="";
if($status==false) {
    sql_error();
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// .=は、+=と同じ。
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
//   $view .= '<optgroup label="'.$r['rgn'].'">';
//   $view .= '<option value="'.$r['stucntry_id'].'">'.$r['stucntry'];
//   $view .= '</option>';
//   $view .= '</optgroup>';

  $view5 .= '<option value="'.$r['year_id'].'">'.$r['year_start'];
  $view5 .= '</option>';
}
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("templates/s_header01.php")?>

<div class="container">
    <h1 class="heading">Sign Up</h1>

    <div class="mb60 text-right">
        <p><a href="stu_login.php?id=<?=$id?>" class="login mb40">Log In</a> if you already have an account with us.</p>
    </div>

    <div class="row">
        <form action="s_user_insert.php" method="post" class="col s12">
        
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
                    <input type="email" name="email" class="validate">
                </div>
                <div class="input-field col s6">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="validate">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="stu_cntry" id="">
                        <option value="" disabled selected>Select country</option>
                        <?= $view?>
                    </select>
                    <label>Where are you from?</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="inst_cntry[]" id="" multiple>
                        <option value="" disabled selected>Select destination(s)</option>
                        <?= $view2?>
                    </select>
                    <label>Where would you like to study?</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="lvl" id="">
                        <option value="" disabled selected>Select study level</option>
                        <?= $view3?>
                    </select>
                    <label>Level of study</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="sbj[]" id="" multiple>
                        <option value="" disabled selected>Select subject area(s)</option>
                        <?= $view4?>
                    </select>
                    <label>Subject area(s) of interest</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="year" id="">
                        <option value="" disabled selected>Select year</option>
                        <?= $view5?>
                    </select>
                    <label>When are you planning to start your study?</label>
                </div>
            </div>
            <div>
                <input type="hidden" name="id" value="<?=$id?>">
                <input type="submit" value="Submit" class="btn-filter btn-submit">
            </div>
        
        </form>

    </div>
</div>

<?php include("templates/footer.php")?>

<?php include("templates/script.php")?>
    
</body>
</html>