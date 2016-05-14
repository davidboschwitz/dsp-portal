<?php
/*
 * Copyright 2016 David Boschwitz.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
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
$auth[] = 0;

$link[] = "contacts.php";
$desc[] = "Contacts";
$auth[] = 0;

$link[] = "webmaster.php";
$desc[] = "Webmaster Tools";
$auth[] = 100;

/*** About Dropdown ***/

$link_about[] = "about.php";
$desc_about[] = "About Us";
$auth_about[] = 0;

$link_about[] = "recruitment.php";
$desc_about[] = "Recruitment";
$auth_about[] = 0;

$link_about[] = "history.php";
$desc_about[] = "History";
$auth_about[] = 0;
?>
<div id="sidebar">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/" style="padding: 0px 10px 3px 10px;"><img src="/assets/img/navicon.png" height="40" alt="<?php echo $config['name_abbr']; ?>"></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                            <a id="about-dropdown" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                About<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                               <?php for ($i = 0; isset($link_about[$i]); $i++) {
                        if (basename($_SERVER['PHP_SELF']) == $link_about[$i]) {
                            ?>
                            <li class="active"><a href="#"><?php echo $desc_about[$i]; ?></a></li>
                            <script>document.getElementById('about-dropdown').setAttribute('class', 'active');</script>
                            <?php
                        } else {
                            if ($_SESSION['auth'] >= $auth_about[$i]) {
                                ?>
                                <li><a href="<?php echo $link_about[$i]; ?>"><?php echo $desc_about[$i]; ?></a></li>
                                <?php
                            }
                        }
                         }?>
                            </ul>
                    </li>
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
                <?php
                if (isset($_SESSION['logged_in'])) {
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a id="myaccount-dropdown" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Signed in as <?php echo $_SESSION['full_name'] ?><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (basename($_SERVER['PHP_SELF']) == "myaccount.php") { ?>
                                    <li class="active"><a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;Account Settings</a></li>
                                    <script>document.getElementById('myaccount-dropdown').setAttribute('class', 'active');</script>
                                <?php } else { ?>
                                    <li><a href="myaccount.php" ><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                            &nbsp;Account Settings</a></li>
                                <?php } ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout.php" ><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                        &nbsp;Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == "login.php" ? "active" : ""); ?>"><a href="login.php"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Login</a></li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</div>
<?php
if (isset($page['homepage_header']) && $page['homepage_header'] != null) {
    echo $page['homepage_header'];
}
if (isset($page['title'])) {
    ?>
    <div id="page-header" class="page-header" style="margin-top: 0; background-color: #fcfcfc">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 style="font-weight:bold;">
    <?php echo $page['title']; ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div id="all-content" class="container mycontent">
    <div id="main-content">
