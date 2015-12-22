<?php
/*
 * Copyright 2015 David Boschwitz.
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
/* */
$config['version'] = 0.1;

/* */
$config['debug'] = false;

/* Timeout: set to 0 for never timeout. */
$config['timeout'] = 15 * 60; //15 minutes

/* Webmaster email address (for contact info) */
$config['webmaster_email'] = "dbosch@iastate.edu";

/* Calendar iframe src */
$config['calendar_iframe_src'] = "http://goo.gl/zQeBnx";

$config['background_color'] = '#336600';

$config['name_abbr'] = "DSP";


/* For making sure Dates/Times are correct. Will throw errors if removed */
date_default_timezone_set('US/Central');

function points_status($totalpts) {
    if ($totalpts < 100)
        return "Delinquent"; //0-99 points
    if ($totalpts < 200)
        return "Sailor"; //100-199
    if ($totalpts < 300)
        return "First Mate"; //200-299
    if ($totalpts < 400)
        return "Captian"; //300-399
    if ($totalpts < 500)
        return "Egyptian"; //400-499
    if ($totalpts < 600)
        return "Nile"; //500-599
    if ($totalpts < 700)
        return "Pyramid"; //600-699
    return "Sphinx"; //700+
}
