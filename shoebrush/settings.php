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
        1 => new lang_string('no'),   // No.
        2 => new lang_string('yes')   // Yes.
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
        1 => new lang_string('no'),   // No.
        2 => new lang_string('yes')   // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    $ADMIN->add('theme_shoebrush', $generalsettings);
