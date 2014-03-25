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
    global $OUTPUT;
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

    if (!empty($theme->settings->showloginmessage)) {
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

function shoehorn_grid($hassidepre, $hassidepost) {
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
    return $regions;
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
        } else if (substr($filearea, 0, 19) === 'frontpageslideimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (substr($filearea, 0, 14) === 'imagebankimage') {
            $theme = theme_config::load('shoehorn');
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
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
        for ($i = 1; $i <= $numberofsociallinks; $i++) {
            $name = 'social'.$i;
            if (!empty($PAGE->theme->settings->$name)) {
                $haveicons = true;
                break;
            }
        }
    }

    if ($haveicons) {
        // Max social links of 16.
        $diff = round($numberofsociallinks / 7);
        $side = 5 - $diff;
        $centre = 2 + ($diff * 2);
        $cols['side'] = 'col-sm-'.$side.' col-md-'.$side.' col-lg-'.$side;
        $cols['centre'] = 'col-sm-'.$centre.' col-md-'.$centre.' col-lg-'.$centre;
    } else {
        $cols['side'] = 'col-sm-6 col-md-6 col-lg-6';
    }

    return $cols;
}