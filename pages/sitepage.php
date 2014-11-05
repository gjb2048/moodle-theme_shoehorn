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
require_once('../lib.php');

$ourpageid = required_param('pageid', PARAM_INT);
// TODO Add sesskey check to edit - from my/index.php & check works.
$sesskey = optional_param('sesskey', null, PARAM_RAW);
if ($sesskey !== null && confirm_sesskey($sesskey)) {
    $sesskeyvalid = true;
} else {
    $sesskeyvalid = false;
}

$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off

$PAGE->set_context(context_system::instance());
$thispageurl = new moodle_url('/theme/shoehorn/pages/sitepage.php');
$thispageurl->param('sesskey', sesskey());
$thispageurl->param('pageid', $ourpageid);
$PAGE->set_url($thispageurl, $thispageurl->params());
$PAGE->set_other_editing_capability('moodle/course:update');
$PAGE->set_docs_path('');
$PAGE->set_pagelayout('page');

$html = theme_shoehorn_html_for_settings($PAGE);
$PAGE->add_body_classes($html->additionalbodyclasses);

$o = '';
$pages = shoehorn_shown_sitepages(); // lib.php.
$loggedin = isloggedin();

$theme = theme_config::load('shoehorn'); // Cannot use $PAGE->theme as will complain about the theme already set up and cannot change.
$settings = $theme->settings;
if (array_key_exists($ourpageid, $pages)) {
    if ($pages[$ourpageid] == 2) {
        $sitepagetitle = 'sitepagetitle'.$ourpageid;
        $PAGE->set_title($settings->$sitepagetitle);

        $sitepageheading = 'sitepageheading'.$ourpageid;
        $PAGE->set_heading($settings->$sitepageheading);

        // Content.
        $sitepagecontent = 'sitepagecontent'.$ourpageid;
        $o .= html_writer::tag('div', $settings->$sitepagecontent, array('class' => 'sitepagecontent'));
    } else if ($pages[$ourpageid] == 3) {
        $text = get_string('pagenotdisplayedtitle', 'theme_shoehorn', array('pageid' => $ourpageid));
        $PAGE->set_title($text);
        $PAGE->set_heading($text);
        $o .= html_writer::tag('h3', get_string('pagenotdisplayedcontentnotitle', 'theme_shoehorn', array('pageid' => $ourpageid)), array('class' => 'panel panel-warning'));
    } else if ($pages[$ourpageid] == 4) {
        $text = get_string('pagenotdisplayedtitle', 'theme_shoehorn', array('pageid' => $ourpageid));
        $PAGE->set_title($text);
        $PAGE->set_heading($text);
        $o .= html_writer::tag('h3', get_string('pagenotdisplayedcontentnotpublished', 'theme_shoehorn', array('pageid' => $ourpageid)), array('class' => 'panel panel-warning'));
    } else {
        $text = get_string('pagenotdisplayedtitle', 'theme_shoehorn', array('pageid' => $ourpageid));
        $PAGE->set_title($text);
        $PAGE->set_heading($text);
        $o .= html_writer::tag('h3', get_string('pagenotdisplayedcontent', 'theme_shoehorn', array('pageid' => $ourpageid)), array('class' => 'panel panel-warning'));
    }
} else {
    $text = get_string('unknownsitepage', 'theme_shoehorn').$ourpageid;
    $PAGE->set_title($text);
    $PAGE->set_heading($text);
    $o .= html_writer::tag('h3', get_string('unknownsitepagecontent', 'theme_shoehorn', array('pageid' => $ourpageid)), array('class' => 'panel panel-warning'));
}

$courseid = SITEID;
/// locate course information
//$course = $DB->get_record('course', array('id'=>$courseid), '*', MUST_EXIST);
//$PAGE->set_course($course);

// Navigation.  See: http://docs.moodle.org/dev/Navigation_API
if (!$loggedin) {
    // Not logged in, so create a container....
    $USER->editing = $edit = 0;
} else {
    // Logged in....
    // Toggle the editing state and switches
    if (($sesskeyvalid) && ($PAGE->user_allowed_editing())) {
        if ($edit !== null) {             // Editing state was specified
            $USER->editing = $edit;       // Change editing state
            $context = context_user::instance($USER->id);
            $PAGE->set_context($context);
        }

        if (!empty($USER->editing)) {
            $edit = 1;
        } else {
            $edit = 0;
        }

        // Add button for editing page
        if (empty($edit)) {
            $editstring = get_string('blocksediton');
        } else {
            $editstring = get_string('blockseditoff');
        }

        $usernavurl = new moodle_url('/theme/shoehorn/pages/sitepage.php');
        $usernavurl->param('pageid', $ourpageid);
        $usernavurl->param('edit', !$edit);
        $usernavurl->param('sesskey', sesskey());
        $button = $OUTPUT->single_button($usernavurl, $editstring);
        $PAGE->set_button($button);

        $settingnode = $PAGE->settingsnav->create($editstring, $usernavurl, navigation_node::TYPE_CUSTOM, null, null, new pix_icon('i/edit', $editstring, 'moodle', null));
        $PAGE->settingsnav->add_node($settingnode, $PAGE->settingsnav->get_children_key_list()[0]);  // Add the node before the current first.
        $settingnode->add_class('hasicon');
        $settingnode->remove_class('root_node');
        $settingnode->make_active();
    } else {                          // Editing state is in session
        $USER->editing = $edit = 0;          // Disable editing completely, just to be safe
    }
}

// Add us and the other pages....
$containernode = $PAGE->navigation->find($courseid, navigation_node::TYPE_COURSE);
if (empty($containernode)) {
    $containernode = $PAGE->navigation->create(get_string('sitepagesheading', 'theme_shoehorn'), null, navigation_node::TYPE_CONTAINER);
    $children = $PAGE->navigation->get_children_key_list();
    if (empty($children)) {
        $beforekey = null;
    } else {
        $beforekey = $children[0];
    }
    $PAGE->navigation->add_node($containernode, $beforekey);
}
$children = $containernode->get_children_key_list();
if (empty($children)) {
    $beforekey = null;
} else {
    $beforekey = $children[0];
}
$lang = current_language();
$oursesskey = sesskey();
foreach($pages as $pageid => $status) {
    if ($status == 2) {
        $sitepagetitle = 'sitepagetitle'.$pageid;
        $navurl = new moodle_url('/theme/shoehorn/pages/sitepage.php');
        $navurl->param('pageid', $pageid);
        if ($loggedin) {
            $navurl->param('sesskey', $oursesskey);
        }
        $ournode = $PAGE->navigation->create($settings->$sitepagetitle, $navurl, navigation_node::TYPE_CUSTOM, null, null, new pix_icon('i/report', get_string('sitepage', 'theme_shoehorn').$pageid, 'moodle', null));
        $containernode->add_node($ournode, $beforekey);
        if ($pageid == $ourpageid) {
            // Us....
            $ournode->make_active();
        }
    }
}

$PAGE->navbar->ignore_active();
$PAGE->navbar->add($PAGE->title, $thispageurl);

// Output.
echo $OUTPUT->header();
echo $OUTPUT->box_start();

echo $o;

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
