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

    function footer_menu($settings) {
        $o = '';

        if (!empty($settings->footermenu)) {
            $lang = current_language();
            $lines = explode("\n", $settings->footermenu);
            $divider = html_writer::tag('span', html_writer::start_tag('i', array('class' => 'fa fa-arrows-h fa-lg')) .
                            html_writer::end_tag('i'), array('class' => 'divider'));

            $items = array();
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
            $o .= implode("$divider", $items);
        }
        return $o;
    }
}

// Course formats....
include_once($CFG->dirroot . "/course/format/topics/renderer.php");
class theme_shoehorn_format_topics_renderer extends format_topics_renderer {
    protected function get_nav_links($course, $sections, $sectionno) {
        return array();
    }

    /**
     * Output the html for a single section page .
     *
     * @param stdClass $course The course entry from DB
     * @param array $sections (argument not used)
     * @param array $mods (argument not used)
     * @param array $modnames (argument not used)
     * @param array $modnamesused (argument not used)
     * @param int $displaysection The section number in the course which is being displayed
     */
    public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection) {
        global $PAGE;

        if ($PAGE->user_is_editing()) {
            echo html_writer::start_tag('div', array('class' => 'panel panel-default'));
            echo html_writer::tag('h3', get_string('editonmainpage', 'theme_shoehorn'));
            echo html_writer::end_tag('div');
            return;
        }

        $modinfo = get_fast_modinfo($course);
        $course = course_get_format($course)->get_course();

        // Can we view the section in question?
        if (!($sectioninfo = $modinfo->get_section_info($displaysection))) {
            // This section doesn't exist
            print_error('unknowncoursesection', 'error', null, $course->fullname);
            return;
        }

        if (!$sectioninfo->uservisible) {
            if (!$course->hiddensections) {
                echo $this->start_section_list();
                echo $this->section_hidden($displaysection);
                echo $this->end_section_list();
            }
            // Can't view this section.
            return;
        }

        // Copy activity clipboard..
        echo $this->course_activity_clipboard($course, $displaysection);
        /* $thissection = $modinfo->get_section_info(0);
        if ($thissection->summary or !empty($modinfo->sections[0]) or $PAGE->user_is_editing()) {
            echo $this->start_section_list();
            echo $this->section_header($thissection, $course, true, $displaysection);
            echo $this->courserenderer->course_section_cm_list($course, $thissection, $displaysection);
            echo $this->courserenderer->course_section_add_cm_control($course, 0, $displaysection);
            echo $this->section_footer();
            echo $this->end_section_list();
        }*/

        // Start single-section div
        //echo html_writer::start_tag('div', array('class' => 'single-section'));
        echo html_writer::start_tag('div', array('class' => ''));

        // The requested section page.
        //$thissection = $modinfo->get_section_info($displaysection);

        // Title with section navigation links.
        /*$sectiontitle = '';
        $sectiontitle .= html_writer::start_tag('div', array('class' => 'section-navigation navigationtitle'));
        // Title attributes
        $classes = 'sectionname';
        if (!$thissection->visible) {
            $classes .= ' dimmed_text';
        }
        $sectiontitle .= $this->output->heading(get_section_name($course, $displaysection), 3, $classes);

        $sectiontitle .= html_writer::end_tag('div');
        echo $sectiontitle; */

        // Now the list of sections..
        echo $this->start_section_list();

        //echo $this->section_header($thissection, $course, true, $displaysection);
        // Show completion help icon.
        //$completioninfo = new completion_info($course);
        //echo $completioninfo->display_help_icon();

        //echo $this->courserenderer->course_section_cm_list($course, $thissection, $displaysection);
        //echo $this->courserenderer->course_section_add_cm_control($course, $displaysection, $displaysection);
        //echo $this->section_footer();

        $sections = $modinfo->get_section_info_all();

        // Check we will have a section to show...
        $shownsectioncount = 0;
        foreach ($sections as $section => $thissection) {
            $showsection = $thissection->uservisible ||
                    ($thissection->visible && !$thissection->available && $thissection->showavailability
                    && !empty($thissection->availableinfo));
            if ($showsection) {
                $shownsectioncount++;
            }
        }

		if ($shownsectioncount) {
        foreach ($sections as $section => $thissection) {
            if ($section == 0) {
                // 0-section is displayed a little different than the others
                if ($thissection->summary or !empty($modinfo->sections[0]) or $PAGE->user_is_editing()) {
                    echo $this->section_header($thissection, $course, false, 0);
                    echo $this->courserenderer->course_section_cm_list($course, $thissection, 0);
                    echo $this->courserenderer->course_section_add_cm_control($course, 0, 0);
                    echo $this->section_footer();
                }
                continue;
            }
            if ($section > $course->numsections) {
                // Activities inside this section are 'orphaned', this section will be printed on the main course page when editing is on.
                break;  // Not sure why core does not use this instead of 'continue'?
            }
            // Show the section if the user is permitted to access it, OR if it's not available
            // but showavailability is turned on (and there is some available info text).
            $showsection = $thissection->uservisible ||
                    ($thissection->visible && !$thissection->available && $thissection->showavailability
                    && !empty($thissection->availableinfo));
            if (!$showsection) {
                // Hidden section message is overridden by 'unavailable' control
                // (showavailability option).
                /* if (!$course->hiddensections && $thissection->available) {
                    echo $this->section_hidden($section);
                } */
                continue;
            }

            echo $this->section_header($thissection, $course, false, 0);
            if ($thissection->uservisible) {
                echo $this->courserenderer->course_section_cm_list($course, $thissection, 0);
                echo $this->courserenderer->course_section_add_cm_control($course, $section, 0);
            }
            echo $this->section_footer();
        }

        echo $this->end_section_list();
        } else {
            echo html_writer::start_tag('div', array('class' => 'panel panel-default'));
            echo html_writer::tag('h3', get_string('nosectionstoshow', 'theme_shoehorn'));
            echo html_writer::end_tag('div');
        }
        // Close single-section div.
        echo html_writer::end_tag('div');
    }
}

/*
$numberofslides = (empty($PAGE->theme->settings->numberofslides)) ? false : $PAGE->theme->settings->numberofslides;

if ($numberofslides) { ?>
    <div>
        <div class="carouselslider">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $first = true;
                    for ($i = 1; $i <= $numberofslides; $i++) { ?>
                        <li data-target="#myCarousel" data-slide-to="<?php echo $i-1; ?>" <?php if ($first) { echo 'class="active"'; $first = false; } ?>></li>
                    <?php } ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                    $first = true;
                    for ($i = 1; $i <= $numberofslides; $i++) {
                        $urlsetting = 'slideurl'.$i;
                        if (!empty($PAGE->theme->settings->$urlsetting)) {
                            echo '<a href="'.$PAGE->theme->settings->$urlsetting.'" target="_blank"';
                        } else {
                            echo '<div';
                        }
                        echo ' class="';
                        if ($first) { 
                            echo 'active '; 
                            $first = false;
                        }
                        echo 'item">';
                        $imagesetting = 'slideimage'.$i;
                        if (!empty($PAGE->theme->settings->$imagesetting)) {
                            $image = $PAGE->theme->setting_file_url($imagesetting, $imagesetting);
                        } else {
                            $image = $OUTPUT->pix_url('Default_Slide', 'theme');
                        }
                        $slidecaptiontitle = 'slidecaptiontitle'.$i;
                        if (!empty($PAGE->theme->settings->$slidecaptiontitle)) {
                            $imgalt = $PAGE->theme->settings->$slidecaptiontitle;
                        } else {
                            $imgalt = 'No caption title';
                        }
                        ?>
                            <img src="<?php echo $image; ?>" alt="<?php echo $imgalt; ?>" />
                            <?php
                            $slidecaptiontext = 'slidecaptiontext'.$i;
                            if ((!empty($PAGE->theme->settings->$slidecaptiontitle)) || (!empty($PAGE->theme->settings->$slidecaptiontext))) { ?>
                                <div class="carousel-caption">
                                <?php
                                    if (!empty($PAGE->theme->settings->$slidecaptiontitle)) { echo '<h4>'.$PAGE->theme->settings->$slidecaptiontitle.'</h4>'; }
                                    if (!empty($PAGE->theme->settings->$slidecaptiontext)) { echo '<p>'.$PAGE->theme->settings->$slidecaptiontext.'</p>'; }
                                ?> </div> <?php
                            }
                        if (!empty($PAGE->theme->settings->$urlsetting)) {
                            echo '</a>';
                        } else {
                            echo '</div>';
                        }
                    } ?>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="fa fa-chevron-circle-left"></i></a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="fa fa-chevron-circle-right"></i></a>
            </div>
        </div>
    </div>
<?php } ?>

*/