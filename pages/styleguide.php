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
 * @copyright  &copy; 2016-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Ref: http://docs.moodle.org/dev/Page_API.
require_once('../../../config.php');
require_once('../lib.php');

$PAGE->set_context(context_system::instance());
$thispageurl = new moodle_url('/theme/shoehorn/pages/styleguide.php');
$PAGE->set_url($thispageurl, $thispageurl->params());
$PAGE->set_docs_path('');
$PAGE->set_pagelayout('standard');

require_once($CFG->dirroot . '/lib/adminlib.php');
require_once($CFG->dirroot . '/theme/shoehorn/shoehorn_admin_setting_styleguide.php');
$setting = new shoehorn_admin_setting_styleguide('theme_shoehorn_styleguide',
    get_string('styleguidesub', 'theme_shoehorn'),
    get_string('styleguidedesc', 'theme_shoehorn',
        array(
            'holderlicenseurl' => html_writer::link('https://github.com/imsky/holder#license', 'MIT',
                array('target' => '_blank')),
            'contentlicenseurl' => html_writer::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0',
                array('target' => '_blank')),
            'thiscodelicenseurl' => html_writer::link('http://www.gnu.org/copyleft/gpl.html', 'GPLv3',
                array('target' => '_blank')),
            'compatible' => html_writer::link('http://www.gnu.org/licenses/license-list.en.html#apache2', 'compatible',
                array('target' => '_blank')),
            'overview' => html_writer::link('http://getbootstrap.com/css/#overview', 'Overview',
                array('target' => '_blank')),
            'origcodelicenseurl' => html_writer::link('https://github.com/twbs/bootstrap/blob/master/LICENSE', 'MIT',
                array('target' => '_blank'))
        )
    )
);
$guidehtml = $setting->output_html(null);

$PAGE->set_title('Shoehorn Style Guide');
$PAGE->set_heading('Shoehorn Style Guide');

// No edit.
$USER->editing = $edit = 0;

$PAGE->navbar->ignore_active();
$PAGE->navbar->add($PAGE->title, $thispageurl);

// Output.
echo $OUTPUT->header();
echo $OUTPUT->box_start();

echo $guidehtml;

echo $OUTPUT->box_end();

echo $OUTPUT->footer();
