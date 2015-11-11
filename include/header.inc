<?php
$link[] = "mypoints.php";
$desc[] = "My Points";
$auth[] = 1;

$link[] = "award.php";
$desc[] = "Award Points";
$auth[] = 5;

$link[] = "pointadmin.php";
$desc[] = "Point Admin";
$auth[] = 7;

$link[] = "calendar.php";
$desc[] = "Calendar";
$auth[] = 1;

$link[] = "myaccount.php";
$desc[] = "Account Settings";
$auth[] = 1;
?>
<div id="all-content">
    <div id="sidebar">
        <ul class="nav nav-tabs">
            <?php
            for ($i = 0; isset($link[$i]); $i++) {
                if (basename($_SERVER['PHP_SELF']) == $link[$i]) {
                    ?>
            <li class="active"><a href="#"><?php echo $desc[$i]; ?></a></li>
                    <?php
                } else {
                    if ($_SESSION['auth'] >= $auth[$i]) {
                        ?>
                        <li><a href="<?php echo $link[$i]; ?>"><?php echo $desc[$i]; ?></a></li>
                        <?php
                    }
                }
            }
            ?>
            <li><a href="login.php">Logout</a></li><br>
        </ul>
    </div>
    <div id="main-content">