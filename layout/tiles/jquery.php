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

$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('bootstrap', 'theme_shoehorn');
$fitvids = (!isset($PAGE->theme->settings->fitvids)) ? true : $PAGE->theme->settings->fitvids;
if ($fitvids) {
    $PAGE->requires->jquery_plugin('fitvids', 'theme_shoehorn');
}
switch ($PAGE->pagelayout) {
    case 'login': 
        $loginpageimages = shoehorn_shown_loginbackgroundchanger_images();
        if (!empty($loginpageimages)) {
            $PAGE->requires->jquery_plugin('backstretch', 'theme_shoehorn');
        }
}
$PAGE->requires->jquery_plugin('antigravity', 'theme_shoehorn');
