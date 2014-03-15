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

// http://docs.moodle.org/dev/Page_API.
require_once('../../../config.php');
$PAGE->set_context(context_system::instance());
$url = new moodle_url('/theme/shoehorn/pages/sitepage.php');
$url->param('pageid', 1);
$PAGE->set_url($url, $url->params());
$PAGE->set_title('Site page title');
$PAGE->set_heading('Site page heading');
$PAGE->set_pagelayout('page');

$courseid = SITEID;
/// locate course information
$course = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);
$PAGE->set_course($course);

// Navigation.  See: http://docs.moodle.org/dev/Navigation_API.
$ournode = $PAGE->navigation->find($courseid, navigation_node::TYPE_COURSE);
if (empty($ournode)) {
    // Not logged in....
    $ournode = $PAGE->navigation->add($PAGE->title, $url);
} else {
    // Logged in, so add to site pages....
    $ournode = $ournode->add($PAGE->title, $url);
}
$ournode->make_active();

$PAGE->navbar->ignore_active();
$PAGE->navbar->add($PAGE->title, $url);

// Output.
echo $OUTPUT->header();
echo $OUTPUT->box_start();

echo '<h1>Test</h1>';

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
