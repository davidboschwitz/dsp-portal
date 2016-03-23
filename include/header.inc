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
 * 
 */

class navbar_link {
    /**
     * @var int The authentication level required for this page
     */
    public $auth;

    /**
     * @var array The children (if any) of this link.
     */
    public $children;

    /**
     * @var string The text displayed for this link.
     */
    protected $desc;

    /**
     * @var string The url displayed for this link.
     */
    protected $link;

    /**
     * Creates a new Response entity.
     * 
     */
    public function __construct($link, $desc, $auth = 0, array $children = []) {
        $this->link = $link;
        $this->desc = $desc;
        $this->auth = $auth;
        $this->children = $children;
    }
}
    
$link[] = new navbar_link("mypoints.php", "My Points", 1);
$link[] = new navbar_link("award.php", "Award Points", 5);
$link[] = new navbar_link("pointadmin.php", "Point Admin", 7);
$link[] = new navbar_link("calendar.php", "Calendar", 1);
$link[] = new navbar_link("webmaster.php", "Webmaster Tools", 100);
?>
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
                        if (basename($_SERVER['PHP_SELF']) == $link[$i]->link) {
                            ?>
                            <li class="active"><a href="#"><?php echo $link[$i]->desc; ?></a></li>
                            <?php
                        } else {
                            if ($_SESSION['auth'] >= $link[$i]->auth) {
                                ?>
                                <li><a href="<?php echo $link[$i]->link; ?>"><?php echo $link[$i]->desc; ?></a></li>
                                <?php
                            }
                        }
                    }
                    ?>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Signed in as <?php echo $_SESSION['full_name'] ?><span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                        <?php if (basename($_SERVER['PHP_SELF']) == "myaccount.php") {?>
                          <li class="active"><a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;Account Settings</a></li>
                        <?php } else { ?>
                          <li><a href="myaccount.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            &nbsp;Account Settings</a></li>
                        <?php } ?>
                        <li role="separator" class="divider"></li>
                        <li><a href="login.php"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                          &nbsp;Sign Out</a></li>
                      </ul>
                  </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div id="all-content" class="container mycontent">
    <div id="main-content">
