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
<div id="all-content" class="container mycontent">
    <div id="sidebar">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">DSP</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
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
                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="main-content">