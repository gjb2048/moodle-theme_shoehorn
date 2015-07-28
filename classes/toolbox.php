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
 * Shoehorn theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2015-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_shoehorn;

class toolbox {

    static protected $theme;

    /**
     * Finds the given tile file in the theme.  If it does not exist for the Shoehorn child theme then the parent is checked.
     * @param string $filename Filename without extension to get.
     * @return string Complete path of the file.
     */
    static public function get_tile_file($filename) {
        global $CFG, $PAGE;
        $themedir = $PAGE->theme->dir;
        $filename .= '.php';

        /* Check only if a child of 'Shoehorn' to prevent conflicts with other themes using the 'tiles' folder.
           The test is to change theme from Shoelace to Shoebrush with the theme selector and not get an error. */
        if (in_array('shoehorn', $PAGE->theme->parents)) {
            $themename = $PAGE->theme->name;
            if (file_exists("$themedir/layout/tiles/$filename")) {
                return "$themedir/layout/tiles/$filename";
            } else if (file_exists("$CFG->dirroot/theme/$themename/layout/tiles/$filename")) {
                return "$CFG->dirroot/theme/$themename/layout/tiles/$filename";
            } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/$themename/layout/tiles/$filename")) {
                return "$CFG->themedir/$themename/layout/tiles/$filename";
            }
        }
        // Check Shoehorn.
        if (file_exists("$CFG->dirroot/theme/shoehorn/layout/tiles/$filename")) {
            return "$CFG->dirroot/theme/shoehorn/layout/tiles/$filename";
        } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoehorn/layout/tiles/$filename")) {
            return "$CFG->themedir/shoehorn/layout/tiles/$filename";
        } else {
            return dirname(__FILE__)."$filename";
        }
    }

    static public function get_setting($setting, $format = false, $theme = null) {

        if (empty($theme)) {
            if (empty(self::$theme)) {
                self::$theme = \theme_config::load('shoehorn');
            }
            $theme = self::$theme;
        }

        global $CFG;
        require_once($CFG->dirroot . '/lib/weblib.php');
        if (empty($theme->settings->$setting)) {
            return false;
        } else if (!$format) {
            return $theme->settings->$setting;
        } else if ($format === 'format_text') {
            return format_text($theme->settings->$setting, FORMAT_PLAIN);
        } else if ($format === 'format_html') {
            return format_text($theme->settings->$setting, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
        } else {
            return format_string($theme->settings->$setting);
        }
    }

    /**
     * This method creates the dynamic HTML needed for the 
     * layout and then passes it back in an object so it can
     * be echo'd to the page.
     *
     * This keeps the logic out of the layout files.
     */
    static public function html_for_settings($PAGE) {
        $settings = $PAGE->theme->settings;

        $html = new \stdClass();

        $html->navbarclass = array('navbar');
        if (!empty($settings->inversenavbar)) {
            $html->navbarclass[] = 'navbar-inverse';
        } else {
            $html->navbarclass[] = 'navbar-default';
        }

        $html->containerclass = 'container-fluid';

        $html->additionalbodyclasses = array();

        $devicetype = \core_useragent::get_device_type(); // In /lib/classes/useragent.php.
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

    static public function grid($hassidepre, $hassidepost, $PAGE) {

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

    static public function showslider($settings) {
        $devicetype = \core_useragent::get_device_type(); // In moodlelib.php.
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
    static public function shown_sitepages($PAGE) {
        $pages = array();
        $settings = $PAGE->theme->settings;

        $numberofsitepages = (empty($settings->numberofsitepages)) ? false : $settings->numberofsitepages;
        if ($numberofsitepages) {
            $loggedin = isloggedin();
            $lang = current_language();
            for ($sp = 1; $sp <= $numberofsitepages; $sp++) {
                $sitepagestatus = 'sitepagestatus'.$sp;
                if (empty($settings->$sitepagestatus) or ($settings->$sitepagestatus == 2)) { // 2 is published.
                    $sitepagetitle = 'sitepagetitle'.$sp;
                    if (!empty($settings->$sitepagetitle)) {
                        $sitepagedisplay = 'sitepagedisplay'.$sp;
                        if (empty($settings->$sitepagedisplay)
                            or ($settings->$sitepagedisplay == 1) // Always.
                            or (($settings->$sitepagedisplay == 2) and ($loggedin == false)) // Logged out.
                            or (($settings->$sitepagedisplay == 3) and ($loggedin == true)) // Logged in.
                        ) {
                            $sitepagelang = 'sitepagelang'.$sp;
                            if (empty($settings->$sitepagelang) or ($settings->$sitepagelang == 'all') or ($settings->$sitepagelang == $lang)) {
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
    static public function shown_frontpageslides($PAGE) {
        $slides = array();
        $settings = $PAGE->theme->settings;

        $frontpagenumberofslides = (empty($settings->frontpagenumberofslides)) ? false : $settings->frontpagenumberofslides;
        if ($frontpagenumberofslides) {
            $loggedin = isloggedin();
            $lang = current_language();
            for ($sl = 1; $sl <= $frontpagenumberofslides; $sl++) {
                $frontpageslidestatus = 'frontpageslidestatus'.$sl;
                if (empty($settings->$frontpageslidestatus) or ($settings->$frontpageslidestatus == 2)) { // 2 is published.
                    $frontpageslidedisplay = 'frontpageslidedisplay'.$sl;
                    if (empty($settings->$frontpageslidedisplay)
                        or ($settings->$frontpageslidedisplay == 1) // Always.
                        or (($settings->$frontpageslidedisplay == 2) and ($loggedin == false)) // Logged out.
                        or (($settings->$frontpageslidedisplay == 3) and ($loggedin == true)) // Logged in.
                    ) {
                        $frontpageslidelang = 'frontpageslidelang'.$sl;
                        if (empty($settings->$frontpageslidelang) or ($settings->$frontpageslidelang == 'all') or ($theme->settings->$frontpageslidelang == $lang)) {
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
    static public function shown_loginbackgroundchanger_images($PAGE) {
        global $CFG;
        $images = array();
        $settings = $PAGE->theme->settings;

        $numberofimages = (empty($settings->loginbackgroundchangernumberofimages)) ? false : $settings->loginbackgroundchangernumberofimages;
        if (($numberofimages) && (self::showloginbackgroundchanger($settings))) {
            for ($img = 1; $img <= $numberofimages; $img++) {
                $loginbackgroundchangerimageno = 'loginbackgroundchangerimage'.$img;
                if (!empty($settings->$loginbackgroundchangerimageno)) {
                    $images[] = '"'.$PAGE->theme->setting_file_url($loginbackgroundchangerimageno, $loginbackgroundchangerimageno).'"';
               }
            }
        }

        return $images;
    }

    static public function showloginbackgroundchanger($settings) {
        $devicetype = \core_useragent::get_device_type(); // In moodlelib.php.
        if ($devicetype == "mobile") {
            $showimages = (empty($settings->loginbackgroundchangermobile)) ? false : $settings->loginbackgroundchangermobile;
        } else if ($devicetype == "tablet") {
            $showimages = (empty($settings->loginbackgroundchangertablet)) ? false : $settings->loginbackgroundchangertablet;
        } else {
            $showimages = true;
        }
        return $showimages;
    }

    static public function social_footer($settings) {
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
}
