<?php
$page['auth'] = 7;
include "include/functions.inc";
?>
<html>
    <head>
        <title>Points Admin</title>
        <?php include "include/head.inc"; ?>
        <script type="text/javascript">
            function openHints() {
                window.open("pointindex.php", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=500, left=500, width=500, height=600");
            }
            
            function sortForm(col) {
                if (document.getElementById("sortby").value == col) {
                    if (document.getElementById("sortmethod").value == "ASC") {
                        document.getElementById("sortmethod").value = "DESC";
                    } else {
                        document.getElementById("sortmethod").value = "ASC";
                    }
                }
                document.getElementById("sortby").value = col;
                document.getElementById("pointadmin").submit();
            }
        </script>
    </head>
    <body>
        <?php include "include/header.inc"; ?>
        <h2>Search for Points Awarded</h2>
        <form id="pointadmin" action="" method="POST">
            <input id="sortby" name="sortby" type="hidden" value="<?php echo ($_POST['sortby'] ? $_POST['sortby'] : "ASC"); ?>" />
            <input id="sortmethod" name="sortmethod" type="hidden" value="<?php echo $_POST['sortmethod']; ?>" />
            <table class="award">
                <tr>
                    <td class="awardlabel">Code</td>
                    <td><input id="code" name="code" type="text" maxlength="5" style="width: 50px;" value="<?php echo $_POST['code']; ?>" />&nbsp;&nbsp;[ <a onclick="openHints()" style="text-decoration: underline; color:blue;" href="#">list</a> ]</td>
                </tr>
                <tr>
                    <td class="awardlabel">Quantity</td>
                    <td><input id="quantity" name="quantity" type="number" min="1" max="20" value="<?php echo $_POST['quantity']; ?>" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Awarded to</td>
                    <td> <input id="awardedto" name="awardedto" type="text" placeholder="net-id awarded to" value="<?php echo $_POST['awardedto']; ?>" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Comments</td>
                    <td><input id="comments" name="comments" type="text" style="width: 100%;" value="<?php echo $_POST['comments']; ?>" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Awarded by</td>
                    <td><input id="awardedby" name="awardedby" type="text" placeholder="net-id awarded by" value="<?php echo $_POST['awardedby']; ?>" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Awarded after</td>
                    <td><input id="datebefore" name="datebefore" type="date" value="<?php echo ($_POST['datebefore'] ? $_POST['datebefore'] : date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 7, date("Y")))); ?>"/></td>
                </tr>
                <tr>
                    <td class="awardlabel">Awarded before</td>
                    <td><input id="dateafter" name="dateafter" type="date" value="<?php echo ($_POST['dateafter'] ? $_POST['dateafter'] : date("Y-m-d")); ?>" /></td>
                </tr>
                <tr>
                    <td class="awardlabel"></td>
                    <td><button name="page" type="Submit" value="0" >Submit</button></td>
                </tr>
            </table>
            <?php
            $query = "SELECT * FROM `dsp`.`points_awarded` WHERE 1 = 1";
            if ($_POST['datebefore'] && $_POST['dateafter']) {
                $query .= sprintf(" AND `timestamp` BETWEEN '%s' AND '%s 23:59:00'", mysql_escape_string($_POST['datebefore']), mysql_escape_string($_POST['dateafter']));
            }
            if ($_POST['awardedto'] && valid_net_id($_POST['awardedto'])) {
                $query .= sprintf(" AND `awardedto` = '%s'", mysql_escape_string($_POST['awardedto']));
            }
            if ($_POST['awardedby'] && valid_net_id($_POST['awardedby'])) {
                $query .= sprintf(" AND `awardedby` = '%s'", mysql_escape_string($_POST['awardedby']));
            }
            if (strlen($_POST['code']) > 3 && strlen($_POST['code']) < 6) {
                $query .= sprintf(" AND `code` = '%s'", mysql_escape_string($_POST['code']));
            }
            if ($_POST['quantity'] > 0) {
                $query .= sprintf(" AND `quantity` = '%s'", mysql_escape_string($_POST['quantity']));
            }
            if ($_POST['comments']) {
                $query .= sprintf(" AND `comments` LIKE '%s'", mysql_escape_string($_POST['comments']));
            }

            switch ($_POST['sortby']) {
                case "timestamp":
                case "awardedto":
                case "awardedby":
                case "code":
                case "quantity":
                case "comments":
                    $query .= " ORDER BY " . $_POST['sortby'];
                    if ($_POST['sortmethod'] == "ASC" || $_POST['sortmethod'] == "DESC")
                        $query .= " " . $_POST['sortmethod'];
                    break;
            }
            if ($_POST['page'] < 1)
                $_POST['page'] = 1;
            $limitL = ($_POST['page'] - 1) * 50;
            $query .= " LIMIT " . $limitL . ",50";
            if ($config['debug']) {
                echo $query;
            }
            ?>

            <br><br>
            <table class="cream">
                <?php
                include "include/mysql.inc";
                $result = mysql_query($query) or die('Invalid query: ' . mysql_error());

                $i = 0;
                while ($row[$i++] = mysql_fetch_assoc($result)) {
                    //TODO: add rows with same codes quantities into one single row
                }
                echo mysql_num_rows($result);
                $rowcount = --$i; //Otherwise returns extra empty NULL row
                ?>
                <thead>
                    <tr>
                        <td><?php if ($_POST['page'] != 1) { ?><button name="page" type="Submit" value="<?php echo ($_POST['page'] - 1); ?>">Previous</button><?php } ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"><?php if ($rowcount > 49) { ?><button name="page" type="Submit" value="<?php echo ($_POST['page'] + 1); ?>">Next</button><?php } ?></td>
                    </tr>
                    <tr>
                        <th onclick="sortForm('timestamp')">Timestamp</th>
                        <th onclick="sortForm('code')">Code</th>
                        <th onclick="sortForm('quantity')">Quantity</th>
                        <th onclick="sortForm('awardedto')">Awarded To</th>
                        <th onclick="sortForm('awardedby')">Awarded By</th>
                        <th onclick="sortForm('comments')">Comments</th>
                    </tr>
                </thead>
                <?php for ($i = 0; $i < $rowcount; $i++) { ?>    
                    <tr>
                        <td><?php echo $row[$i]['timestamp']; ?></td>
                        <td><?php echo $row[$i]['code']; ?></td>
                        <td><?php echo $row[$i]['quantity']; ?></td>
                        <td><?php echo $row[$i]['awardedto']; ?></td>
                        <td><?php echo $row[$i]['awardedby']; ?></td>
                        <td><?php echo $row[$i]['comments']; ?></td>
                    </tr>
                <?php } ?>
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </form>
        <?php include "include/footer.inc"; ?>
    </body>
</html>