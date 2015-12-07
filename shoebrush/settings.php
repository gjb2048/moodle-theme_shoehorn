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
 * Shoebrush theme.
 *
 * @package    theme
 * @subpackage shoebrush
 * @copyright  &copy; 2015-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

// Settings.
$settings = null;

$readme = new moodle_url('/theme/shoebrush/Readme.md');
$readme = html_writer::link($readme, 'Readme.md', array('target' => '_blank'));

$ADMIN->add('themes', new admin_category('theme_shoebrush', 'Shoebrush'));

$generalsettings = new admin_settingpage('theme_shoebrush_general', get_string('generalsettings', 'theme_shoehorn'));

// Use FontAwesome font.
$name = 'theme_shoebrush/fontawesome';
$title = get_string('fontawesome', 'theme_shoehorn');
$description = get_string('fontawesome_desc', 'theme_shoehorn');
$setting = new admin_setting_configcheckbox($name, $title, $description, 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$generalsettings->add($setting);

// Use Accordion side blocks - 1 = no, 2 = yes.
$name = 'theme_shoebrush/accordion';
$title = get_string('accordion', 'theme_shoehorn');
$description = get_string('accordion_desc', 'theme_shoehorn');
$default = 2;
$choices = array(
    1 => new lang_string('no'), // No.
    2 => new lang_string('yes') // Yes.
);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$generalsettings->add($setting);

// Compact Navbar.
$name = 'theme_shoebrush/compactnavbar';
$title = get_string('compactnavbar', 'theme_shoehorn');
$description = get_string('compactnavbar_desc', 'theme_shoehorn');
$setting = new admin_setting_configcheckbox($name, $title, $description, 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$generalsettings->add($setting);

// Navbar fixed at the top of the page.
$name = 'theme_shoebrush/navbarfixedtop';
$title = get_string('navbarfixedtop', 'theme_shoehorn');
$description = get_string('navbarfixedtop_desc', 'theme_shoehorn');
$setting = new admin_setting_configcheckbox($name, $title, $description, 1);
$setting->set_updatedcallback('theme_reset_all_caches');
$generalsettings->add($setting);

// Activate syntax highlighting - 1 = no, 2 = yes.
$name = 'theme_shoebrush/syntaxhighlight';
$title = get_string('syntaxhighlight', 'theme_shoehorn');
$description = get_string('syntaxhighlight_desc', 'theme_shoehorn');
$default = 1;
$choices = array(
    1 => new lang_string('no'), // No.
    2 => new lang_string('yes')   // Yes.
);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$generalsettings->add($setting);

$ADMIN->add('theme_shoebrush', $generalsettings);

// Number of front page slides.
$name = 'theme_shoebrush/frontpagenumberofslides';
$title = get_string('frontpagenumberofslides', 'theme_shoehorn');
$description = get_string('frontpagenumberofslides_desc', 'theme_shoehorn');
$default = 3;
$choices = array(
    0 => '0',
    1 => '1',
    2 => '2',
    3 => '3',
    4 => '4',
    5 => '5',
    6 => '6',
    7 => '7',
    8 => '8',
    9 => '9',
    10 => '10',
    11 => '11',
    12 => '12',
    13 => '13',
    14 => '14',
    15 => '15',
    16 => '16'
);
$slidersettings = new admin_settingpage('theme_shoebrush_slider', get_string('frontpagesliderheading', 'theme_shoehorn'));
$slidersettings->add(new admin_setting_heading('theme_shoebrush_slider',
        get_string('frontpagesliderheadingsub', 'theme_shoehorn'),
        format_text(get_string('frontpagesliderheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
$slidersettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

// Language variables for settings....
$langpackurl = new moodle_url('/admin/tool/langimport/index.php');
$langsinstalled = array_merge(array('all' => get_string('all')), get_string_manager()->get_list_of_translations());

$numberofslides = get_config('theme_shoebrush', 'frontpagenumberofslides');
for ($i = 1; $i <= $numberofslides; $i++) {
    $slidersettings->add(new admin_setting_heading('theme_shoebrush_frontpageslide_heading' . $i,
            get_string('frontpageslidersettingspageheading', 'theme_shoehorn', array('slide' => $i)), null));

    // Image.
    $name = 'theme_shoebrush/frontpageslideimage' . $i;
    $title = get_string('frontpageslideimage', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslideimage_desc', 'theme_shoehorn', array('slide' => $i));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageslideimage' . $i);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // URL.
    $name = 'theme_shoebrush/frontpageslideurl' . $i;
    $title = get_string('frontpageslideurl', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslideurl_desc', 'theme_shoehorn', array('slide' => $i));
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Caption title.
    $name = 'theme_shoebrush/frontpageslidecaptiontitle' . $i;
    $title = get_string('frontpageslidecaptiontitle', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslidecaptiontitle_desc', 'theme_shoehorn', array('slide' => $i));
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Caption text.
    $name = 'theme_shoebrush/frontpageslidecaptiontext' . $i;
    $title = get_string('frontpageslidecaptiontext', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslidecaptiontext_desc', 'theme_shoehorn', array('slide' => $i));
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Status.
    $name = 'theme_shoebrush/frontpageslidestatus' . $i;
    $title = get_string('frontpageslidestatus', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslidestatus_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('draft', 'theme_shoehorn'),
        2 => new lang_string('published', 'theme_shoehorn')
    );
    $slidersettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Display.
    $name = 'theme_shoebrush/frontpageslidedisplay' . $i;
    $title = get_string('frontpageslidedisplay', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslidedisplay_desc', 'theme_shoehorn', array('slide' => $i));
    $default = 1;
    $choices = array(
        1 => new lang_string('always', 'theme_shoehorn'),
        2 => new lang_string('loggedout', 'theme_shoehorn'),
        3 => new lang_string('loggedin', 'theme_shoehorn')
    );

    $slidersettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));
    // Slider language only.
    $name = 'theme_shoebrush/frontpageslidelang' . $i;
    $title = get_string('frontpageslidelang', 'theme_shoehorn', array('slide' => $i));
    $description = get_string('frontpageslidelang_desc', 'theme_shoehorn',
            array('slide' => $i, 'url' => html_writer::tag('a', get_string('langpack_urlname', 'theme_shoehorn'),
                array(
            'href' => $langpackurl, 'target' => '_blank'))));
    $default = 'all';
    $setting = new admin_setting_configselect($name, $title, $description, $default, $langsinstalled);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);
}
$ADMIN->add('theme_shoebrush', $slidersettings);
