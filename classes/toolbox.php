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

    protected $corerenderer = null;
    protected static $instance;

    private function __construct() {
    }

    public static function get_instance() {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Sets the core_renderer class instance so that when purging all caches and 'theme_xxx_process_css' etc.
     * the settings are correct.
     * @param class core_renderer $core Child object of core_renderer class.
     */
    static public function set_core_renderer($core) {
            global $PAGE, $CFG, $OUTPUT;
			error_log('set_core_renderer: ');
			error_log('P : '.print_r($PAGE->theme->name, true));
			error_log('C : '.print_r($CFG->theme, true));
			error_log('O : '.get_class($OUTPUT));
			error_log('C : '.get_class($core));
			$dbst = debug_backtrace();
			error_log('ST:');
			foreach ($dbst as $dbstentry) {
				if (!empty($dbstentry['file'])) {
					error_log('file: '.$dbstentry['file']);
				}
				if (!empty($dbstentry['line'])) {
					error_log(' - line: '.$dbstentry['line']);
				}
				if (!empty($dbstentry['function'])) {
					error_log(' - function: '.$dbstentry['function']);
				}
				if (!empty($dbstentry['class'])) {
					error_log(' - class: '.$dbstentry['class']);
				}
				if (!empty($dbstentry['object'])) {
					error_log(' - object: '.get_class($dbstentry['object']));
				}
			}
        $us = self::get_instance();
        // Set only once from the initial calling lib.php process_css function so that subsequent parent calls do not override it.
        // Must happen before parents.
        if (null === $us->corerenderer) {
            $us->corerenderer = $core;
			error_log('set_core_renderer set to: '.get_class($us->corerenderer));
        } else {
			error_log('set_core_renderer not set to: '.get_class($core));
		}
    }

    /**
     * Finds the given tile file in the theme.  If it does not exist for the Shoehorn child theme then the parent is checked.
     * @param string $filename Filename without extension to get.
     * @return string Complete path of the file.
     */
    static public function get_tile_file($filename) {
        $us = self::check_corerenderer();
        return $us->get_tile_file($filename);
    }

    /**
     * Finds the given setting in the theme from the themes' configuration object.
     * @param string $setting Setting name.
     * @param string $format false|'format_text'|'format_html'.
     * @param theme_config $theme null|theme_config object.
     * @return any false|value of setting.
     */
    static public function get_setting($setting, $format = false, $default = false) {
        $us = self::check_corerenderer();
        $settingvalue = $us->get_setting($setting);

        global $CFG;
        require_once($CFG->dirroot . '/lib/weblib.php');
        if (empty($settingvalue)) {
            return $default;
        } else if (!$format) {
            return $settingvalue;
        } else if ($format === 'format_text') {
            return format_text($settingvalue, FORMAT_PLAIN);
        } else if ($format === 'format_html') {
            return format_text($settingvalue, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
        } else {
            return format_string($settingvalue);
        }
    }

    static public function setting_file_url($setting, $filearea) {
        $us = self::check_corerenderer();
        return $us->setting_file_url($setting, $filearea);
    }

    static public function pix_url($imagename, $component) {
        $us = self::check_corerenderer();
        return $us->pix_url($imagename, $component);
    }

    static private function check_corerenderer() {
        $us = self::get_instance();
        if (empty($us->corerenderer)) {
            // Use $OUTPUT unless is not a Shoehorn or child core_renderer which can happen on theme switch.
            global $PAGE, $CFG, $OUTPUT;
			error_log('check_corerenderer: ');
			error_log('P : '.print_r($PAGE->theme->name, true));
			error_log('C : '.print_r($CFG->theme, true));
			error_log('O : '.get_class($OUTPUT));
			$dbst = debug_backtrace();
			error_log('ST:');
			foreach ($dbst as $dbstentry) {
				if (!empty($dbstentry['file'])) {
					error_log('file: '.$dbstentry['file']);
				}
				if (!empty($dbstentry['line'])) {
					error_log(' - line: '.$dbstentry['line']);
				}
				if (!empty($dbstentry['function'])) {
					error_log(' - function: '.$dbstentry['function']);
				}
				if (!empty($dbstentry['class'])) {
					error_log(' - class: '.$dbstentry['class']);
				}
				if (!empty($dbstentry['object'])) {
					error_log(' - object: '.get_class($dbstentry['object']));
				}
			}
            //$us->corerenderer = $PAGE->get_renderer('theme_'.$CFG->theme, 'core');
            if (property_exists($OUTPUT, 'shoehorn')) {
                $us->corerenderer = $OUTPUT;
				error_log('check_corerenderer: $OUTPUT');
            } else {
                // Use $PAGE->theme->name as will be accurate than $CFG->theme when using URL theme changes.
                // Core 'allowthemechangeonurl' setting.
                global $PAGE;
                $corerenderer = $PAGE->get_renderer('theme_'.$PAGE->theme->name, 'core');
				error_log('check_corerenderer - get_class 1: '.get_class($corerenderer));
                // Fallback check.
                if (property_exists($corerenderer, 'shoehorn')) {
                    $us->corerenderer = $corerenderer;
					error_log('check_corerenderer: $PAGE');
                } else {
                    // Probably during theme switch, '$CFG->theme' will be accurrate.
                    global $CFG;
                    $corerenderer = $PAGE->get_renderer('theme_'.$CFG->theme, 'core');
					error_log('check_corerenderer - get_class 2: '.get_class($corerenderer));
                    if (property_exists($corerenderer, 'shoehorn')) {
                        $us->corerenderer = $corerenderer;
						error_log('check_corerenderer: $CFG');
                    } else {
                        // Last resort.  Hopefully will be fine on next page load for Child themes.
                        // However '***_process_css' in lib.php will be fine as it sets the correct renderer.
                        $us->corerenderer = $PAGE->get_renderer('theme_shoehorn', 'core');
						error_log('check_corerenderer: fallback');
                    }
                }
            }
        }
		error_log('check_corerenderer - get_class e: '.get_class($us->corerenderer));
        return $us->corerenderer;
    }

    /**
     * Finds the given setting in the theme using the get_config core function for when the theme_config
     * object has not been created.
     * @param string $setting Setting name.
     * @param themename $themename null(default of 'shoehorn' used)|theme name.
     * @return any false|value of setting.
     */
    static public function get_config_setting($setting, $themename = null) {
        if (empty($themename)) {
            $themename = 'shoehorn';
        }
        return \get_config('theme_' . $themename, $setting);
    }

    /**
     * This method creates the dynamic HTML needed for the
     * layout and then passes it back in an object so it can
     * be echo'd to the page.
     *
     * @param $theme Theme to use if not parent.
     *
     * This keeps the logic out of the layout files.
     */
    static public function html_for_settings() {

        global $PAGE;

        $html = new \stdClass();

        $html->navbarclass = array('navbar');
        $inversenavbar = self::get_setting('inversenavbar');
        if (!empty($inversenavbar)) {
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

        $coursetiles = self::get_setting('coursetiles');
        if ((!empty($coursetiles)) and ( $coursetiles == 2)) {
            $html->additionalbodyclasses[] = 'coursetiles';
        }

        $fontawesome = self::get_setting('fontawesome');
        if (!empty($fontawesome)) {
            $html->additionalbodyclasses[] = 'fontawesome';
            $html->fontawesome = true;
        } else {
            $html->fontawesome = false;
        }

        $socialsignpost = self::get_setting('socialsignpost');
        if (!empty($socialsignpost)) {
            $html->additionalbodyclasses[] = 'socialsignpost';
        }

        $compactnavbar = self::get_setting('compactnavbar');
        if (!empty($compactnavbar)) {
            $html->additionalbodyclasses[] = 'compactnavbar';
        }

        $navbarfixedtop = self::get_setting('navbarfixedtop');
        if (!empty($navbarfixedtop)) {
            $html->additionalbodyclasses[] = 'navbarfixedtop';
            $html->navbarclass[] = 'navbar-fixed-top';
        }

        if ($PAGE->pagelayout == 'frontpage') {
            $landffrontpagebackgroundimage = self::get_setting('landffrontpagebackgroundimage');
            if (!empty($landffrontpagebackgroundimage)) {
                $html->additionalbodyclasses[] = 'frontpagebackgroundimage';
            }
        } else {
            $landfallpagesbackgroundimage = self::get_setting('landfallpagesbackgroundimage');
            if (!empty($landfallpagesbackgroundimage)) {
                $html->additionalbodyclasses[] = 'allpagesbackgroundimage';
            }
        }

        $landfallhorizontalquiz = self::get_setting('landfallhorizontalquiz');
        if ((!empty($landfallhorizontalquiz)) && ($PAGE->pagelayout == 'incourse')) {
            $html->additionalbodyclasses[] = 'horizontalquiz';
        }

        return $html;
    }

    static public function grid($hassidepre, $hassidepost) {

        if ($hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-4 col-md-6 col-lg-8');
            $regions['pre'] = 'col-sm-4 col-md-3 col-lg-2';
            $regions['post'] = 'col-sm-4 col-md-3 col-lg-2';
        } else if ($hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-sm-8 col-md-9 col-lg-10');
            $regions['pre'] = 'col-sm-4 col-md-3 col-lg-2';
            $regions['post'] = 'empty';
        } else if (!$hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-8 col-md-9 col-lg-10');
            $regions['pre'] = 'empty';
            $regions['post'] = 'col-sm-4 col-md-3 col-lg-2';
        } else if (!$hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-md-12');
            $regions['pre'] = 'empty';
            $regions['post'] = 'empty';
        }

        if ('rtl' === get_string('thisdirection', 'langconfig')) {
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

    static public function showslider() {
        $devicetype = \core_useragent::get_device_type(); // In moodlelib.php.
        if ($devicetype == "mobile") {
            $showslider = self::get_setting('frontpageslidermobile', false);
        } else if ($devicetype == "tablet") {
            $showslider = self::get_setting('frontpageslidertablet', false);
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
    static public function shown_sitepages() {
        $pages = array();

        $numberofsitepages = self::get_setting('numberofsitepages');
        if ($numberofsitepages) {
            $loggedin = isloggedin();
            $lang = current_language();
            for ($sp = 1; $sp <= $numberofsitepages; $sp++) {
                $sitepagestatus = self::get_setting('sitepagestatus' . $sp);
                if (empty($sitepagestatus) or ($sitepagestatus == 2)) { // 2 is published.
                    $sitepagetitle = self::get_setting('sitepagetitle' . $sp);
                    if (!empty($sitepagetitle)) {
                        $sitepagedisplay = self::get_setting('sitepagedisplay' . $sp);
                        if (empty($sitepagedisplay)
                                or ($sitepagedisplay == 1) // Always.
                                or (($sitepagedisplay == 2) and ($loggedin == false)) // Logged out.
                                or (($sitepagedisplay == 3) and ($loggedin == true)) // Logged in.
                        ) {
                            $sitepagelang = self::get_setting('sitepagelang' . $sp);
                            if (empty($sitepagelang) or ($sitepagelang == 'all') or ($sitepagelang == $lang)) {
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
    static public function shown_frontpageslides() {
        $slides = array();

        $frontpagenumberofslides = self::get_setting('frontpagenumberofslides');
        if ($frontpagenumberofslides) {
            $loggedin = isloggedin();
            $lang = current_language();
            for ($sl = 1; $sl <= $frontpagenumberofslides; $sl++) {
                $frontpageslidestatus = self::get_setting('frontpageslidestatus' . $sl);
                if (empty($frontpageslidestatus) or ($frontpageslidestatus == 2)) { // 2 is published.
                    $frontpageslidedisplay = self::get_setting('frontpageslidedisplay' . $sl);
                    if (empty($frontpageslidedisplay)
                            or ($frontpageslidedisplay == 1) // Always.
                            or (($frontpageslidedisplay == 2) and ($loggedin == false)) // Logged out.
                            or (($frontpageslidedisplay == 3) and ($loggedin == true)) // Logged in.
                    ) {
                        $frontpageslidelang = self::get_setting('frontpageslidelang' . $sl);
                        if (empty($frontpageslidelang) or ($frontpageslidelang == 'all') or ($frontpageslidelang == $lang)) {
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
    static public function shown_loginbackgroundchanger_images() {
        $images = array();

        $numberofimages = self::get_setting('loginbackgroundchangernumberofimages');
        if (($numberofimages) && (self::showloginbackgroundchanger())) {
            for ($img = 1; $img <= $numberofimages; $img++) {
                $loginbackgroundchangerimageno = self::get_setting('loginbackgroundchangerimage' . $img);
                if ($loginbackgroundchangerimageno) {
                    $images[] = self::setting_file_url('loginbackgroundchangerimage' . $img, 'loginbackgroundchangerimage' . $img);
                }
            }
        }

        return $images;
    }

    static private function showloginbackgroundchanger() {
        $devicetype = \core_useragent::get_device_type(); // In moodlelib.php.
        if ($devicetype == "mobile") {
            $showimages = self::get_setting('loginbackgroundchangermobile');
        } else if ($devicetype == "tablet") {
            $showimages = self::get_setting('loginbackgroundchangertablet');
        } else {
            $showimages = true;
        }
        return $showimages;
    }

    static public function social_footer() {
        $numberofsociallinks = self::get_setting('numberofsociallinks');
        $haveicons = false;
        if ($numberofsociallinks) {
            for ($sli = 1; $sli <= $numberofsociallinks; $sli++) {
                $name = self::get_setting('social' . $sli);
                if (!empty($name)) {
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
            $cols['side'] = 'col-sm-' . $side . ' col-md-' . $side . ' col-lg-' . $side;
            $cols['centre'] = 'col-sm-' . $centre . ' col-md-' . $centre . ' col-lg-' . $centre . ' post-size-' . $diff;
        } else {
            $cols['side'] = 'col-sm-6 col-md-6 col-lg-6';
            $cols['centre'] = '';
        }

        return $cols;
    }
}
