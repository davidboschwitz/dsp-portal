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
$page['auth'] = 0;
$page['no_timeout'] = TRUE;
$page['homepage_header'] = "<img src=\"assets/img/banner.jpeg\" style=\"width:100%; margin-top:-18px\" />";
require "include/functions.inc";
$page['title'] = $config['name_organization'] . "&nbsp;<small>" . $config['name_chapter'] . "</small>";
?>
<html>
    <head>
        <title><?php echo $config['name_organization']; ?></title>
        <?php require "include/head.inc"; ?>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <div style="font-size: 20px">
            <p>Salutations from the Beta Alpha Chapter of Delta Sigma Phi fraternity!  Our chapter was started in the spring semester of 2014.
                Starting with the unwavering support of 45 founding members, this Delta Sig chapter has grown into a prominent organization at Iowa State and continues to expand its presence here on our campus.</p>

            <p>Within our chapter, you will find several successful and high-achieving men.  The range of academic specialties and other campus organizations that our men are involved with embodies the mission of Delta Sigma Phi: to Build Better Men.  We strive to represent our chapter to the best of our ability, as well as become better leaders, students, future professionals, and citizens.</p>
        </div>
        <?php require "include/footer.inc"; ?>
    </body>
</html>
