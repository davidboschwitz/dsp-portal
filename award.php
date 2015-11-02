<?php
$page['auth'] = 5;
include "include/functions.inc";
session_start();
?>
<html>
    <head>
        <title>Award Points</title>
        <?php include "include/head.inc"; ?>
        <script type="text/javascript">
            function multipleCheck() {
                if (document.getElementById("multiple").checked) {
                    document.getElementById("awardedto").disabled = true;
                    document.getElementById("awardedto").readOnly = true;
                    document.getElementById("awardedto").value = "";

                    document.getElementById("awardedtomultiple").disabled = false;
                    document.getElementById("awardedtomultiple").readOnly = false;
                } else {
                    document.getElementById("awardedto").disabled = false;
                    document.getElementById("awardedto").readOnly = false;

                    document.getElementById("awardedtomultiple").disabled = true;
                    document.getElementById("awardedtomultiple").readOnly = true;
                    document.getElementById("awardedtomultiple").value = "";
                }
            }
            function openHints(){
                window.open("pointindex.php", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=500, left=500, width=500, height=600");
            }
        </script>
    </head>
    <body onload="multipleCheck()">
        <?php include "include/header.inc"; ?>
        <form id="awardpts" action="submitaward.php" method="POST" on>
            <h1>Award new points</h1><br>
            <table class="award">
                <tr>
                    <td class="awardlabel">Code</td>
                    <td><input id="code" name="code" type="text" maxlength="5" style="width: 50px;"/>&nbsp;[ <a onclick="openHints()" style="text-decoration: underline; color:blue;" href="#">list</a> ]</td>
                </tr>
                <tr>
                    <td class="awardlabel">Quantity</td>
                    <td><input id="quantity" name="quantity" type="number" min="1" max="20" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Award to</td>
                    <td> <input id="awardedto" name="awardedto" type="text" placeholder="net-id to award to" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Award to multiple members?</td>
                    <td><input id="multiple" name="multiple" type="checkbox" onchange="multipleCheck()" /></td>
                </tr>
                <tr>
                    <td class="awardlabel">Award to <br><i>(multiple, comma separate users)</i></td>
                    <td><textarea id="awardedtomultiple" name="awardedtomultiple" type="text" placeholder="multiple net-ids (comma separated)" ></textarea></td>
                </tr>
                <tr>
                    <td class="awardlabel">Comments</td>
                    <td><input id="comments" name="comments" type="text" style="width: 100%;" /></td>
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
                    <td class="awardlabel"></td>
                    <td><input id="submit" type="submit" value="Submit" /></td>
                </tr>
            </table>
        </form>
    <?php include "include/footer.inc"; ?>
    </body>
</html>

