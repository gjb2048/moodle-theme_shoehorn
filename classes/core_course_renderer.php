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
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class theme_shoehorn_core_course_renderer extends core_course_renderer {

    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $CFG;

        if (!isset($this->strings->summary)) {
            $this->strings->summary = get_string('summary');
        }
        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
            return '';
        }
        if ($course instanceof stdClass) {
            require_once($CFG->libdir. '/coursecatlib.php');
            $course = new course_in_list($course);
        }
        $content = '';
        $classes = trim($additionalclasses);

        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $classes .= ' collapsed';
        }

        $content .= html_writer::start_tag('div', array('class' => 'panel panel-default coursebox accordion-group'));

        $content .= html_writer::start_tag('div', array('class' => 'panel-heading'));

        // Course name.
        $coursename = $chelper->get_course_formatted_name($course);
        $content .= html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
            $coursename, array('class' => $course->visible ? '' : 'dimmed'));

        // If we display course in collapsed form but the course has summary or course contacts, display the link to the info page.
        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles()) {
                $arrow = html_writer::tag('span', '', array('class' => 'glyphicon glyphicon-info-sign'));
                $content .= html_writer::link('#coursecollapse' . $course->id , '&nbsp;' . $arrow,
                    array('data-toggle' => 'collapse', 'data-parent' => '#frontpage-category-combo'));
            }
        }

        // Print enrolmenticons.
        if ($icons = enrol_get_course_info_icons($course)) {
            $content .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
            foreach ($icons as $pixicon) {
                $content .= $this->render($pixicon);
            }
            $content .= html_writer::end_tag('div'); // End .enrolmenticons.
        }

        $content .= html_writer::end_tag('div'); // End .panel-heading.

        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $content .= html_writer::start_tag('div', array('id' => 'coursecollapse' . $course->id,
                'class' => 'panel-collapse collapse out'));
        }

        $content .= html_writer::start_tag('div', array('class' => 'panel-body content'));

        // This gets the course image or files.
        $content .= $this->coursecat_coursebox_content($chelper, $course);

        if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $icondirection = 'left';
            if ('ltr' === get_string('thisdirection', 'langconfig')) {
                $icondirection = 'right';
            }
            if (is_enrolled(context_course::instance($course->id))) {
                $arrow = html_writer::tag('span', '', array('class' => ' glyphicon glyphicon-arrow-'.$icondirection));
                $btn = html_writer::tag('span', get_string('course') . ' ' . $arrow, array('class' => 'coursequicklink'));
                $content .= html_writer::link(new moodle_url('/course/view.php',
                    array('id' => $course->id)), $btn, array('class' => 'coursebtn btn btn-info btn-sm pull-right'));
            }
        }

        $content .= html_writer::end_tag('div'); // End .panel-body.

        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $content .= html_writer::end_tag('div'); // End .collapse.
        }

        $content .= html_writer::end_tag('div'); // End .panel.

        return $content;
    }

    protected function coursecat_coursebox_content(coursecat_helper $chelper, $course) {
        global $CFG;
        if ($course instanceof stdClass) {
            require_once($CFG->libdir. '/coursecatlib.php');
            $course = new course_in_list($course);
        }
        $content = '';

        // Display course overview files.
        $contentimages = $contentfiles = '';
        foreach ($course->get_course_overviewfiles() as $file) {
            $isimage = $file->is_valid_image();
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                    $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            if ($isimage) {
                $contentimages .= html_writer::empty_tag('img', array('src' => $url, 'alt' => 'Course Image '. $course->fullname,
                    'class' => 'courseimage'));
            } else {
                $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
                $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                        html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
                $contentfiles .= html_writer::tag('span',
                        html_writer::link($url, $filename),
                        array('class' => 'coursefile fp-filename-icon'));
            }
        }
        $content .= $contentimages. $contentfiles;

        // Display course summary.
        if ($course->has_summary()) {
            $summaryclass = 'summary';
            if (!$course->has_course_contacts()) {
                $summaryclass .= ' noteachers';
            }
            $content .= html_writer::start_tag('div', array('class' => $summaryclass));
            $content .= $chelper->get_course_formatted_summary($course);
            $content .= html_writer::end_tag('div');
        }

        // Display course contacts. See course_in_list::get_course_contacts().
        if ($course->has_course_contacts()) {
            $content .= html_writer::start_tag('ul', array('class' => 'teachers'));
            foreach ($course->get_course_contacts() as $userid => $coursecontact) {
                $name = $coursecontact['rolename'].': '.
                        html_writer::link(new moodle_url('/user/view.php',
                                array('id' => $userid, 'course' => SITEID)),
                            $coursecontact['username']);
                $content .= html_writer::tag('li', $name);
            }
            $content .= html_writer::end_tag('ul'); // End .teachers.
        }

        // Display course category if necessary (for example in search results).
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT) {
            require_once($CFG->libdir. '/coursecatlib.php');
            if ($cat = coursecat::get($course->category, IGNORE_MISSING)) {
                $content .= html_writer::start_tag('div', array('class' => 'coursecat'));
                $content .= get_string('category').': '.
                        html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
                                $cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
                $content .= html_writer::end_tag('div'); // End .coursecat.
            }
        }

        $content .= html_writer::tag('div', '', array('class' => 'boxfooter')); // End .coursecat.

        return $content;
    }

    public function course_search_form($value = '', $format = 'plain') {
        static $count = 0;
        $formid = 'coursesearch';
        if ((++$count) > 1) {
            $formid .= $count;
        }
        $inputid = 'coursesearchbox';
        $inputsize = 30;

        if ($format === 'navbar') {
            $formid = 'coursesearchnavbar';
            $inputid = 'navsearchbox';
        }

        $strsearchcourses = get_string("searchcourses");
        $searchurl = new moodle_url('/course/search.php');

        $form = array('id' => $formid, 'action' => $searchurl, 'method' => 'get', 'class' => "form-inline", 'role' => 'form');
        $output = html_writer::start_tag('form', $form);
        $output .= html_writer::start_div('input-group');
        $output .= html_writer::tag('label', $strsearchcourses, array('for' => $inputid, 'class' => 'sr-only'));
        $search = array('type' => 'text', 'id' => $inputid, 'size' => $inputsize, 'name' => 'search',
                        'class' => 'form-control', 'value' => s($value), 'placeholder' => $strsearchcourses);
        $output .= html_writer::empty_tag('input', $search);
        $button = array('type' => 'submit', 'class' => 'btn btn-default');
        $output .= html_writer::start_span('input-group-btn');
        $output .= html_writer::tag('button', get_string('go'), $button);
        $output .= html_writer::end_span();
        $output .= html_writer::end_div(); // Close form-group.
        $output .= html_writer::end_tag('form');

        return $output;
    }

    /**
     * Serves requests to /theme/shoehorn/inspector.ajax.php
     *
     * @param string $term search term.
     * @return array of results.
     * @throws coding_exception
     */
    public function inspector_ajax($term) {
        global $CFG, $USER;

        $data = array();

        $courses = enrol_get_my_courses();
        $site = get_site();

        if (array_key_exists($site->id, $courses)) {
            unset($courses[$site->id]);
        }

        foreach ($courses as $c) {
            if (isset($USER->lastcourseaccess[$c->id])) {
                $courses[$c->id]->lastaccess = $USER->lastcourseaccess[$c->id];
            } else {
                $courses[$c->id]->lastaccess = 0;
            }
        }

        // Get remote courses.
        $remotecourses = array();
        if (is_enabled_auth('mnet')) {
            $remotecourses = get_my_remotecourses();
        }
        // Remote courses will have -ve remoteid as key, so it can be differentiated from normal courses.
        foreach ($remotecourses as $id => $val) {
            $remoteid = $val->remoteid * -1;
            $val->id = $remoteid;
            $courses[$remoteid] = $val;
        }

        foreach ($courses as $course) {
            $modinfo = get_fast_modinfo($course);
            $courseformat = course_get_format($course->id);
            $course = $courseformat->get_course();
            $courseformatsettings = $courseformat->get_format_options();
            $sesskey = sesskey();

            foreach ($modinfo->get_section_info_all() as $section => $thissection) {
                if (!$thissection->uservisible) {
                    continue;
                }
                if (is_object($thissection)) {
                    $thissection = $modinfo->get_section_info($thissection->section);
                } else {
                    $thissection = $modinfo->get_section_info($thissection);
                }
                if ((string) $thissection->name !== '') {
                    $sectionname = format_string($thissection->name, true,
                        array('context' => context_course::instance($course->id)));
                } else {
                    $sectionname = $courseformat->get_section_name($thissection->section);
                }
                if ($thissection->section <= $course->numsections) {
                    // Do not link 'orphaned' sections.
                    $courseurl = new moodle_url('/course/view.php');
                    $courseurl->param('id', $course->id);
                    $courseurl->param('sesskey', $sesskey);
                    if ((!empty($courseformatsettings['coursedisplay'])) &&
                        ($courseformatsettings['coursedisplay'] == COURSE_DISPLAY_MULTIPAGE)) {
                        $courseurl->param('section', $thissection->section);
                        $coursehref = $courseurl->out(false);
                    } else {
                        $coursehref = $courseurl->out(false).'#section-'.$thissection->section;
                    }
                    $label = $course->fullname.' - '.$sectionname;
                    if (stristr($label, $term)) {
                        $data[] = array('id' => $coursehref, 'label' => $label, 'value' => $label);
                    }
                }
                if (!empty($modinfo->sections[$thissection->section])) {
                    foreach ($modinfo->sections[$thissection->section] as $modnumber) {
                        $mod = $modinfo->cms[$modnumber];
                        if (!empty($mod->url)) {
                            $instancename = $mod->get_formatted_name();
                            $label = $course->fullname.' - '.$sectionname.' - '.$instancename;
                            if (stristr($label, $term)) {
                                $data[] = array('id' => $mod->url->out(false), 'label' => $label, 'value' => $label);
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }
}
