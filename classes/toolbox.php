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

    static protected $themes = array();

    static public function get_theme_config($themename) {
        if (empty(self::$themes[$themename])) {
            self::$themes[$themename] = \theme_config::load($themename);
        }
        return self::$themes[$themename];
    }

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
            return dirname(__FILE__) . "/$filename";
        }
    }

    /**
     * Finds the given setting in the theme from the themes' configuration object.
     * @param string $setting Setting name.
     * @param string $format false|'format_text'|'format_html'.
     * @param theme_config $theme null|theme_config object.
     * @return any false|value of setting.
     */
    static public function get_setting($setting, $format = false, $theme = null) {

        if (empty($theme)) {
            $theme = self::get_theme_config('shoehorn');
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
     * Finds the given setting in the theme using the get_config core function for when the theme_config object has not been created.
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
    static public function html_for_settings($theme = null) {

        if (empty($theme)) {
            $theme = self::get_theme_config('shoehorn');
        }

        global $PAGE;

        $settings = $theme->settings;

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

        if ((!empty($settings->coursetiles)) and ( $settings->coursetiles == 2)) {
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

        if ((!empty($settings->landfallhorizontalquiz)) && ($PAGE->pagelayout == 'incourse')) {
            $html->additionalbodyclasses[] = 'horizontalquiz';
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
    static public function shown_sitepages() {
        $pages = array();
        $settings = self::get_theme_config('shoehorn')->settings;

        $numberofsitepages = (empty($settings->numberofsitepages)) ? false : $settings->numberofsitepages;
        if ($numberofsitepages) {
            $loggedin = isloggedin();
            $lang = current_language();
            for ($sp = 1; $sp <= $numberofsitepages; $sp++) {
                $sitepagestatus = 'sitepagestatus' . $sp;
                if (empty($settings->$sitepagestatus) or ( $settings->$sitepagestatus == 2)) { // 2 is published.
                    $sitepagetitle = 'sitepagetitle' . $sp;
                    if (!empty($settings->$sitepagetitle)) {
                        $sitepagedisplay = 'sitepagedisplay' . $sp;
                        if (empty($settings->$sitepagedisplay)
                                or ( $settings->$sitepagedisplay == 1) // Always.
                                or ( ($settings->$sitepagedisplay == 2) and ( $loggedin == false)) // Logged out.
                                or ( ($settings->$sitepagedisplay == 3) and ( $loggedin == true)) // Logged in.
                        ) {
                            $sitepagelang = 'sitepagelang' . $sp;
                            if (empty($settings->$sitepagelang) or ( $settings->$sitepagelang == 'all') or ( $settings->$sitepagelang
                                    == $lang)) {
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
        $settings = self::get_theme_config('shoehorn')->settings;

        $frontpagenumberofslides = (empty($settings->frontpagenumberofslides)) ? false : $settings->frontpagenumberofslides;
        if ($frontpagenumberofslides) {
            $loggedin = isloggedin();
            $lang = current_language();
            for ($sl = 1; $sl <= $frontpagenumberofslides; $sl++) {
                $frontpageslidestatus = 'frontpageslidestatus' . $sl;
                if (empty($settings->$frontpageslidestatus) or ( $settings->$frontpageslidestatus == 2)) { // 2 is published.
                    $frontpageslidedisplay = 'frontpageslidedisplay' . $sl;
                    if (empty($settings->$frontpageslidedisplay)
                            or ( $settings->$frontpageslidedisplay == 1) // Always.
                            or ( ($settings->$frontpageslidedisplay == 2) and ( $loggedin == false)) // Logged out.
                            or ( ($settings->$frontpageslidedisplay == 3) and ( $loggedin == true)) // Logged in.
                    ) {
                        $frontpageslidelang = 'frontpageslidelang' . $sl;
                        if (empty($settings->$frontpageslidelang) or ( $settings->$frontpageslidelang == 'all') or ( $settings->$frontpageslidelang
                                == $lang)) {
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
        global $CFG;
        $images = array();
        $theme = self::get_theme_config('shoehorn');
        $settings = $theme->settings;

        $numberofimages = (empty($settings->loginbackgroundchangernumberofimages)) ? false : $settings->loginbackgroundchangernumberofimages;
        if (($numberofimages) && (self::showloginbackgroundchanger($settings))) {
            for ($img = 1; $img <= $numberofimages; $img++) {
                $loginbackgroundchangerimageno = 'loginbackgroundchangerimage' . $img;
                if (!empty($settings->$loginbackgroundchangerimageno)) {
                    $images[] = $theme->setting_file_url($loginbackgroundchangerimageno, $loginbackgroundchangerimageno);
                }
            }
        }

        return $images;
    }

    static private function showloginbackgroundchanger($settings) {
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

    static public function social_footer() {
        $settings = self::get_theme_config('shoehorn')->settings;
        $numberofsociallinks = (empty($settings->numberofsociallinks)) ? false : $settings->numberofsociallinks;
        $haveicons = false;
        if ($numberofsociallinks) {
            for ($sli = 1; $sli <= $numberofsociallinks; $sli++) {
                $name = 'social' . $sli;
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
            $cols['side'] = 'col-sm-' . $side . ' col-md-' . $side . ' col-lg-' . $side;
            $cols['centre'] = 'col-sm-' . $centre . ' col-md-' . $centre . ' col-lg-' . $centre . ' post-size-' . $diff;
        } else {
            $cols['side'] = 'col-sm-6 col-md-6 col-lg-6';
            $cols['centre'] = '';
        }

        return $cols;
    }

    /**
     * Generate the display of the header part of a section before
     * course modules are included
     *
     * @param stdClass $that theme_shoehorn_format_XXXXX_renderer instance.
     * @param stdClass $section The course_section entry from DB
     * @param stdClass $course The course entry from DB
     * @param stdClass $format format_XXXXX instance.
     * @param int $displaysection The section number in the course which is being displayed
     * @return string HTML to output.
     */
    static public function course_format_section_header(&$that, $section, $course, $format, $displaysection) {
        global $PAGE;
        $o = '';
        $sectionstyle = '';

        if ($section->section != 0) {
            // Only in the non-general sections.
            if (!$section->visible) {
                $sectionstyle = ' hidden';
            } else if ($format->is_section_current($section)) {
                $sectionstyle = ' current';
            }
        }
        if ($section->section == $displaysection) {
            $sectionstyle .= ' active';
        }
        $o .= \html_writer::start_tag('li',
                        array('id' => 'section-' . $section->section,
                    'class' => 'section main clearfix' . $sectionstyle . ' item', 'role' => 'region',
                    'aria-label' => $format->get_section_name($section)));

        $leftcontent = $that->section_left_content($section, $course, true);
        $o .= \html_writer::tag('div', $leftcontent, array('class' => 'left side'));

        $rightcontent = $that->section_right_content($section, $course, true);
        $o .= \html_writer::tag('div', $rightcontent, array('class' => 'right side'));
        $o .= \html_writer::start_tag('div', array('class' => 'content'));

        $o .= \html_writer::tag('h3', $format->get_section_name($section), array('class' => 'sectionname'));

        $o .= \html_writer::start_tag('div', array('class' => 'summary'));
        $o .= $that->format_summary_text($section);

        $context = \context_course::instance($course->id);
        $o .= \html_writer::end_tag('div');

        $o .= $that->section_availability_message($section, has_capability('moodle/course:viewhiddensections', $context));

        return $o;
    }

    /**
     * Generate the display of the footer part of a section
     *
     * @return string HTML to output.
     */
    static public function course_format_section_footer() {
        $o = \html_writer::end_tag('div');
        $o .= \html_writer::end_tag('li');

        return $o;
    }

    /**
     * Output the html for a single section page.
     *
     * @param stdClass $that theme_shoehorn_format_XXXXX_renderer instance.
     * @param stdClass $courserenderer course renderer instance.
     * @param stdClass $course The course entry from DB
     * @param array $sections (argument not used)
     * @param array $mods (argument not used)
     * @param array $modnames (argument not used)
     * @param array $modnamesused (argument not used)
     * @param int $displaysection The section number in the course which is being displayed
     */
    static public function course_format_print_single_section_page(&$that, &$courserenderer, $course, $sections, $mods,
            $modnames, $modnamesused, $displaysection, $nbformat = false) {
        global $PAGE;

        if ($PAGE->user_is_editing()) {
            echo \html_writer::start_tag('div', array('class' => 'panel panel-default'));
            echo \html_writer::tag('h3', get_string('editonmainpage', 'theme_shoehorn'));
            echo \html_writer::end_tag('div');
            return;
        }

        $modinfo = get_fast_modinfo($course);
        $format = course_get_format($course);
        $course = $format->get_course();

        // Can we view the section in question?
        if (!($sectioninfo = $modinfo->get_section_info($displaysection))) {
            // This section doesn't exist.
            print_error('unknowncoursesection', 'error', null, $course->fullname);
            return;
        }

        if (!$sectioninfo->uservisible) {
            if (!$course->hiddensections) {
                echo $that->start_section_list();
                echo $that->section_hidden($displaysection);
                echo $that->end_section_list();
            }
            // Can't view this section.
            return;
        }

        // Copy activity clipboard..
        echo $that->course_activity_clipboard($course, $displaysection);

        // Start single-section div.
        echo \html_writer::start_tag('div', array('class' => 'shoehorn-single-course-page'));

        $sections = $modinfo->get_section_info_all();

        // Check we will have a section to show...
        $shownsections = array();
        foreach ($sections as $section => $thissection) {
            if ($thissection->section > $course->numsections) {
                /* Activities inside this section are 'orphaned', this section will be printed on the main course page when
                  editing is on. */
                break;  // Not sure why core does not use this instead of 'continue'?
            }
            $showsection = $thissection->uservisible ||
                    ($thissection->visible && !$thissection->available && $thissection->showavailability && !empty($thissection->availableinfo));
            if ($showsection) {
                $shownsections[] = $thissection->section;
            }
        }
        if (count($shownsections) > 0) {
            $loopsection = 0;
            $numsections = count($shownsections);
            $sections = $modinfo->get_section_info_all();

            echo \html_writer::start_tag('div', array('class' => 'carouselslider'));
            echo \html_writer::start_tag('div',
                    array('id' => 'myCourseCarousel', 'class' => 'carousel slide',
                'data-ride' => 'carousel', 'data-interval' => ''));
            echo \html_writer::start_tag('ol', array('class' => 'carousel-indicators'));
            for ($i = 0; $i < $numsections; $i++) {
                $attributes = array('data-target' => '#myCourseCarousel', 'data-slide-to' => $i);
                if ($i == $displaysection) {
                    $attributes['class'] = 'active';
                }
                echo \html_writer::start_tag('li', $attributes);
                echo \html_writer::end_tag('li');
            }
            echo \html_writer::end_tag('ol');

            echo \html_writer::start_tag('ul', array('class' => 'topics carousel-inner'));
            while ($loopsection < $numsections) {
                $thissection = $sections[$shownsections[$loopsection]];
                $loopsection++;
                if ($thissection->section == 0) {
                    // 0-section is displayed a little different than the others.
                    if (!$nbformat) {
                        if ($thissection->summary or ! empty($modinfo->sections[0])) {
                            echo self::course_format_section_header($that, $thissection, $course, $format, $displaysection);
                            echo $courserenderer->course_section_cm_list($course, $thissection, 0);
                            echo $courserenderer->course_section_add_cm_control($course, 0, 0);
                            echo self::course_format_section_footer();
                        }
                    } else {
                        echo self::course_format_section_header($that, $thissection, $course, $format, $displaysection);
                        if ($thissection->summary or ! empty($modinfo->sections[0])) {
                            echo $courserenderer->course_section_cm_list($course, $thissection, 0);
                            echo $courserenderer->course_section_add_cm_control($course, 0, 0);
                        }
                        // See if we are using a version of the format's renderer where the method 'print_noticeboard' is public.
                        if (in_array('print_noticeboard', get_class_methods($that))) {
                            $that->print_noticeboard($course);
                        }
                        echo self::course_format_section_footer();
                    }
                    continue;
                }

                echo self::course_format_section_header($that, $thissection, $course, $format, $displaysection);
                if ($thissection->uservisible) {
                    echo $courserenderer->course_section_cm_list($course, $thissection, 0);
                    echo $courserenderer->course_section_add_cm_control($course, $thissection->section, 0);
                }
                echo self::course_format_section_footer();
            }
            echo \html_writer::end_tag('ul');

            echo \html_writer::start_tag('a',
                    array('class' => 'left carousel-control', 'href' => '#myCourseCarousel',
                'data-slide' => 'prev'));
            if ($PAGE->theme->settings->fontawesome) {
                echo \html_writer::tag('i', '', array('class' => 'fa fa-chevron-circle-left'));
            } else {
                echo \html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-chevron-left'));
            }
            echo \html_writer::end_tag('a');
            echo \html_writer::start_tag('a',
                    array('class' => 'right carousel-control', 'href' => '#myCourseCarousel',
                'data-slide' => 'next'));
            if ($PAGE->theme->settings->fontawesome) {
                echo \html_writer::tag('i', '', array('class' => 'fa fa-chevron-circle-right'));
            } else {
                echo \html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-chevron-right'));
            }
            echo \html_writer::end_tag('a');
            echo \html_writer::end_tag('div');
            echo \html_writer::end_tag('div');
        } else {
            echo \html_writer::start_tag('div', array('class' => 'panel panel-default'));
            echo \html_writer::tag('h3', get_string('nosectionstoshow', 'theme_shoehorn'));
            echo \html_writer::end_tag('div');
        }
        // Close single-section div.
        echo \html_writer::end_tag('div');
    }

}
