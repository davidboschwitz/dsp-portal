<?php
$page['auth'] = 5;
require "include/functions.inc";
require "include/mysql.inc";
?>
<html>
    <head>
        <title>Points Submitted</title>
        <?php include "include/head.inc"; ?>
    </head>
    <body>
        <?php
        require "include/header.inc";
        $errormsg = null;
        do {
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
            if (!isset($_POST['code']) || empty($_POST['code']) || strlen($_POST['code']) < 4 || strlen($_POST['code']) > 5) {
                $errormsg = "Error: CODE is not set!";
                break;
            }
            if (!isset($quantity) || empty($quantity)) {
                $errormsg = "Error: QUANTITY is not set!";
                break;
            }
            if (!is_int($quantity) || $quantity > 20 || $quantity < 1) {
                $errormsg = "Error: QUANTITY out of range [1-20]!";
                break;
            }
            if (!isset($_POST['awardedto'])) {
                $errormsg = "Error: AWARDEDTO is not set!";
                break;
            }
            if ($_POST['multiple'] == "on") {
                $awardto = split(",", $_POST['awardedtomultiple']);
                for ($i = 0; $i < count($awardto); $i++) {
                    $awardto[$i] = trim($awardto[$i]);
                    if (!valid_net_id($awardto[$i]))
                        continue;
                    $query = sprintf("INSERT INTO `$mysql_db`.`points_awarded` (`pointid`, `timestamp`, `awardedto`, `code`, `quantity`, `awardedby`, `comments`) VALUES "
                            . "(NULL, CURRENT_TIMESTAMP, '%s', '%s', '%d', '%s', '%s');", mysql_escape_string($awardto[$i]), mysql_escape_string($_POST['code']), intval($quantity), mysql_escape_string($_SESSION['user']), mysql_escape_string($_POST['comments']));
                    $result = mysql_query($query) or ( $errormsg = ('Invalid query: ' . mysql_error()));
                }
            } else {
                $query = sprintf("INSERT INTO `$mysql_db`.`points_awarded` (`pointid`, `timestamp`, `awardedto`, `code`, `quantity`, `awardedby`, `comments`) VALUES "
                        . "(NULL, CURRENT_TIMESTAMP, '%s', '%s', '%d', '%s', '%s');", mysql_escape_string($_POST['awardedto']), mysql_escape_string($_POST['code']), intval($quantity), mysql_escape_string($_SESSION['user']), mysql_escape_string($_POST['comments']));
                $result = mysql_query($query) or ( $errormsg = ('Invalid query: ' . mysql_error()));
            }
        } while (false);
        ?>
        <form id="awardpts" action="submitaward.php" method="POST" >
            <h1>Points awarded</h1><br>
            <div class="center-block" style="width: 50%">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <tr>
                        <td class="awardlabel">Code</td>
                        <td><input id="code" name="code" type="text" maxlength="5" style="width: 50px;" value="<?php echo $_POST['code']; ?>" disabled /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Quantity</td>
                        <td><input id="quantity" name="quantity" type="number" min="1" max="20" value="<?php echo $quantity; ?>" disabled /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Award to</td>
                        <td> <input id="awardedto" name="awardedto" type="text" value="<?php echo $_POST['awardedto']; ?>" disabled /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Award to multiple members?</td>
                        <td><input id="multiple" name="multiple" type="checkbox" <?php if ($_POST['multiple'] == "on") echo "checked"; ?> disabled /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Award to <br><i>(multiple, comma separate users)</i></td>
                        <td><textarea id="awardedtomultiple" name="awardedtomultiple" type="text" disabled><?php echo $_POST['awardedtomultiple']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Comments</td>
                        <td><input id="comments" name="comments" type="text" style="width: 100%;" value="<?php echo $_POST['comments']; ?>" disabled /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded by</td>
                        <td><?php echo $_SESSION['user']; ?></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded on</td>
                        <td><?php echo date("Y-m-d h:m:s"); ?></td>
                    </tr>
                    <tr>
                        <td class="<?php echo $errormsg != null ? "awardlabelfail" : "awardlabelsuccess"; ?>" colspan="2"><?php echo $errormsg != null ? $errormsg : "Points awarded successfully!"; ?></td>
                    </tr>
                    <tr>
                        <td class="<?php echo $errormsg != null ? "awardlabelfail" : "awardlabelsuccess"; ?>" style="text-align: center" colspan="2"><a class="btn <?php echo $errormsg != null ? "btn-danger" : "btn-success"; ?>" href="award.php"><?php echo $errormsg != null ? "Retry" : "Submit another"; ?></a></td>
                    </tr>
                </table>
            </div>
        </form>
        <?php require "include/footer.inc"; ?>
    </body>
</html>

<?php
mysql_close($mysql_link);
