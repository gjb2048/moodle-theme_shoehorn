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
}
