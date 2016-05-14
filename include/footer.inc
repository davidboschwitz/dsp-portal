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
?></div>
</div>

<div id="page-footer" class="page-footer page-row">
    <div class="container-fluid home" style="margin-top:20px; page-break-before: always;">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 text-xs-center text-sm-left">
                    <div class="visible-xs" style="margin:50px"></div>
                    <h4><?php echo $config['name_organization']; ?>&nbsp;<small><?php echo $config['name_school']; ?></small></h4>
                    <ul class="list-inline">

                        <li class="">
                            <a href="#" onclick="swal('Not yet implemented', 'This page hasn\'t been created yet!', 'error');">Alumni</a>
                        </li>
                        <li class="">
                            <a href="/recruitment.php">Recruitment</a>
                        </li>
                        <li class="">
                            <a href="/history.php">History</a>
                        </li>
                        <li class="">
                            <a href="/contacts.php">Contacts</a>
                        </li>
                    </ul>
                    <p>Copyright &copy; <?php echo date("Y"); ?></p>
                    <div class="visible-xs" style="margin:50px"></div>
                </div>
                <div class="col-sm-4 text-xs-center text-sm-left">
                    <h4>Contact Us</h4>
                    <p>
                        <i class="fa fa-fw fa-map-marker"></i>&nbsp;<?php echo $config['contact_address']; ?>
                        <br class="visible-xs">
                        <a href="<?php echo $config['contact_address_googlemaps']; ?>" target="_blank">Directions</a>
                    </p>
                    <p><i class="fa fa-fw fa-envelope"></i> <a href="/contacts.php">Chapter Contacts</a></p>
                    <div class="visible-xs" style="margin:50px"></div>
                </div>
                <div class="col-sm-4 text-xs-center text-sm-left">
                    <h4>Connect With Us</h4>
                    <div class="footer-icons">
                        <?php if (isset($config['social_facebook']) && $config['social_facebook'] != NULL) { ?>
                            <a style="color: #507cbe;" href="<?php echo $config['social_facebook']; ?>" target="_blank">
                                <i class="fa fa-facebook fa-2x"></i>
                            </a>&nbsp;
                            <?php
                        }
                        if (isset($config['social_twitter']) && $config['social_twitter'] != NULL) {
                            ?>
                            <a style="color: #62cdf2;" href="<?php echo $config['social_twitter']; ?>" target="_blank">
                                <i class="fa fa-twitter fa-2x"></i>
                            </a>&nbsp;
                            <?php
                        }
                        if (isset($config['social_instagram']) && $config['social_instagram'] != NULL) {
                            ?>
                            <a style="color: #333333;" href="<?php echo $config['social_instagram']; ?>" target="_blank">
                                <i class="fa fa-instagram fa-2x"></i>
                            </a>&nbsp;
                            <?php
                        }
                        if (isset($config['social_youtube']) && $config['social_youtube'] != NULL) {
                            ?>
                            <a href="<?php echo $config['social_youtube']; ?>" target="_blank">
                                <i class="fa fa-youtube-play fa-2x"></i>
                            </a>&nbsp;
                            <?php
                        }
                        if (isset($config['social_flickr']) && $config['social_flickr'] != NULL) {
                            ?>
                            <a href="<?php echo $config['social_flickr']; ?>" target="_blank">
                                <i class="fa fa-flickr fa-2x"></i>
                            </a>&nbsp;
                        <?php } ?>
                    </div>
                    <div class="visible-xs" style="margin:50px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
