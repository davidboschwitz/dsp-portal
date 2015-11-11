<?php
$page['auth'] = 7;
require "include/functions.inc";

switch (filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING)) {
    case 'edit':
        //TODO
        echo "Edit unsuccessful!";
        break;
    case 'delete':
        //TODO
        echo "Delete unsuccessful!";
        break;
    case 'editmultiple':
        //TODO
        echo "Edit unsuccessful!";
        break;
    case 'deletemultiple':
        //TODO
        echo "Delete unsuccessful!";
        break;
}