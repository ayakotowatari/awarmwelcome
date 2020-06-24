<?php 

session_start();

$iuser_id = $_SESSION["iuser_id"];
$inst_id = $_SESSION["i_inst_id"];

include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "SELECT * from inst WHERE inst_id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $inst_id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
    sql_error();
}else{
    $r = $stmt->fetch();
}


?>

<!DOCTYPE html>

<?php include("templates/i_header01.php")?>

<div class="inner">
<p class="greet_small">
    Hello, <?=$_SESSION["firstname"]?>！
</p>

<a href="i_user_account.php?id=<?=$iuser_id?>">
    <div class="link_box">
        <div class="link_box_l">
            <p class="link_box_heading">Manage Personal Account</p>
            <p class="link_box_content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna </p>
        </div>
        <div class="link_box_r">
            <!-- <a href="i_user_account.php?id=<?=$iuser_id?>"><i class="fas fa-angle-right"></i></a> -->
           <i class="fas fa-angle-right"></i>
        </div>
    </div>
</a>

<p class="heading_large"><?=$r["inst_name"]?></p>

<div class="link_box_flex">
    <div class="link_box_inner">
        <a href="i_e_entry.php">
            <div class="link_box">
                <div class="link_box_l">
                    <p class="link_box_heading">Create Event</p>
                    <p class="link_box_content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna </p>
                </div>
                <div class="link_box_r">
                    <a href="i_e_entry.php"><i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </a>
        </div>
    <div class="link_box_inner">
        <a href="i_e_list.php">
            <div class="link_box">
                <div class="link_box_l">
                    <p class="link_box_heading">Manage Event</p>
                    <p class="link_box_content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna </p>
                </div>
                <div class="link_box_r">
                    <a href="i_e_list.php"><i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </a>
    </div>
    <div class="link_box_inner">
        <a href="i_stats.php?id=<?=$inst_id?>">
            <div class="link_box">
                <div class="link_box_l">
                    <p class="link_box_heading">Data</p>
                    <p class="link_box_content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna </p>
                </div>
                <div class="link_box_r">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </a>
    </div>
</div>

</div>

<?php include("templates/i_footer.php")?>
<?php include("templates/script.php")?>
</body>
</html>