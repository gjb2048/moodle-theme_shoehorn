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
// Functions for all formats....

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

/* Now the really clever bit to expose parts of the renderer interface such that they can be accessed by a global function if
  they are passed a reference to the $this object. */

// Requires V2.6.1.3+ of the Collapsed Topics format.
if (file_exists("$CFG->dirroot/course/format/topcoll/renderer.php")) {
    include_once($CFG->dirroot . "/course/format/topcoll/renderer.php");

    class theme_shoehorn_format_topcoll_renderer extends format_topcoll_renderer {

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
            \theme_shoehorn\toolbox::course_format_print_single_section_page($this, $this->courserenderer, $course, $sections, $mods, $modnames,
                    $modnamesused, $displaysection);
        }

        protected function get_row_class() {
            return 'row';
        }

        protected function get_column_class($columns) {
            $colclasses = array(1 => 'col-sm-12 col-md-12 col-lg-12', 2 => 'col-sm-6 col-md-6 col-lg-6', 3 => 'col-md-4 col-lg-4', 4 => 'col-lg-3');

            return $colclasses[$columns];
        }

    }

}