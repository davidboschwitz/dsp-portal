<?php
/*
 * Copyright 2015 David Boschwitz.
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
                    <a class="navbar-brand" href="#"><?php echo $config['name_abbr']; ?></a>
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
                        <li><a>Signed in as <span class="navbar-link"><?php echo $_SESSION['full_name'] ?></span></a></li>
                        <li><a href="login.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="main-content">
