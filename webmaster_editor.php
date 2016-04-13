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
$page['auth'] = 100;
require "include/functions.inc";        

require "include/hash.php";

$file_names = $config['editable_file_names'];
$pos = filter_input(INPUT_GET, 'pos', FILTER_SANITIZE_NUMBER_INT);
$saveme = filter_input(INPUT_POST, 'saveme', FILTER_SANITIZE_NUMBER_INT);
$content = $_POST['content'];//has to be $_POST, otherwise removes html data

if($pos >= count($file_names) || $pos < 0) {
    die(json_encode(array('status' => "error", 'msg' => "Invalid file id: " . $pos, 'title' => "Error")));
}

if($saveme == 1){
    $fh = fopen($file_names[$pos], 'w') or die(json_encode(array('status' => "error", 'msg' => "Can't open file!" . $pos, 'title' => "Error")));
    fwrite($fh, $content);
    fclose($fh);
    exit(json_encode(array('status' => "success", 'msg' => "Saved Successfully!", 'title' => "Saved.")));
}
?>
<html>
    <head>
        <title>Webmaster Tools</title>
        <?php require "include/head.inc"; ?>
    </head>
    <body>
<form id="that-editor">
    <textarea name="editor1" id="editor1" rows="15" cols="80">
        <?php echo file_get_contents($file_names[$pos]); ?>
    </textarea>
    <!--<a href="#" onclick="save()">Save</a>-->
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1', { on: { 
            'instanceReady': function (evt) { evt.editor.execCommand('maximize'); }
            }}); 
        
        CKEDITOR.instances.editor1.config.height = '337px';
        
        CKEDITOR.instances.editor1.addCommand("saveme", { // create named command
            exec: function(edt) {
                save();
            }
        });
        
        CKEDITOR.instances.editor1.ui.addButton('CustomSave', { // add new button and bind our command
            label: "Save",
            command: 'saveme',
            toolbar: 'insert',
            icon: '/assets/img/save.png'
        });
        function save(){
            var contents = CKEDITOR.instances.editor1.getData();
            $.post("webmaster_editor.php?pos=<?php echo $pos; ?>", {saveme: 1, content: contents}, function (data) {
                console.log(contents);
                console.log(data);
                  var response = jQuery.parseJSON(data);
                  swal(response.title, response.msg, response.status);
              });
        }
    </script>
</form>