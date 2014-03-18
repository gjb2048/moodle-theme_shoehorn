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

$pageid = required_param('pageid', PARAM_INT);

$PAGE->set_context(context_system::instance());
$url = new moodle_url('/theme/shoehorn/pages/sitepage.php');
$url->param('pageid', $pageid);
$PAGE->set_url($url, $url->params());

$o = '';
$sitepagetitle = 'sitepagetitle'.$pageid;
$theme = theme_config::load('shoehorn'); // Cannot use $PAGE->theme as will complain about the theme already set up and cannot change.
$settings = $theme->settings;
if (!empty($settings->$sitepagetitle)) {
    $lang = current_language();
    $sitepagelang = 'sitepagelang'.$pageid;
    if (empty($settings->$sitepagelang) or ($settings->$sitepagelang == $lang)) {
        $PAGE->set_title($settings->$sitepagetitle);

        $sitepageheading = 'sitepageheading'.$pageid;
        $PAGE->set_heading($settings->$sitepageheading);

        $PAGE->set_pagelayout('page');

        // Content.
        $sitepagecontent = 'sitepagecontent'.$pageid;
        $o .= html_writer::tag('div', $settings->$sitepagecontent, array('class' => 'sitepagecontent'));
    } else {
        $text = get_string('pagenotforlanguagetitle1', 'theme_shoehorn').$pageid.get_string('pagenotforlanguagetitle2', 'theme_shoehorn');
        $PAGE->set_title($text);
        $PAGE->set_heading($text);
        $PAGE->set_pagelayout('page');
        $o .= html_writer::tag('h3', get_string('pagenotforlanguagecontent1', 'theme_shoehorn').$pageid.get_string('pagenotforlanguagecontent2', 'theme_shoehorn'), array('class' => 'panel panel-warning'));
    }
} else {
    $text = get_string('unknownsitepage', 'theme_shoehorn').$pageid;
    $PAGE->set_title($text);
    $PAGE->set_heading($text);
    $PAGE->set_pagelayout('page');
    $o .= html_writer::tag('h3', get_string('unknownsitepagecontent1', 'theme_shoehorn').$pageid.get_string('unknownsitepagecontent2', 'theme_shoehorn'), array('class' => 'panel panel-warning'));
}

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

echo $o;

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
