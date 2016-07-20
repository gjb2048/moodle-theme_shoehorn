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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$numberofmarketingspots = \theme_shoehorn\toolbox::get_setting('numberofmarketingspots');

if ($numberofmarketingspots) {
    $marketingspots = array();
    $lang = current_language();
    $loggedin = isloggedin();
    $o = '';
    for ($ms = 1; $ms <= $numberofmarketingspots; $ms++) {
        $marketingspotstatus = \theme_shoehorn\toolbox::get_setting('marketingspotstatus'.$ms);
        if (empty($marketingspotstatus) or
            ($marketingspotstatus == 2)) { // 2 is published.
            $marketingspotdisplay = \theme_shoehorn\toolbox::get_setting('marketingspotdisplay'.$ms);
            if (empty($marketingspotdisplay)
                or ($marketingspotdisplay == 1) // Always
                or (($marketingspotdisplay == 2) and ($loggedin == false)) // Logged out.
                or (($marketingspotdisplay == 3) and ($loggedin == true)) // Logged in.
            ) {
                $marketingspotlang = \theme_shoehorn\toolbox::get_setting('marketingspotlang'.$ms);
                if (empty($marketingspotlang) or
                    ($marketingspotlang == 'all') or
                    ($marketingspotlang == $lang)) {
                    // Show the marketing spot.
                    $themarketingspot = html_writer::tag('h2', \theme_shoehorn\toolbox::get_setting('marketingspotheading'.$ms));
                    $themarketingspot .= html_writer::tag('div', \theme_shoehorn\toolbox::get_setting('marketingspotcontent'.$ms));
                    $marketingspots[] = $themarketingspot;
                }
            }
        }
    }
    $mscount = count($marketingspots);
    if ($mscount >= 1) {
        $col = 12 / $mscount;
        if ($col < 3) {
            $col = 3;
        }
        $o = html_writer::start_tag('div', array('class' => 'row'));
        foreach ($marketingspots as $marketingspot) {
            $o .= html_writer::start_tag('div', array('class' => 'col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col));
            $o .= html_writer::start_tag('div', array('class' => 'marketingspot'));
            $o .= $marketingspot;
            $o .= html_writer::end_tag('div');
            $o .= html_writer::end_tag('div');
        }
        $o .= html_writer::end_tag('div');
        echo $o;
    }
}
