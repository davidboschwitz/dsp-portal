<?php
// exit;
// include 'include/hash.php';

// echo $a = create_hash("Hello 1");
// echo "<br>";
// echo strlen($a);
// echo "<br>";
// echo "<br>";
//
// echo $b = create_hash("Hello 1");
// echo "<br>";
// echo strlen($b);
// echo "<br>";
// echo "<br>";
//
// echo validate_password("Hello 1", $a);
// echo "<br>";
// echo validate_password("Hello 1", $b);
// echo "<br>";
//
// echo validate_password("hello 1", $a);
// echo "<br>";

//include 'include/config.inc';
//
//echo '<select id="greeknum">';
//
//for($i = 1; $i < 601; $i++)
//echo "<option value=\"" . $i . "\">" . get_greek_num($i) . "</option>";
//?>
<!--</select>-->

<head>
    
<script src="/ckeditor/ckeditor.js"></script>
</head>
<body>
<form id="that-editor">
    <textarea name="editor1" id="editor1" rows="10" cols="80">
        <?php echo file_get_contents("assets/html/index.html"); ?>
    </textarea>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
    </script>
</form>
</body>