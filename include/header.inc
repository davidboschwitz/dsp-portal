<div id="all-content">
    <div id="sidebar">
        <?php if ($_SESSION['auth'] > 0) { ?>
            <a href = "mypoints.php">My Points</a> - 
        <?php } if ($_SESSION['auth'] > 3) { ?>
            <a href="award.php">Award Points</a> - 
        <?php } if ($_SESSION['auth'] > 7) { ?>
            <a href="pointadmin.php">Point Admin</a> - 
        <?php } if ($_SESSION['auth'] > 0) { ?>
            <a href="calendar.php">Calendar</a> - 
        <?php } ?>
        <a href="login.php">Logout</a><br>
    </div>
    <div id="main-content">