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
class theme_shoehorn_core_renderer extends theme_bootstrap_core_renderer {

    /**
     * Gets HTML for the page heading.
     *
     * @param string $tag The tag to encase the heading in. h1 by default.
     * @return string HTML.
     */
    public function page_heading($tag = 'h1') {
        $o = '';

        $logo = $this->page->theme->setting_file_url('logo', 'logo');
        if (!is_null($logo)) {
            $o .= html_writer::empty_tag('img', array('src' => $logo, 'alt' => get_string('logo', 'theme_shoehorn'), 'class' => 'logo'));
            $o .= html_writer::tag($tag, $this->page->heading, array('class' => 'logoheading'));
        } else {
            $o .= parent::page_heading($tag);
        }
        return $o;
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (right_to_left()) {
            $dividericon = 'fa-angle-left';
        } else {
            $dividericon = 'fa-angle-right';
        }
        $divider = html_writer::tag('span', html_writer::start_tag('i', array('class' => 'fa '. $dividericon .' fa-lg')) .
                        html_writer::end_tag('i'), array('class' => 'divider'));
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $list_items = html_writer::start_tag('li') . implode("$divider" . html_writer::end_tag('li') .
                        html_writer::start_tag('li'), $breadcrumbs) . html_writer::end_tag('li');
        $title = html_writer::tag('span', get_string('pagepath'), array('class' => 'accesshide'));
        return $title . html_writer::tag('ul', "$list_items", array('class' => 'breadcrumb'));
    }

    function footer_menu() {
        $o = '';
        $items = array();

        // Footer menu setting.
        if (!empty($this->page->theme->settings->footermenu)) {
            $lang = current_language();
            $lines = explode("\n", $this->page->theme->settings->footermenu);

            foreach ($lines as $line) {
                $line = trim($line);
                $bits = explode('|', $line, 4); // name|url|title|lang
                if ((!empty($bits[3]) or (array_key_exists(3, $bits)))) {
                    if ($bits[3] !== $lang) {
                        continue;
                    }
                }
                $title = '';
                if ((!empty($bits[2]) or (array_key_exists(2, $bits)))) {
                    $title = $bits[2];
                }
                $items[] = html_writer::tag('a', $bits[0], array('href' => $bits[1], 'title' => $title));
            }
        }

        // Site page setting.
        $numberofsitepages = (empty($this->page->theme->settings->numberofsitepages)) ? false : $this->page->theme->settings->numberofsitepages;
        $loggedin = isloggedin();
        if ($numberofsitepages) {
            $lang = current_language();
            $sesskey = sesskey();
            for ($sp = 1; $sp <= $numberofsitepages; $sp++) {
                $sitepagetitle = 'sitepagetitle'.$sp;
                if (!empty($this->page->theme->settings->$sitepagetitle)) {
                    $sitepagelang = 'sitepagelang'.$sp;
                    if (empty($this->page->theme->settings->$sitepagelang) or ($this->page->theme->settings->$sitepagelang == $lang)) {
                        $url = new moodle_url('/theme/shoehorn/pages/sitepage.php');
                        $url->param('pageid', $sp);
                        if ($loggedin) {
                            $url->param('sesskey', $sesskey);
                        }
                        $url = preg_replace('|^https?://|i', '//', $url->out(false));
                        $items[] .= html_writer::tag('a', $this->page->theme->settings->$sitepagetitle, array('href' => $url, 'class' => 'sitepagelink'));
                    }
                }
            }
        }

        // Copyright setting.
        if (!empty($this->page->theme->settings->copyright)) {
            $items[] .= html_writer::tag('span', ' '.$this->page->theme->settings->copyright.' '.userdate(time(), '%Y'), array('class' => 'copyright'));
        }

        if (count($items) > 0) {
            $o = html_writer::start_tag('div', array('id' => 'footermenu'));
            if (count($items) == 1) {
                $o .= $items[0];
            } else {
                /* $divider = html_writer::tag('span', html_writer::start_tag('i', array('class' => 'fa fa-arrows-h fa-lg')) .
                                html_writer::end_tag('i'), array('class' => 'divider')); */
                $divider = html_writer::tag('span', '|', array('class' => 'divider'));
                $o .= implode("$divider", $items);
            }
            $o .= html_writer::end_tag('div');
        }

        return $o;
    }

    // Page bottom block region.
    /**
     * Get the HTML for blocks for region page-bottom.
     *
     * @return string HTML.
     */
    public function shoehorn_pagebottom_block() {
        $region = 'page-bottom';
        $classes = array();
        $classes[] = 'block-region';
        $classes[] = 'col-md-12';
        $editing = $this->page->user_is_editing();

        $attributes = array(
            'id' => 'block-region-' . preg_replace('#[^a-zA-Z0-9_\-]+#', '-', $region),
            'class' => join(' ', $classes),
            'data-blockregion' => $region,
            'data-droptarget' => '1'
        );

        $output = html_writer::start_tag('aside', $attributes);
        $output .= html_writer::start_tag('div', array('class' => 'row'));

        $region = $this->page->apply_theme_region_manipulations($region);
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);

        $blockcount = count($blockcontents);

        if ($blockcount >= 1) {
            $blocks = $this->page->blocks->get_blocks_for_region($region);
            $lastblock = null;
            $zones = array();
            foreach ($blocks as $block) {
                $zones[] = $block->title;
            }

            $blocksperrow = $this->page->theme->settings->numpagebottomblocks;
            // When editing we want all the blocks to be the same.
            if (($blocksperrow > 4) || ($editing)) {
                $blocksperrow = 4; // Will result in a 'col-sm-3 col-md-3 col-lg-3'.
            }
            $rows = $blockcount / $blocksperrow; // Maximum blocks per row.

            if (!$editing) {
                if ($rows <= 1) {
                    $col = 12 / $blockcount;
                    if ($col < 1) {
                        // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                        $col = 1;
                    }
                } else {
                    $col = 12 / $blocksperrow;
                }
            } else {
                $col = 3;
            }

            $currentblockcount = 0;
            $currentrow = 0;
            $currentrequiredrow = 1;
            foreach ($blockcontents as $bc) {
                if (!$editing) { // When not editing use rows to break up the blocks.
                    $currentblockcount++;
                    if ($currentblockcount > ($currentrequiredrow * $blocksperrow)) {
                        // Tripping point.
                        $currentrequiredrow++;
                        // Break...
                        $output .= html_writer::end_tag('div');
                        $output .= html_writer::start_tag('div', array('class' => 'row'));
                        // Recalculate col if needed...
                        $remainingblocks = $blockcount - ($currentblockcount - 1);
                        if ($remainingblocks < $blocksperrow) {
                            $col = 12 / $remainingblocks;
                            if ($col < 1) {
                                // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                                $col = 1;
                            }
                        }
                    }

                    if ($currentrow < $currentrequiredrow) {
                        $currentrow = $currentrequiredrow;
                    }
                }
                //$bc->attributes['class'] .= ' col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col;

                $output .= html_writer::start_tag('div', array('class' => 'col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col));
                if ($bc instanceof block_contents) {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                } else if ($bc instanceof block_move_target) {
                    $output .= $this->block_move_target($bc, $zones, $lastblock);
                } else {
                    throw new coding_exception('Unexpected type of thing (' . get_class($bc) . ') found in list of block contents.');
                }
                $output .= html_writer::end_tag('div');
            }
        }

        $output .= html_writer::end_tag('div'); // row.
        $output .= html_writer::end_tag('aside');
        return $output;
    }
}

// Course formats....

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
function shoehorn_section_header(&$that, $section, $course, $format, $displaysection) {
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
    $o.= html_writer::start_tag('li', array('id' => 'section-'.$section->section,
        'class' => 'section main clearfix'.$sectionstyle.' item', 'role'=>'region',
        'aria-label'=> $format->get_section_name($section)));

    $leftcontent = $that->section_left_content($section, $course, true);
    $o.= html_writer::tag('div', $leftcontent, array('class' => 'left side'));

    $rightcontent = $that->section_right_content($section, $course, true);
    $o.= html_writer::tag('div', $rightcontent, array('class' => 'right side'));
    $o.= html_writer::start_tag('div', array('class' => 'content'));

    $o.= html_writer::tag('h3', $format->get_section_name($section), array('class' => 'sectionname'));

    $o.= html_writer::start_tag('div', array('class' => 'summary'));
    $o.= $that->format_summary_text($section);

    $context = context_course::instance($course->id);
    $o.= html_writer::end_tag('div');

    $o .= $that->section_availability_message($section,
            has_capability('moodle/course:viewhiddensections', $context));

    return $o;
}

/**
 * Generate the display of the footer part of a section
 *
 * @return string HTML to output.
 */
function shoehorn_section_footer() {
    $o = html_writer::end_tag('div');
    $o.= html_writer::end_tag('li');

    return $o;
}

/**
 * Output the html for a single section page.
 *
 * @param stdClass $that theme_shoehorn_format_XXXXX_renderer instance.
 * @param stdClass $course The course entry from DB
 * @param array $sections (argument not used)
 * @param array $mods (argument not used)
 * @param array $modnames (argument not used)
 * @param array $modnamesused (argument not used)
 * @param int $displaysection The section number in the course which is being displayed
 */
function shoehorn_print_single_section_page(&$that, $course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
    global $PAGE;

    if ($PAGE->user_is_editing()) {
        echo html_writer::start_tag('div', array('class' => 'panel panel-default'));
        echo html_writer::tag('h3', get_string('editonmainpage', 'theme_shoehorn'));
        echo html_writer::end_tag('div');
        return;
    }

    $modinfo = get_fast_modinfo($course);
    $format = course_get_format($course);
    $course = $format->get_course();

    // Can we view the section in question?
    if (!($sectioninfo = $modinfo->get_section_info($displaysection))) {
        // This section doesn't exist
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

    // Start single-section div
    echo html_writer::start_tag('div', array('class' => ''));

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
                ($thissection->visible && !$thissection->available && $thissection->showavailability
                && !empty($thissection->availableinfo));
        if ($showsection) {
            $shownsections[] = $thissection->section;
        }
    }
    if (count($shownsections) > 0) {
        $loopsection = 0;
        $numsections = count($shownsections);
        $sections = $modinfo->get_section_info_all();

        echo html_writer::start_tag('div', array('class' => 'carouselslider'));
        echo html_writer::start_tag('div', array('id' => 'myCourseCarousel', 'class' => 'carousel slide',
                                                 'data-ride' => 'carousel', 'data-interval' => ''));
        echo html_writer::start_tag('ol', array('class' => 'carousel-indicators'));
        for ($i = 0; $i < $numsections; $i++) {
            $attributes = array('data-target' => '#myCourseCarousel', 'data-slide-to' => $i);
            if ($i == $displaysection) {
                $attributes['class'] = 'active';
            }
            echo html_writer::start_tag('li', $attributes);
            echo html_writer::end_tag('li');
        }
        echo html_writer::end_tag('ol');

        echo html_writer::start_tag('ul', array('class' => 'topics carousel-inner'));
        while ($loopsection < $numsections) {
            $thissection = $sections[$shownsections[$loopsection]];
            $loopsection++;
            if ($thissection->section == 0) {
                // 0-section is displayed a little different than the others
                if ($thissection->summary or !empty($modinfo->sections[0])) {
                    echo shoehorn_section_header($that, $thissection, $course, $format, $displaysection);
                    echo $that->courserenderer->course_section_cm_list($course, $thissection, 0);
                    echo $that->courserenderer->course_section_add_cm_control($course, 0, 0);
                    echo shoehorn_section_footer();
                }
                continue;
            }

            echo shoehorn_section_header($that, $thissection, $course, $format, $displaysection);
            if ($thissection->uservisible) {
                echo $that->courserenderer->course_section_cm_list($course, $thissection, 0);
                echo $that->courserenderer->course_section_add_cm_control($course, $thissection->section, 0);
            }
            echo shoehorn_section_footer();
        }
        echo html_writer::end_tag('ul');

        echo html_writer::start_tag('a', array('class' => 'left carousel-control', 'href' => '#myCourseCarousel',
                                               'data-slide' => 'prev'));
        echo html_writer::start_tag('i', array('class' => 'fa fa-chevron-circle-left'));
        echo html_writer::end_tag('i');
        echo html_writer::end_tag('a');
        echo html_writer::start_tag('a', array('class' => 'right carousel-control', 'href' => '#myCourseCarousel',
                                               'data-slide' => 'next'));
        echo html_writer::start_tag('i', array('class' => 'fa fa-chevron-circle-right'));
        echo html_writer::end_tag('i');
        echo html_writer::end_tag('a');
        echo html_writer::end_tag('div');
        echo html_writer::end_tag('div');
    } else {
        echo html_writer::start_tag('div', array('class' => 'panel panel-default'));
        echo html_writer::tag('h3', get_string('nosectionstoshow', 'theme_shoehorn'));
        echo html_writer::end_tag('div');
    }
    // Close single-section div.
    echo html_writer::end_tag('div');
}

/* Now the really clever bit to expose parts of the renderer interface such that they can be accessed by a global function if
   they are passed a reference to the $this object. */
include_once($CFG->dirroot . "/course/format/topics/renderer.php");
class theme_shoehorn_format_topics_renderer extends format_topics_renderer {
    public $courserenderer;

    protected function get_nav_links($course, $sections, $sectionno) {
        return array();
    }

    public function section_left_content($section, $course, $onsectionpage) {
        return parent::section_left_content($section, $course, $onsectionpage);
    }

    public function section_right_content($section, $course, $onsectionpage) {
        return parent::section_right_content($section, $course, $onsectionpage);
    }

    public function section_availability_message($section, $canviewhidden) {
        return parent::section_availability_message($section, $canviewhidden);
    }

    public function course_activity_clipboard($course, $sectionno = null) {
        return parent::course_activity_clipboard($course, $sectionno);
    }

    public function format_summary_text($section) {
        return parent::format_summary_text($section);
    }

    public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
        shoehorn_print_single_section_page($this, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
    }
}

include_once($CFG->dirroot . "/course/format/weeks/renderer.php");
class theme_shoehorn_format_weeks_renderer extends format_topics_renderer {
    public $courserenderer;

    protected function get_nav_links($course, $sections, $sectionno) {
        return array();
    }

    public function section_left_content($section, $course, $onsectionpage) {
        return parent::section_left_content($section, $course, $onsectionpage);
    }

    public function section_right_content($section, $course, $onsectionpage) {
        return parent::section_right_content($section, $course, $onsectionpage);
    }

    public function section_availability_message($section, $canviewhidden) {
        return parent::section_availability_message($section, $canviewhidden);
    }

    public function course_activity_clipboard($course, $sectionno = null) {
        return parent::course_activity_clipboard($course, $sectionno);
    }

    public function format_summary_text($section) {
        return parent::format_summary_text($section);
    }

    public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
        shoehorn_print_single_section_page($this, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
    }
}

// Requires V2.6.1.3+ of the Collapsed Topics format.
if (file_exists("$CFG->dirroot/course/format/topcoll/renderer.php")) {
    include_once($CFG->dirroot . "/course/format/topcoll/renderer.php");

    class theme_shoehorn_format_topcoll_renderer extends format_topcoll_renderer {
        public $courserenderer;

        protected function get_nav_links($course, $sections, $sectionno) {
            return array();
        }

        public function section_left_content($section, $course, $onsectionpage) {
            return parent::section_left_content($section, $course, $onsectionpage);
        }

        public function section_right_content($section, $course, $onsectionpage) {
            return parent::section_right_content($section, $course, $onsectionpage);
        }

        public function section_availability_message($section, $canviewhidden) {
            return parent::section_availability_message($section, $canviewhidden);
        }

        public function course_activity_clipboard($course, $sectionno = null) {
            return parent::course_activity_clipboard($course, $sectionno);
        }

        public function format_summary_text($section) {
            return parent::format_summary_text($section);
        }

        public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
            shoehorn_print_single_section_page($this, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
        }
    }
}

if (file_exists("$CFG->dirroot/course/format/grid/renderer.php")) {
    include_once($CFG->dirroot . "/course/format/grid/renderer.php");

    class theme_shoehorn_format_grid_renderer extends format_grid_renderer {
        public $courserenderer;

        protected function get_nav_links($course, $sections, $sectionno) {
            return array();
        }

        public function section_left_content($section, $course, $onsectionpage) {
            return parent::section_left_content($section, $course, $onsectionpage);
        }

        public function section_right_content($section, $course, $onsectionpage) {
            return parent::section_right_content($section, $course, $onsectionpage);
        }

        public function section_availability_message($section, $canviewhidden) {
            return parent::section_availability_message($section, $canviewhidden);
        }

        public function course_activity_clipboard($course, $sectionno = null) {
            return parent::course_activity_clipboard($course, $sectionno);
        }

        public function format_summary_text($section) {
            return parent::format_summary_text($section);
        }

        public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
            shoehorn_print_single_section_page($this, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
        }
    }
}

if (file_exists("$CFG->dirroot/course/format/noticebd/renderer.php")) {
    include_once($CFG->dirroot . "/course/format/noticebd/renderer.php");

    class theme_shoehorn_format_noticebd_renderer extends format_noticebd_renderer {
        public $courserenderer;

        protected function get_nav_links($course, $sections, $sectionno) {
            return array();
        }

        public function section_left_content($section, $course, $onsectionpage) {
            return parent::section_left_content($section, $course, $onsectionpage);
        }

        public function section_right_content($section, $course, $onsectionpage) {
            return parent::section_right_content($section, $course, $onsectionpage);
        }

        public function section_availability_message($section, $canviewhidden) {
            return parent::section_availability_message($section, $canviewhidden);
        }

        public function course_activity_clipboard($course, $sectionno = null) {
            return parent::course_activity_clipboard($course, $sectionno);
        }

        public function format_summary_text($section) {
            return parent::format_summary_text($section);
        }

        public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
            shoehorn_print_single_section_page($this, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
        }
    }
}

// Requires V2.6.1.1+ of Columns format.
if (file_exists("$CFG->dirroot/course/format/columns/renderer.php")) {
    include_once($CFG->dirroot . "/course/format/columns/renderer.php");

    class theme_shoehorn_format_columns_renderer extends format_columns_renderer {
        public $courserenderer;

        protected function get_nav_links($course, $sections, $sectionno) {
            return array();
        }

        public function section_left_content($section, $course, $onsectionpage) {
            return parent::section_left_content($section, $course, $onsectionpage);
        }

        public function section_right_content($section, $course, $onsectionpage) {
            return parent::section_right_content($section, $course, $onsectionpage);
        }

        public function section_availability_message($section, $canviewhidden) {
            return parent::section_availability_message($section, $canviewhidden);
        }

        public function course_activity_clipboard($course, $sectionno = null) {
            return parent::course_activity_clipboard($course, $sectionno);
        }

        public function format_summary_text($section) {
            return parent::format_summary_text($section);
        }

        public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
            shoehorn_print_single_section_page($this, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
        }
    }
}
