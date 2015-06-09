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

require_once(dirname(__FILE__).'/../../lib.php');

$fitvids = (!isset($PAGE->theme->settings->fitvids)) ? true : $PAGE->theme->settings->fitvids;
if ($fitvids) {
    $PAGE->requires->js_call_amd('theme_shoehorn/fitvids', 'init');
}
switch ($PAGE->pagelayout) {
    case 'login':
        $loginpageimages = shoehorn_shown_loginbackgroundchanger_images();
        if (!empty($loginpageimages)) {
            $PAGE->requires->js_call_amd('theme_shoehorn/backstretch', 'init');
        }
        break;
    case 'admin':
        $userload = (!isset($PAGE->theme->settings->userload)) ? true : $PAGE->theme->settings->userload;
        if ($userload) {
            $userloadpostfix = get_string('userloadpostfix', 'theme_shoehorn');
            if (!empty($PAGE->layout_options['chart'])) {
                $bc = new block_contents();
                $bc->title = get_string('userload', 'theme_shoehorn');
                $bc->attributes['class'] = 'block block_shoehorn_chart';
                $bc->attributes['chart'] = true;
                $bc->content = '<div class="ct-chart ct-perfect-fourth"></div>';

                $defaultregion = $PAGE->blocks->get_default_region();
                $PAGE->blocks->add_fake_block($bc, $defaultregion);
            }

            $now = time();
            $then = 100 * floor(($now - (2 * 60 * 60)) / 100);  // Round to the nearest 100 seconds for better query cache.
            $params = array('then' => $then);
            $sql = 'SELECT u.currentlogin, u.lastaccess FROM {user} u WHERE u.lastaccess >= :then';

            global $DB;
            if (!$users = $DB->get_records_sql($sql, $params)) {
                $users = array();
            }

            $tally = array();
            for ($interval = (2 * 60); $interval >= 15; $interval -= 15) {
                $intervaltime = $now - (60 * $interval);
                $tally[strval($interval).$userloadpostfix] = 0;
                foreach ($users as $user) {
                    if (($user->currentlogin <= $intervaltime) && ($user->lastaccess >= $intervaltime)) {
                        $tally[strval($interval).$userloadpostfix]++;
                    }
                }
            }
            $tally['0'.$userloadpostfix] = 0;
            $then = 100 * floor(($now - (15 * 60)) / 100);;
            foreach ($users as $user) {
                if (($user->lastaccess <= $now) && ($user->lastaccess >= $then)) {
                    $tally['0'.$userloadpostfix]++;
                }
            }

            $data = array('data' => array('labels' => array_keys($tally), 'series' => array(array_values($tally))));

            $PAGE->requires->js_call_amd('theme_shoehorn/shoehorn_chart', 'init', $data);
        }
        break;
}
