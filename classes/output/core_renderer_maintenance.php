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
namespace theme_shoehorn\output;

use html_writer;

defined('MOODLE_INTERNAL') || die();

class core_renderer_maintenance extends \core_renderer_maintenance {
    protected $themeconfig = null;

    public function __construct(\moodle_page $page, $target) {
        parent::__construct($page, $target);
        $this->themeconfig = array(\theme_config::load('shoehorn'));
    }

    /**
     * The standard tags (typically script tags that are not needed earlier) that
     * should be output after everything else. Designed to be called in theme layout.php files.
     *
     * @return string HTML fragment.
     */
    public function standard_end_of_body_html() {
        $output = html_writer::start_tag('div', array ('class' => 'themecredit')).
                   get_string('credit', 'theme_shoehorn').
                   html_writer::link('//about.me/gjbarnard', 'Gareth J Barnard', array('target' => '_blank')).
                   html_writer::end_tag('div');
        $output .= parent::standard_end_of_body_html();

        return $output;
    }
}
