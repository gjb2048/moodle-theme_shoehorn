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
 * @subpackage shoebrush
 * @copyright  &copy; 2015-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Toolbox unit tests for the Shoebrush theme.
 * @group theme_shoebrush
 */
class theme_shoebrush_toolbox_testcase extends advanced_testcase {

    protected $outputus;

    protected function setUp() {
        set_config('theme', 'shoebrush');
        $this->resetAfterTest(true);

        global $PAGE;
        $this->outputus = $PAGE->get_renderer('theme_shoebrush', 'core');
        \theme_shoehorn\toolbox::set_core_renderer($this->outputus);
    }

    public function test_get_tilefile_header() {
        $thefile = \theme_shoehorn\toolbox::get_tile_file('header');
        global $CFG;
        $withoutdirroot = str_replace($CFG->dirroot, '', $thefile);

        $this->assertEquals('/theme/shoebrush/layout/tiles/header.php', $withoutdirroot);
    }

    public function test_get_tilefile_pageheader() {
        $thefile = \theme_shoehorn\toolbox::get_tile_file('pageheader');
        global $CFG;
        $withoutdirroot = str_replace($CFG->dirroot, '', $thefile);

        $this->assertEquals('/theme/shoehorn/layout/tiles/pageheader.php', $withoutdirroot);
    }

    public function test_themeinfo() {
        global $PAGE, $CFG, $OUTPUT;
        $themedir = str_replace($CFG->dirroot, '', $PAGE->theme->dir);

        $this->assertEquals('shoebrush', $PAGE->theme->name);
        $this->assertEquals('/theme/shoebrush', $themedir);
        $this->assertEquals('shoehorn', $PAGE->theme->parents[0]);
    }
}