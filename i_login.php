<!DOCTYPE html>

<?php include("templates/i_header01.php")?>

<div class="inner">

    <h1 class="greet">Welcome</h1>

</div>

<div class="container">

    <p class="heading">Log in</p>

    <div class="mb60 text-right">
        <p><a href="i_index.php" class="login_i mb40">Sign up</a> if you have an account with us.</p>
    </div>

    <div class="row">
        <form action="i_login_act.php" method="post" class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="validate">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <label for="password">Password</label>
                    <input type="password" name="password">
                </div>
            </div>
            <input type="submit" value="Submit" class="btn-submit_i btn-filter">
            
        </form>
    </div>
</div>
<?php include("templates/i_footer.php")?>
<?php include("templates/script.php")?>
</body>
</html>