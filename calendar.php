<?php
$page['auth'] = 1;
require "include/functions.inc";
?>
<html>
    <head>
        <title>Calendar</title>
        <?php require "include/head.inc"; ?>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <h2>Calendar</h2>
        <iframe src="<?php echo $config['calendar_iframe_src']; ?>" height="96%" width="100%"></iframe>
        <?php require "include/footer.inc"; ?>
    </body>
</html>