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
    <div class="i_nav">
        <div>
            <h1 class="logo">A Warm Welcome</h1>
        </div>
        <div class="nav-list">
            <?php if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){ ?>
            <a href="i_index.php" class="nav-item">Sign up</a>
            <a href="i_login.php" class="nav-item">Log in</a>
            <?php }else{ ?>
            <a href="i_dboard.php" class="nav-item">Dashboard</a>
            <a href="i_user_logout.php" class="nav-item">Log out</a>
            <a href="i_user_account.php?id=<?=$iuser_id?>" class="nav-item"><i class="fas fa-user-circle"></i></a>
            <?php } ?>
        </div>
    </div>

