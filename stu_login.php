<?php 

$id = $_GET["id"];

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/s_header01.php")?>

<div class="container">
    <h1 class="heading">Log in</h1>

    <div class="mb60 text-right">
        <p><a href="stu_signup.php" class="login mb40">Sign Up</a> if you haven't created an account with us.</p>
    </div>

    <div class="row">
        <form action="s_user_loginact.php" method="post" class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input type="email" name="email" id="email" class="validate">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="password" name="password" id="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="submit" value="Submit" class="btn-filter btn-submit">
        
        </form>
    </div>
</div>

<?php include("templates/footer.php")?>

<?php include("templates/script.php")?>

</body>
</html>