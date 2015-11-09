<?php
$page['auth'] = 1;
include "include/functions.inc";
include "include/mysql.inc"; //connect to MySQL

$user = $_SESSION['user'];

$query = sprintf("SELECT pa.code, pa.quantity, pd.points, pd.description, pc.description AS category
FROM dsp.points_awarded AS pa 
INNER JOIN dsp.points_categories AS pc ON SUBSTRING(pa.code,1,2) = pc.code
INNER JOIN dsp.points_definition AS pd ON pd.code = pa.code
WHERE pa.awardedto = '%s'
ORDER BY pa.code", mysql_real_escape_string($user));
$result = mysql_query($query) or die('Invalid query: ' . mysql_error());


$rowcount = 0;
while ($row[$rowcount] = mysql_fetch_assoc($result)) {
    //TODO: add rows with same codes quantities into one single row
    $flag = false;
    for ($a = 0; $a < $rowcount; $a++) {
        if ($content[$a]['code'] == $row[$i]['code']) {
            $flag = true;
            $content[$a]['quantity'] += $row[$i]['quantity'];
        }
    }
    if (!$flag) {
        $content[$a] = $row[$rowcount];
        $rowcount++;
    }
}
?>
<html>
    <head>
        <title>DSP - My Points</title>
        <?php include "include/head.inc"; ?>
    </head>
    <body>
        <?php include "include/header.inc"; ?>
        <h2>My Points Breakdown (<?php echo $_SESSION['full_name']; ?>)</h2>
        <table class="cream">
            <thead>
                <tr>
                    <th style="text-align: right;">Pts</th>
                    <th style="text-align: right;">#</th>
                    <th style="text-align: right;">Ttl</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Description</th>
                </tr>
            </thead>
            <?php
            $totalpts = 0;
            $totalquantity = 0;
            for ($i = 0; $i < $rowcount; $i++) {
                $totalpts += $content[$i]['points'] * $content[$i]['quantity'];
                $totalquantity += $content[$i]['quantity'];
                ?>    
                <tr>
                    <td style = "text-align: right;"><?php echo $content[$i]['points']; ?></td>
                    <td style = "text-align: right;"><?php echo $content[$i]['quantity']; ?></td>
                    <td style = "text-align: right;"><?php echo ($content[$i]['points'] * $content[$i]['quantity']); ?></td>
                    <td><?php echo $content[$i]['code']; ?></td>
                    <td><?php echo $content[$i]['category']; ?></td>
                    <td><?php echo $content[$i]['description']; ?></td>
                </tr>
            <?php } ?>
            <thead>
                <tr>
                    <th style="text-align: right;">&nbsp;</th>
                    <th style="text-align: right;"><?php echo $totalquantity; ?></th>
                    <th style="text-align: right;"><?php echo $totalpts; ?></th>
                    <th><i>Total</i></th>
                    <th style="text-align: right;">Current Status:</th>
                    <th><?php echo points_status($totalpts); ?></th>
                </tr>
            </thead>
        </table>
        <?php include "include/footer.inc"; ?>
    </body>
</html>
<?php
mysql_close($mysql_link);