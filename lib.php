<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Shoehorn theme with the underlying Bootstrap theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function theme_shoehorn_process_css($css, $theme) {
    // Set the background image for the logo.
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_shoehorn_set_logo($css, $logo);

    // Show login message if desired.
    $css = theme_shoehorn_set_loginmessage($css, $theme);

    // Process look and feel.
    $css = theme_shoehorn_set_landf($css, $theme);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_shoehorn_set_customcss($css, $customcss);

    return $css;
}

function theme_shoehorn_set_logo($css, $logo) {
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoehorn_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoehorn_set_loginmessage($css, $theme) {
    $tag = '[[setting:theloginmessge]]';

    if ((!empty($theme->settings->showloginmessage)) && ($theme->settings->showloginmessage == 2)) {
        $content = "content: '";
        if (!empty($theme->settings->loginmessage)) {
            $replacement = $content.$theme->settings->loginmessage."';";
        } else {
            $replacement = $content.get_string('theloginmessage', 'theme_shoehorn')."';";
        }
    } else {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoehorn_set_landf($css, $theme) {

    // All pages image.
    $tag = '[[setting:landfallpagesbackgroundimage]]';
    $landfallpagesbackgroundimage = $theme->setting_file_url('landfallpagesbackgroundimage', 'landfallpagesbackgroundimage');
    if ($landfallpagesbackgroundimage) {
        $replacement = 'background:  url(\''.$landfallpagesbackgroundimage.'\') repeat; margin-bottom: -26px;';
    } else {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);

    // All pages transparency.
    $tag = '[[setting:landfallpagescontenttransparency]]';
    $tagmain = '[[setting:landfallpagescontenttransparencymain]]';

    $replacement = 'background-color: rgba(255, 255, 255, ';
    /* http://css-tricks.com/css-transparency-settings-for-all-broswers/ */
    $replacementmain = 'zoom: 1; filter: alpha(opacity=';
    if (!empty($theme->settings->landfallpagescontenttransparency)) {
        $replacement .= $theme->settings->landfallpagescontenttransparency / 100;
        $replacementmain .= $theme->settings->landfallpagescontenttransparency;
        $replacementmain .= '); opacity: ';
        $replacementmain .= $theme->settings->landfallpagescontenttransparency / 100;
    } else {
        $replacementmain .= '100); opacity: 1.0';
        $replacement = '1.0';
    }
    $replacement .= ');';
    $replacementmain .= ';';

    $css = str_replace($tag, $replacement, $css);
    $css = str_replace($tagmain, $replacementmain, $css);

    // Front page image.
    $tag = '[[setting:landffrontpagebackgroundimage]]';
    $landffrontpagebackgroundimage = $theme->setting_file_url('landffrontpagebackgroundimage', 'landffrontpagebackgroundimage');
    if ($landffrontpagebackgroundimage) {
        $replacement = 'background:  url(\''.$landffrontpagebackgroundimage.'\') repeat; margin-bottom: -26px;';
    } else {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);

    // Front page transparency.
    $tag = '[[setting:landffrontpagecontenttransparency]]';
    $tagmain = '[[setting:landffrontpagecontenttransparencymain]]';

    $replacement = 'background-color: rgba(255, 255, 255, ';
    /* http://css-tricks.com/css-transparency-settings-for-all-broswers/ */
    $replacementmain = 'zoom: 1; filter: alpha(opacity=';
    if (!empty($theme->settings->landffrontpagecontenttransparency)) {
        $replacement .= $theme->settings->landffrontpagecontenttransparency / 100;
        $replacementmain .= $theme->settings->landffrontpagecontenttransparency;
        $replacementmain .= '); opacity: ';
        $replacementmain .= $theme->settings->landffrontpagecontenttransparency / 100;
    } else {
        $replacementmain .= '100); opacity: 1.0';
        $replacement = '1.0';
    }
    $replacement .= ');';
    $replacementmain .= ';';

    $css = str_replace($tag, $replacement, $css);
    $css = str_replace($tagmain, $replacementmain, $css);

    return $css;
}

/**
 * This function creates the dynamic HTML needed for the 
 * layout and then passes it back in an object so it can
 * be echo'd to the page.
 *
 * This keeps the logic out of the layout files.
 */
function theme_shoehorn_html_for_settings($PAGE) {
    $settings = $PAGE->theme->settings;

    $html = new stdClass;

    $html->navbarclass = array('navbar');
    if (!empty($settings->inversenavbar)) {
        $html->navbarclass[] = 'navbar-inverse';
    } else {
        $html->navbarclass[] = 'navbar-default';
    }

    $html->containerclass = 'container-fluid';

    $html->additionalbodyclasses = array();

    $devicetype = core_useragent::get_device_type(); // In /lib/classes/useragent.php.
    if ($devicetype == "mobile") {
        $html->additionalbodyclasses[] = 'mobiledevice';
    } else if ($devicetype == "tablet") {
        $html->additionalbodyclasses[] = 'tabletdevice';
    }

    if ((!empty($settings->coursetiles)) and ($settings->coursetiles == 2)) {
        $html->additionalbodyclasses[] = 'coursetiles';
    }

    if (!empty($settings->fontawesome) && ($settings->fontawesome == 1)) {
        $html->additionalbodyclasses[] = 'fontawesome';
        $html->fontawesome = true;
    } else {
        $html->fontawesome = false;
    }

    if (!empty($settings->socialsignpost)) {
        $html->additionalbodyclasses[] = 'socialsignpost';
    }

    if (!empty($settings->compactnavbar)) {
        $html->additionalbodyclasses[] = 'compactnavbar';
    }

    if (!empty($settings->navbarfixedtop)) {
        $html->additionalbodyclasses[] = 'navbarfixedtop';
        $html->navbarclass[] = 'navbar-fixed-top'; 
    }

    if ($PAGE->pagelayout == 'frontpage') {
        if (!empty($settings->landffrontpagebackgroundimage)) {
            $html->additionalbodyclasses[] = 'frontpagebackgroundimage';
        }
    } else {
        if (!empty($settings->landfallpagesbackgroundimage)) {
            $html->additionalbodyclasses[] = 'allpagesbackgroundimage';
        }
    }
    return $html;
}

function shoehorn_grid($hassidepre, $hassidepost) {
    global $PAGE;

    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-4 col-md-6 col-lg-8');
        $regions['pre'] = 'col-sm-4 col-md-3 col-lg-2';
        $regions['post'] = 'col-sm-4 col-md-3 col-lg-2';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-8 col-md-9 col-lg-10');
        $regions['pre'] = 'col-sm-4 col-md-3 col-lg-2';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-8 col-md-9 col-lg-10');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-4 col-md-3 col-lg-2';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }

    if (('rtl' === get_string('thisdirection', 'langconfig')) && (empty($PAGE->theme->settings->dynamiclang))) {
        if ($hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-4 col-sm-push-8 col-md-6 col-md-push-6 col-lg-8 col-lg-push-4');
            $regions['pre'] = 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-6 col-lg-2 col-lg-pull-4';
            $regions['post'] = 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-6 col-lg-2 col-lg-pull-4';
        } else if ($hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-sm-8 col-sm-push-4 col-md-9 col-md-push-3 col-lg-10 col-lg-push-2');
            $regions['pre'] = 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9 col-lg-2 col-lg-pull-10';
            $regions['post'] = 'empty';
        } else if (!$hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-8 col-sm-push-4 col-md-9 col-md-push-3 col-lg-10 col-lg-push-2');
            $regions['pre'] = 'empty';
            $regions['post'] = 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-6 col-lg-2 col-lg-pull-4';
        }
    }
    return $regions;
}

// Moodle CSS file serving.
function theme_shoehorn_get_csswww() {
    global $CFG;

    if (right_to_left()) {
        $moodlecss = 'moodle-rtl.css';
    } else {
        $moodlecss = 'moodle.css';
    }

    $syscontext = context_system::instance();
    $itemid = theme_get_revision();
    $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/$syscontext->id/theme_shoehorn/style/$itemid/$moodlecss");
    // Now this is tricky because the we can not hard code http or https here, lets use the relative link.
    // Note: unfortunately moodle_url does not support //urls yet.
    $url = preg_replace('|^https?://|i', '//', $url->out(false));

    return $url;
}


function shoehorn_showslider($settings) {
    $devicetype = core_useragent::get_device_type(); // In moodlelib.php.
    if ($devicetype == "mobile") {
        $showslider = (empty($settings->frontpageslidermobile)) ? false : $settings->frontpageslidermobile;
    } else if ($devicetype == "tablet") {
        $showslider = (empty($settings->frontpageslidertablet)) ? false : $settings->frontpageslidertablet;
    } else {
        $showslider = true;
    }
    return $showslider;
}

/**
 * States if the site pages can be shown.
 *
 * @return array of pageid => 1 = no, 2 = yes.
 */
function shoehorn_shown_sitepages() {
    $pages = array();
    $theme = theme_config::load('shoehorn');

    $numberofsitepages = (empty($theme->settings->numberofsitepages)) ? false : $theme->settings->numberofsitepages;
    if ($numberofsitepages) {
        $loggedin = isloggedin();
        $lang = current_language();
        for ($sp = 1; $sp <= $numberofsitepages; $sp++) {
            $sitepagestatus = 'sitepagestatus'.$sp;
            if (empty($theme->settings->$sitepagestatus) or ($theme->settings->$sitepagestatus == 2)) { // 2 is published.
                $sitepagetitle = 'sitepagetitle'.$sp;
                if (!empty($theme->settings->$sitepagetitle)) {
                    $sitepagedisplay = 'sitepagedisplay'.$sp;
                    if (empty($theme->settings->$sitepagedisplay)
                        or ($theme->settings->$sitepagedisplay == 1) // Always 
                        or (($theme->settings->$sitepagedisplay == 2) and ($loggedin == false)) // Logged out.
                        or (($theme->settings->$sitepagedisplay == 3) and ($loggedin == true)) // Logged in.
                    ) {
                        $sitepagelang = 'sitepagelang'.$sp;
                        if (empty($theme->settings->$sitepagelang) or ($theme->settings->$sitepagelang == 'all') or ($theme->settings->$sitepagelang == $lang)) {
                            // Page can be shown.
                            $pages[$sp] = 2;
                        } else {
                            // Page is not shown.
                            $pages[$sp] = 1;
                        }
                    } else {
                        // Page is known but not shown.
                        $pages[$sp] = 1;
                    }
                } else {
                    // Page is known but has no title.
                    $pages[$sp] = 3;
                }
            } else {
                // Page is known but not published.
                $pages[$sp] = 4;
            }
        }
    }

    return $pages;
}

/**
 * States if the front page slides can be shown.
 *
 * @return array of slideno => 1 = no, 2 = yes.
 */
function shoehorn_shown_frontpageslides() {
    $slides = array();
    $theme = theme_config::load('shoehorn');

    $frontpagenumberofslides = (empty($theme->settings->frontpagenumberofslides)) ? false : $theme->settings->frontpagenumberofslides;
    if ($frontpagenumberofslides) {
        $loggedin = isloggedin();
        $lang = current_language();
        for ($sl = 1; $sl <= $frontpagenumberofslides; $sl++) {
            $frontpageslidestatus = 'frontpageslidestatus'.$sl;
            if (empty($theme->settings->$frontpageslidestatus) or ($theme->settings->$frontpageslidestatus == 2)) { // 2 is published.
                $frontpageslidedisplay = 'frontpageslidedisplay'.$sl;
                if (empty($theme->settings->$frontpageslidedisplay)
                    or ($theme->settings->$frontpageslidedisplay == 1) // Always 
                    or (($theme->settings->$frontpageslidedisplay == 2) and ($loggedin == false)) // Logged out.
                    or (($theme->settings->$frontpageslidedisplay == 3) and ($loggedin == true)) // Logged in.
                ) {
                    $frontpageslidelang = 'frontpageslidelang'.$sl;
                    if (empty($theme->settings->$frontpageslidelang) or ($theme->settings->$frontpageslidelang == 'all') or ($theme->settings->$frontpageslidelang == $lang)) {
                        // Slide can be shown.
                        $slides[$sl] = 2;
                    } else {
                        // Slide is not shown.
                        $slides[$sl] = 1;
                    }
                }
            }
        }
    }

    return $slides;
}

/**
 * States the number of background images (if any).
 *
 * @return array of background image urls or empty array if none.
 */
function shoehorn_shown_loginbackgroundchanger_images() {
    $images = array();
    $theme = theme_config::load('shoehorn');

    $numberofimages = (empty($theme->settings->loginbackgroundchangernumberofimages)) ? false : $theme->settings->loginbackgroundchangernumberofimages;
    if (($numberofimages) && (shoehorn_showloginbackgroundchanger($theme->settings))) {
        for ($img = 1; $img <= $numberofimages; $img++) {
            $loginbackgroundchangerimageno = 'loginbackgroundchangerimage'.$img;
            if (!empty($theme->settings->$loginbackgroundchangerimageno)) {
                $images[] = '"'.$theme->setting_file_url($loginbackgroundchangerimageno, $loginbackgroundchangerimageno).'"';
            }
        }
    }

    return $images;
}

function shoehorn_showloginbackgroundchanger($settings) {
    $devicetype = core_useragent::get_device_type(); // In moodlelib.php.
    if ($devicetype == "mobile") {
        $showimages = (empty($settings->loginbackgroundchangermobile)) ? false : $settings->loginbackgroundchangermobile;
    } else if ($devicetype == "tablet") {
        $showimages = (empty($settings->loginbackgroundchangertablet)) ? false : $settings->loginbackgroundchangertablet;
    } else {
        $showimages = true;
    }
    return $showimages;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_shoehorn_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'logo') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if ($filearea === 'style') {
            global $CFG;
            if (!empty($CFG->themedir)) {
                $thestylepath = $CFG->themedir . '/shoehorn/style/experimental/';
            } else {
                $thestylepath = $CFG->dirroot . '/theme/shoehorn/style/experimental/';
            }
            send_file($thestylepath.$args[1], $args[1], 20 , 0, false, false, 'text/css');
        } else if (substr($filearea, 0, 19) === 'frontpageslideimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (substr($filearea, 0, 14) === 'imagebankimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (substr($filearea, 0, 27) === 'loginbackgroundchangerimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if ($filearea === 'syntaxhighlighter') {
            global $CFG;
            if (!empty($CFG->themedir)) {
                $thesyntaxhighlighterpath = $CFG->themedir . '/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/';
            } else {
                $thesyntaxhighlighterpath = $CFG->dirroot . '/theme/shoehorn/javascript/syntaxhighlighter_3_0_83/scripts/';
            }

            // Note: Third parameter is normally 'default' which is the 'lifetime' of the file.  Here set lower for development purposes.
            send_file($thesyntaxhighlighterpath.$args[1], $args[1], 20 , 0, false, false, 'application/javascript');
        } else if ($filearea === 'landffrontpagebackgroundimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve('landffrontpagebackgroundimage', $args, $forcedownload, $options);
        } else if ($filearea === 'landfallpagesbackgroundimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve('landfallpagesbackgroundimage', $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}

function shoehorn_social_footer($settings) {
    $numberofsociallinks = (empty($settings->numberofsociallinks)) ? false : $settings->numberofsociallinks;
    $haveicons = false;
    if ($numberofsociallinks) {
        for ($sli = 1; $sli <= $numberofsociallinks; $sli++) {
            $name = 'social'.$sli;
            if (!empty($settings->$name)) {
                $haveicons = true;
                break;
            }
        }
    }

    if ($haveicons) {
        // Max social links of 16.
        $diff = floor($numberofsociallinks / 6);
        $side = 5 - $diff;
        $centre = 2 + ($diff * 2);
        $cols['side'] = 'col-sm-'.$side.' col-md-'.$side.' col-lg-'.$side;
        $cols['centre'] = 'col-sm-'.$centre.' col-md-'.$centre.' col-lg-'.$centre.' post-size-'.$diff;
    } else {
        $cols['side'] = 'col-sm-6 col-md-6 col-lg-6';
        $cols['centre'] = '';
    }

    return $cols;
}

function shoehorn_hex2rgb($hex) {
    // From: http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/.
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    return implode(",", $rgb); // returns the rgb values separated by commas
    //return $rgb; // returns an array with the rgb values
}
