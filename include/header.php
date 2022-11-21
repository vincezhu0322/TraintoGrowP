<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'include/css.php'; ?>
    <title><?php echo isset($title) ? $title : 'Home';  ?></title>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header__topWrapper">
            <div class="container">
                <div class="header__top">
                    <a href="index.php" class="header__logo">
                        <img src="images/logo.png" alt="image" class="imgFluid">
                        Train to Grow Marijuana Cultivation Classes
                    </a>
                </div>
            </div>
        </div>
        <div class="header__navWrapper">
            <div class="container">
                <ul class="header__nav">
                    <li><a href="index.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">Home</a></li>
                    <li><a href="about-us.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'about-us.php') ? 'active' : '' ?>">About
                            Us</a></li>
                    <li><a href="contact-us.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'contact-us.php') ? 'active' : '' ?>">Contact
                            Us</a></li>
                    <!-- <li><a href="services.php"
                            class="<?= (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : '' ?>">Services</a>
                    </li> -->
                    <li><a href="class-type.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'class-type.php') ? 'active' : '' ?>">Class Type</a></li>
                </ul>
            </div>
        </div>
    </header>