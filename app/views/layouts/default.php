<?php
$refresh = rand();
?>
<!DOCTYPE html>
<html lang="ru">

<head>

  <meta charset="utf-8">
  <!-- <base href="/"> -->

  <title>Main</title>
  <meta name="description" content="main page">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Template Basic Images Start -->
  <meta property="og:image" content="/path/to/image.jpg">
  <link rel="icon" href="/img/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon-180x180.png">
  <!-- Template Basic Images End -->

  <!-- Custom Browsers Color Start -->
  <meta name="theme-color" content="#000">
  <!-- Custom Browsers Color End -->

    <link rel="stylesheet" href="/libs/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/css/main.css">
<!--    <script src='https://www.google.com/recaptcha/api.js' defer></script>-->

</head>

<body>

<header class="container-fluid">
    <div class="row align-items-center">
        <div class="info col">
            <h3 class="info__text text-center">Whatever header they currently use goes here</h3>
        </div>
    </div>
    <nav class="navigation row">
        <div class="col-lg-5 offset-lg-1 col-9">
            <ul class="menu">
                <li class="menu__item">
                    <a href="/main" class="menu__link">Main</a>
                </li>
                <li class="menu__item">
                    <a href="#" class="menu__link">Women's</a>
                </li>
                <li class="menu__item">
                    <a href="#" class="menu__link">Men's</a>
                </li>
                <li class="menu__item">
                    <a href="/catalog" class="menu__link">Catalog</a>
                </li>
                <li class="menu__item">
                    <a href="/bag.html" class="menu__link">Bag</a>
                </li>
                <li class="menu__item">
                    <a href="/product.html" class="menu__link">Product</a>
                </li>
                <?php if (isset($_SESSION['user'])&&$_SESSION['user']['role_id']==2): ?>
                    <li class="menu__item">
                        <a href="/admin" class="menu__link">Admin Panel</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-lg-2    offset-lg-3 col-3">
            <ul class="menu">
                <li class="menu__item">
                    <a href="#" class="menu__link"><?=isset( $_SESSION['user'])? $_SESSION['user']["email"]:""?></a>
                </li>
                <?php if (!isset($_SESSION['user'])): ?>
                <li class="menu__item">
                    <a href="/register" class="menu__link">Sign Up</a>
                </li>
                <li class="menu__item">
                    <a href="/login" class="menu__link">Sign In</a>
                </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])): ?>
                    <li class="menu__item">
                        <a href="/users/logout" class="menu__link">Log Out</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
    <!--CONTENT OF THE VIEW-->
    <?=$content?>



<script src="https://www.google.com/recaptcha/api.js" defer></script>
<script src="/js/scripts.min.js?version=<?=$refresh?>" defer></script>

</body>

</html>