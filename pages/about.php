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

$PAGE->set_context(context_system::instance());
$thispageurl = new moodle_url('/theme/shoehorn/pages/about.php');
$PAGE->set_url($thispageurl, $thispageurl->params());
$PAGE->set_docs_path('');
$PAGE->set_pagelayout('page');

$html = theme_shoehorn_html_for_settings($PAGE);
$PAGE->add_body_classes($html->additionalbodyclasses);

$PAGE->set_title('About Shoehorn');
$PAGE->set_heading('About Shoehorn');

// No edit.
$USER->editing = $edit = 0;

$PAGE->navbar->ignore_active();
$PAGE->navbar->add($PAGE->title, $thispageurl);

// Output.
echo $OUTPUT->header();
echo $OUTPUT->box_start();

echo html_writer::start_tag('div', array('class' => 'row'));
echo html_writer::empty_tag('img', array('src' => $OUTPUT->pix_url('Shoehorn_logo', 'theme'), 'class' => 'img-responsive col-sm-4 col-md-3 col-lg-2'));
echo html_writer::start_tag('div',  array('class' => 'col-sm-8 col-md-9 col-lg-10 lead'));
$readme = new moodle_url('/theme/shoehorn/Readme.md');
$readme = html_writer::link($readme, 'Shoehorn', array('target' => '_blank'));
echo html_writer::tag('p', '\''.$readme.'\' is a Bootstrap v3 based theme that has many innovative features:');
echo html_writer::start_tag('div', array('class' => 'row'));
echo html_writer::start_tag('div',  array('class' => 'col-sm-6 col-md-6 col-lg-6 lead'));
echo html_writer::start_tag('ul');
echo html_writer::tag('li', 'Accordion block regions.');
echo html_writer::tag('li', 'Bespoke copyright statement.');
echo html_writer::tag('li', 'Bespoke login page message.');
echo html_writer::tag('li', 'Docking.');
echo html_writer::tag('li', 'Compact navigation bar option.');
echo html_writer::tag('li', 'Course tiles option.');
echo html_writer::tag('li', 'Dynamic and customisable footer menu.');
echo html_writer::tag('li', 'Dynamic social icons sign with correct icon colours.');
echo html_writer::tag('li', 'Fixed navigation bar option.');
echo html_writer::tag('li', 'Footer blocks.');
echo html_writer::tag('li', 'Front page slider that can be disabled on mobiles / tablets reducing bandwidth.');
echo html_writer::tag('li', 'Image bank for storing images that you can use anywhere on the site.');
echo html_writer::tag('li', 'Individual control over: front page slides, marketing spots and site pages with:');
echo html_writer::start_tag('ul');
echo html_writer::tag('li', '\'Draft\' / \'Published\' state.');
echo html_writer::tag('li', '\'before login\', \'after login\' or \'always\' visibility.');
echo html_writer::tag('li', 'Set specific language only visibility.');
echo html_writer::end_tag('ul');
echo html_writer::end_tag('ul');
echo html_writer::end_tag('div');
echo html_writer::start_tag('div',  array('class' => 'col-sm-6 col-md-6 col-lg-6 lead'));
echo html_writer::start_tag('ul');
echo html_writer::tag('li', 'Intelligent home footer link that goes back to the most appropriate location.');
echo html_writer::tag('li', 'Login page changing background images option.');
echo html_writer::tag('li', 'Marketing spots.');
echo html_writer::tag('li', 'Messages menu.');
echo html_writer::tag('li', 'My courses menu option with allocated dynamic icons.');
echo html_writer::tag('li', 'Page bottom blocks.');
echo html_writer::tag('li', 'Site pages that you can customise with your own content.');
echo html_writer::tag('li', 'Slider navigation of course content with the \'One section per page\' course layout setting.');
echo html_writer::tag('li', 'Social icons with dynamic signpost if desired.');
echo html_writer::tag('li', 'Syntax highlighting on content if desired.');
echo html_writer::tag('li', 'Transparency control of front and other pages.');
echo html_writer::end_tag('ul');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo html_writer::tag('p', 'I hope that you enjoy this theme,');
echo html_writer::tag('p', 'Gareth J Barnard - '.
                        html_writer::tag('a', 'About.me', (array('href' => '//about.me/gjbarnard', 'target' => '_blank'))).
                        ' - '.
                        html_writer::tag('a', 'Moodle Profile', (array('href' => '//moodle.org/user/profile.php?id=442195', 'target' => '_blank'))).
                        ' - '.
                        html_writer::tag('a', 'Google+', (array('href' => '//uk.linkedin.com/in/gjbarnard', 'target' => '_blank'))).
                        ' - '.
                        html_writer::tag('a', 'LinkedIn', (array('href' => '//uk.linkedin.com/in/gjbarnard', 'target' => '_blank'))).
                        ' - '.
                        html_writer::tag('a', 'Twitter', (array('href' => '//twitter.com/gjbarnard', 'target' => '_blank'))).
                        ' - '.
                        html_writer::tag('a', 'Website', (array('href' => '//www.gjbarnard.co.uk/', 'target' => '_blank')))
                        );
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo html_writer::start_tag('div', array('class' => 'row'));
echo html_writer::start_tag('div',  array('class' => 'col-md-12'));
echo html_writer::tag('p', 'G J Barnard 2014 - '.get_string('gpllicense').' v3 '.html_writer::tag('a', 'www.gnu.org/copyleft/gpl.html', array('href' => 'http://www.gnu.org/copyleft/gpl.html', 'target' => '_blank')), array ('class' => 'copyright text-center col-md-12'));
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');

echo $OUTPUT->box_end();

echo $OUTPUT->footer();


