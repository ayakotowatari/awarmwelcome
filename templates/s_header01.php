<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Warm Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/87fa672dc5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
    <div class="s_nav">
        <div>
            <h1 class="logo">A Warm Welcome</h1>
        </div>
        <div class="nav-list">
            <a href="index.php" class="nav-item">Home</a>
            <?php if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){ ?>
            <a href="stu_signup.php" class="nav-item">Sign up</a>
            <a href="stu_login.php" class="nav-item">Log in</a>
            <?php }else{ ?>
            <a href="s_user_logout.php" class="nav-item">Log out</a>
            <a href="s_user_account.php?id=<?=$s_id?>" class="nav-item"><i class="fas fa-user-circle"></i></a>
            <?php } ?>
        </div>
    </div>

