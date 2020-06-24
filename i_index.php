<?php 
session_start();

include("funcs.php");

$pdo = db_conn();

// $sql = "SELECT * 
// FROM i_event 
// JOIN "


?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/i_header01.php")?>

<div class="inner">
    <h1 class="greet">Welcome</h1>
</div>

<div class="container">

<div class="row"> 

    <form action="i_signup.php" method="post" class="col s12">
        <div class="row">
            <div class="input-field col s12">
                <p class="heading">Enter university name</p>
                <input type="text" name="u_name" class="validate">
            </div>
        </div>
        <input type="submit" value="Submit" class="btn-submit_i btn-filter">
    </form>

</div>

</div>
<?php include("templates/script.php")?>
<?php include("templates/i_footer.php")?>
    
</body>
</html>