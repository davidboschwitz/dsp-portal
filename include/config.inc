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
/* */
$config['version'] = 0.1;

/* */
$config['debug'] = false;

/* Timeout: set to 0 for never timeout. */
$config['timeout'] = 15 * 60; //15 minutes

/* Webmaster email address (for contact info) */
$config['webmaster_email'] = "dbosch@iastate.edu";

/* Calendar iframe src */
$config['calendar_iframe_src'] = "https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23FFFFFF&src=deltasigiowastate@gmail.com&color=%23125A12&src=4ue0itf8p19jv09u3vsr0qd1ps@group.calendar.google.com&color=%23691426&src=skscbj4315r82akqnvtvo8a0s4@group.calendar.google.com&color=%23333333&ctz=America/Chicago&src=isugreekaffairs@gmail.com&color=navy";

$config['background_color'] = '#FFFFFF';

$config['name_abbr'] = "DSP";
$config['name_organization'] = "Delta Sigma Phi";
$config['name_chapter'] = "Beta Alpha";
$config['name_school'] = "Iowa State University";

$config['contact_address'] = "307 Lynn Ave, Ames, Iowa  50014";
$config['contact_address_googlemaps'] = "https://www.google.com/maps/dir//".$config['contact_address'];

/* Social Icons on the Footer (Set to NULL to not display) */
$config['social_facebook'] = "https://www.facebook.com/DeltaSigIAState";
$config['social_twitter'] = "https://twitter.com/DeltaSigISU";
$config['social_youtube'] = NULL;
$config['social_flickr'] = NULL;
$config['social_instagram'] = "https://www.instagram.com/deltasigisu/";

/* ex iastate.edu */
$config['email_domain'] = "iastate.edu";

$config['editable_file_names'] = array("assets/html/index.html", "assets/html/test.html", "assets/html/recruitment.html", "assets/html/about.html", "assets/html/history.html");


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

/** assume alpha = 1*/
function get_greek_num($num) {
    if($num == 0)
      return "Alumni";
    $num--;
    $alphabet = array("Alpha", "Beta", "Gamma", "Delta", "Epsilon", "Zeta", "Eta", "Theta", "Iota", "Kappa", "Lambda", "Mu", "Nu", "Xi", "Omicron", "Pi", "Rho", "Sigma", "Tau", "Upsilon", "Phi", "Chi", "Psi", "Omega");
    $out = "";
    if($num > 23) {
      $out .= $alphabet[($num / 24) - 1] . " ";
      $num -= 24;
    }
    $out .= $alphabet[($num) % 24];
    return $out;
}

/** puts the star next to an exec position */
function get_exec_star($position){
    switch($position){
        case 'President':
        case 'Sargent at Arms':
        case 'Secretary':
            return "<i class=\"fa fa-star\" aria-hidden=\"true\" style=\"\"></i>";
    }
    return "";
}
