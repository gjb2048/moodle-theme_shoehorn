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

    static public function set_core_renderer($core) {
        $us = self::get_instance();
        // Set from the initial calling lib.php process_css function.  Must happen before parents.
        $us->corerenderer = $core;
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
            // Use $OUTPUT.
            global $OUTPUT;
            $us->corerenderer = $OUTPUT;
        }
        return $us->corerenderer;
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

        $numberofsitepages = (empty(self::get_setting('numberofsitepages'))) ? false : self::get_setting('numberofsitepages');
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

        $frontpagenumberofslides = (empty(self::get_setting('frontpagenumberofslides'))) ? false : self::get_setting('frontpagenumberofslides');
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
        global $CFG;
        $images = array();

        $numberofimages = (empty(self::get_setting('loginbackgroundchangernumberofimages'))) ? false : self::get_setting('loginbackgroundchangernumberofimages');
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
            $showimages = (empty(self::get_setting('loginbackgroundchangermobile'))) ? false : self::get_setting('loginbackgroundchangermobile');
        } else if ($devicetype == "tablet") {
            $showimages = (empty(self::get_setting('loginbackgroundchangertablet'))) ? false : self::get_setting('loginbackgroundchangertablet');
        } else {
            $showimages = true;
        }
        return $showimages;
    }

    static public function social_footer() {
        $numberofsociallinks = (empty(self::get_setting('numberofsociallinks'))) ? false : self::get_setting('numberofsociallinks');
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
            $fontawesome = self::get_setting('fontawesome');
            if ($fontawesome) {
                echo \html_writer::tag('i', '', array('class' => 'fa fa-chevron-circle-left'));
            } else {
                echo \html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-chevron-left'));
            }
            echo \html_writer::end_tag('a');
            echo \html_writer::start_tag('a',
                    array('class' => 'right carousel-control', 'href' => '#myCourseCarousel',
                'data-slide' => 'next'));
            if ($fontawesome) {
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
