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
        <title>Page Editor</title>
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
        CKEDITOR.instances.editor1.config.removeButtons = 'Save,NewPage,Preview';
        
        CKEDITOR.instances.editor1.addCommand("saveme", { // create named command
            exec: function(edt) {
                save();
            }
        });
        
        CKEDITOR.instances.editor1.ui.addButton('CustomSave', { // add new button and bind our command
            label: "Save",
            command: 'saveme',
            toolbar: 'document',
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
        
        //add most google fonts
        myFonts = ['Aclonica', 'Allan', 'Allerta', 'Allerta Stencil', 'Amaranth', 'Angkor', 'Annie Use Your Telescope', 'Anonymous Pro', 'Anton', 'Architects Daughter', 'Arimo', 'Artifika', 'Arvo', 'Astloch', 'Bangers', 'Battambang', 'Bayon', 'Bentham', 'Bevan', 'Bigshot One', 'Bokor', 'Brawler', 'Buda', 'Cabin', 'Cabin Sketch', 'Calligraffitti', 'Candal', 'Cantarell', 'Cardo', 'Carter One', 'Caudex', 'Chenla', 'Cherry Cream Soda', 'Chewy', 'Coda', 'Coda Caption', 'Coming Soon', 'Content', 'Copse', 'Corben', 'Cousine', 'Covered By Your Grace', 'Crafty Girls', 'Crimson Text', 'Crushed', 'Cuprum', 'Damion', 'Dancing Script', 'Dangrek', 'Dawning of a New Day', 'Didact Gothic', 'Droid Sans', 'Droid Sans Mono', 'Droid Serif', 'EB Garamond', 'Expletus Sans', 'Fontdiner Swanky', 'Francois One', 'Freehand', 'GFS Didot', 'GFS Neohellenic', 'Geo', 'Goudy Bookletter 1911', 'Gruppo', 'Hanuman', 'Holtwood One SC', 'Homemade Apple', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica', 'IM Fell Double Pica SC', 'IM Fell English', 'IM Fell English SC', 'IM Fell French Canon', 'IM Fell French Canon SC', 'IM Fell Great Primer', 'IM Fell Great Primer SC', 'Inconsolata', 'Indie Flower', 'Irish Grover', 'Josefin Sans', 'Josefin Slab', 'Judson', 'Jura', 'Just Another Hand', 'Just Me Again Down Here', 'Kenia', 'Khmer', 'Koulen', 'Kranky', 'Kreon', 'Kristi', 'Lato', 'League Script', 'Lekton', 'Limelight', 'Lobster', 'Lora', 'Luckiest Guy', 'Maiden Orange', 'Mako', 'Maven Pro', 'Meddon', 'MedievalSharp', 'Megrim', 'Merriweather', 'Metal', 'Metrophobic', 'Michroma', 'Miltonian', 'Miltonian Tattoo', 'Molengo', 'Monofett', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Muli', 'Neucha', 'Neuton', 'News Cycle', 'Nobile', 'Nova Cut', 'Nova Flat', 'Nova Mono', 'Nova Oval', 'Nova Round', 'Nova Script', 'Nova Slim', 'Nova Square', 'Nunito', 'OFL Sorts Mill Goudy TT', 'Odor Mean Chey', 'Old Standard TT', 'Open Sans', 'Open Sans Condensed', 'Orbitron', 'Oswald', 'Over the Rainbow', 'PT Sans', 'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption', 'Pacifico', 'Paytone One', 'Permanent Marker', 'Philosopher', 'Play', 'Playfair Display', 'Podkova', 'Preahvihear', 'Puritan', 'Quattrocento', 'Quattrocento Sans', 'Radley', 'Raleway', 'Reenie Beanie', 'Rock Salt', 'Rokkitt', 'Ruslan Display', 'Schoolbell', 'Shanti', 'Siemreap', 'Sigmar One', 'Six Caps', 'Slackey', 'Smythe', 'Sniglet', 'Special Elite', 'Sue Ellen Francisco', 'Sunshiney', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tangerine', 'Taprom', 'Tenor Sans', 'Terminal Dosis Light', 'The Girl Next Door', 'Tinos', 'Ubuntu', 'Ultra', 'UnifrakturCook', 'UnifrakturMaguntia', 'Unkempt', 'VT323', 'Vibur', 'Vollkorn', 'Waiting for the Sunrise', 'Wallpoet', 'Walter Turncoat', 'Wire One', 'Yanone Kaffeesatz'];

CKEDITOR.instances.editor1.config.font_names = 'serif;sans serif;monospace;cursive;fantasy';

for(var i = 0; i<myFonts.length; i++){
      CKEDITOR.instances.editor1.config.font_names = CKEDITOR.instances.editor1.config.font_names+';'+myFonts[i];
      myFonts[i] = 'https://fonts.googleapis.com/css?family='+myFonts[i].replace(' ','+');
}

CKEDITOR.instances.editor1.config.contentsCss = ['/ckeditor/contents.css'].concat(myFonts);
        
        //remind them to save
        swal("Reminder", "Make sure you hit the save button before navigating away from this page or changing the document you're editing", "warning");
    </script>
</form>