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
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

// Settings.
$settings = null;
$ADMIN->add('themes', new admin_category('theme_shoehorn', 'Shoehorn'));

$generalsettings = new admin_settingpage('theme_shoehorn_general', get_string('generalsettings', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // CDN Fonts - 1 = no, 2 = yes.
    $name = 'theme_shoehorn/cdnfonts';
    $title = get_string('cdnfonts', 'theme_shoehorn');
    $description = get_string('cdnfonts_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Use FontAwesome font.
    $name = 'theme_shoehorn/fontawesome';
    $title = get_string('fontawesome', 'theme_shoehorn');
    $description = get_string('fontawesome_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Use Docking - 1 = no, 2 = yes.
    $name = 'theme_shoehorn/docking';
    $title = get_string('docking', 'theme_shoehorn');
    $description = get_string('docking_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Use Accordion side blocks - 1 = no, 2 = yes.
    $name = 'theme_shoehorn/accordion';
    $title = get_string('accordion', 'theme_shoehorn');
    $description = get_string('accordion_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Course content search.
    $name = 'theme_shoehorn/coursecontentsearch';
    $title = get_string('coursecontentsearch', 'theme_shoehorn');
    $description = get_string('coursecontentsearchdesc', 'theme_shoehorn');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);


    // Compact Navbar.
    $name = 'theme_shoehorn/compactnavbar';
    $title = get_string('compactnavbar', 'theme_shoehorn');
    $description = get_string('compactnavbar_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Navbar fixed at the top of the page.
    $name = 'theme_shoehorn/navbarfixedtop';
    $title = get_string('navbarfixedtop', 'theme_shoehorn');
    $description = get_string('navbarfixedtop_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Invert Navbar to dark background.
    $name = 'theme_shoehorn/inversenavbar';
    $title = get_string('inversenavbar', 'theme_shoehorn');
    $description = get_string('inversenavbar_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Show old messages.
    $name = 'theme_shoehorn/showoldmessages';
    $title = get_string('showoldmessages', 'theme_shoehorn');
    $description = get_string('showoldmessagesdesc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    // Display My Courses Menu.
    $name = 'theme_shoehorn/displaymycoursesmenu';
    $title = get_string('displaymycoursesmenu', 'theme_shoehorn');
    $description = get_string('displaymycoursesmenu_desc', 'theme_shoehorn');
    $choices = array(
        0 => new lang_string('no'),
        1 => new lang_string('myclasses', 'theme_shoehorn'),
        2 => new lang_string('mycourses', 'theme_shoehorn'),
        3 => new lang_string('mymodules', 'theme_shoehorn'),
        4 => new lang_string('mysubjects', 'theme_shoehorn'),
        5 => new lang_string('myunits', 'theme_shoehorn')
    );
    $default = 2;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    // Display my courses on the my home page - 1 = no, 2 = yes.
    $name = 'theme_shoehorn/displaymycourses';
    $title = get_string('displaymycourses', 'theme_shoehorn');
    $description = get_string('displaymycourses_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    // Use course tiles for activities and resources - 1 = no, 2 = yes.
    $name = 'theme_shoehorn/coursetiles';
    $title = get_string('coursetiles', 'theme_shoehorn');
    $description = get_string('coursetiles_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    // Activate syntax highlighting - 1 = no, 2 = yes.
    $name = 'theme_shoehorn/syntaxhighlight';
    $title = get_string('syntaxhighlight', 'theme_shoehorn');
    $description = get_string('syntaxhighlight_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    // Logo file setting.
    $name = 'theme_shoehorn/logo';
    $title = get_string('logo', 'theme_shoehorn');
    $description = get_string('logo_desc', 'theme_shoehorn');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Number of page bottom blocks.
    $name = 'theme_shoehorn/numpagebottomblocks';
    $title = get_string('numpagebottomblocks', 'theme_shoehorn');
    $description = get_string('numpagebottomblocks_desc', 'theme_shoehorn');
    $choices = array(
        1 => new lang_string('one', 'theme_shoehorn'),
        2 => new lang_string('two', 'theme_shoehorn'),
        3 => new lang_string('three', 'theme_shoehorn'),
        4 => new lang_string('four', 'theme_shoehorn')
    );
    $default = 2;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $generalsettings->add($setting);

    // Footer menu.
    $name = 'theme_shoehorn/footermenu';
    $title = get_string('footermenu', 'theme_shoehorn');
    $description = get_string('footermenu_desc', 'theme_shoehorn');
    $default = 'About Shoehorn|[[site]]/theme/shoehorn/pages/about.php|About Shoehorn';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Fitvids.
    $name = 'theme_shoehorn/fitvids';
    $title = get_string('fitvids', 'theme_shoehorn');
    $description = get_string('fitvidsdesc', 'theme_shoehorn');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Copyright text.
    $name = 'theme_shoehorn/copyright';
    $title = get_string('copyright', 'theme_shoehorn');
    $description = get_string('copyright_desc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // User load chart.
    $name = 'theme_shoehorn/userload';
    $title = get_string('userload', 'theme_shoehorn');
    $description = get_string('userloaddesc', 'theme_shoehorn');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Custom CSS.
    $name = 'theme_shoehorn/customcss';
    $title = get_string('customcss', 'theme_shoehorn');
    $description = get_string('customcss_desc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Login message.
    $generalsettings->add(new admin_setting_heading('theme_shoehorn_loginmessage',
        get_string('loginpage', 'theme_shoehorn'),
        format_text(get_string('loginpage_desc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    $name = 'theme_shoehorn/showloginmessage';
    $title = get_string('showloginmessage', 'theme_shoehorn');
    $description = get_string('showloginmessage_desc', 'theme_shoehorn') . html_writer::tag('a',
        get_string('showloginmessage_urlname', 'theme_shoehorn'),
        array('href' => get_string('showloginmessage_urllink', 'theme_shoehorn'), 'target' => '_blank'))."'.";
    $default = 1;
    $choices = array(
        1 => new lang_string('no'), // No.
        2 => new lang_string('yes') // Yes.
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    $name = 'theme_shoehorn/loginmessage';
    $title = get_string('loginmessage', 'theme_shoehorn');
    $description = get_string('loginmessage_desc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    $readme = new moodle_url('/theme/shoehorn/Readme.md');
    $readme = html_writer::link($readme, 'Readme.md', array('target' => '_blank'));
    $generalsettings->add(new admin_setting_heading('theme_shoehorn_generalreadme', get_string('readme_title', 'theme_shoehorn'),
        get_string('readme_desc', 'theme_shoehorn', array('url' => $readme))));
}
$ADMIN->add('theme_shoehorn', $generalsettings);

// Font....
$fontsettings = new admin_settingpage('theme_shoehorn_font', get_string('fontsettings', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // This is the descriptor for the font settings.
    $name = 'theme_shoehorn/fontheading';
    $heading = get_string('fontheadingsub', 'theme_shoehorn');
    $information = get_string('fontheadingdesc', 'theme_shoehorn');
    $setting = new admin_setting_heading($name, $heading, $information);
    $fontsettings->add($setting);

    // Heading font name.
    $name = 'theme_shoehorn/fontnameheading';
    $title = get_string('fontnameheading', 'theme_shoehorn');
    $description = get_string('fontnameheadingdesc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // Text font name.
    $name = 'theme_shoehorn/fontnamebody';
    $title = get_string('fontnamebody', 'theme_shoehorn');
    $description = get_string('fontnamebodydesc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // Heading.
    // TTF Font.
    $name = 'theme_shoehorn/fontfilettfheading';
    $title = get_string('fontfilettfheading', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // OTF Font.
    $name = 'theme_shoehorn/fontfileotfheading';
    $title = get_string('fontfileotfheading', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // WOFF Font.
    $name = 'theme_shoehorn/fontfilewoffheading';
    $title = get_string('fontfilewoffheading', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // WOFF2 Font.
    $name = 'theme_shoehorn/fontfilewofftwoheading';
    $title = get_string('fontfilewofftwoheading', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwoheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // EOT Font.
    $name = 'theme_shoehorn/fontfileeotheading';
    $title = get_string('fontfileeotheading', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileweotheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // SVG Font.
    $name = 'theme_shoehorn/fontfilesvgheading';
    $title = get_string('fontfilesvgheading', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgheading');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // Body.
    // TTF Font.
    $name = 'theme_shoehorn/fontfilettfbody';
    $title = get_string('fontfilettfbody', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // OTF Font.
    $name = 'theme_shoehorn/fontfileotfbody';
    $title = get_string('fontfileotfbody', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // WOFF Font.
    $name = 'theme_shoehorn/fontfilewoffbody';
    $title = get_string('fontfilewoffbody', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // WOFF2 Font.
    $name = 'theme_shoehorn/fontfilewofftwobody';
    $title = get_string('fontfilewofftwobody', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwobody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // EOT Font.
    $name = 'theme_shoehorn/fontfileeotbody';
    $title = get_string('fontfileeotbody', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileweotbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);

    // SVG Font.
    $name = 'theme_shoehorn/fontfilesvgbody';
    $title = get_string('fontfilesvgbody', 'theme_shoehorn');
    $description = '';
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgbody');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $fontsettings->add($setting);
}
$ADMIN->add('theme_shoehorn', $fontsettings);

// Front page slider page....
$slidersettings = new admin_settingpage('theme_shoehorn_slider',
    get_string('frontpagesliderheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Number of front page slides.
    $name = 'theme_shoehorn/frontpagenumberofslides';
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
    $slidersettings->add(new admin_setting_heading('theme_shoehorn_slider',
        get_string('frontpagesliderheadingsub', 'theme_shoehorn'),
        format_text(get_string('frontpagesliderheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $slidersettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Slide speed.
    $name = 'theme_shoehorn/frontpagesliderspeed';
    $title = get_string('frontpagesliderspeed', 'theme_shoehorn');
    $description = get_string('frontpagesliderspeed_desc', 'theme_shoehorn');
    $default = 5000;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Show on mobile.
    $name = 'theme_shoehorn/frontpageslidermobile';
    $title = get_string('frontpageslidermobile', 'theme_shoehorn');
    $description = get_string('frontpageslidermobile_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Show on tablet.
    $name = 'theme_shoehorn/frontpageslidertablet';
    $title = get_string('frontpageslidertablet', 'theme_shoehorn');
    $description = get_string('frontpageslidertablet_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Language variables for settings....
    $langpackurl = new moodle_url('/admin/tool/langimport/index.php');
    $langsinstalled = array_merge(array('all' => get_string('all')), get_string_manager()->get_list_of_translations());

    $numberofslides = get_config('theme_shoehorn', 'frontpagenumberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {
        $slidersettings->add(new admin_setting_heading('theme_shoehorn_frontpageslide_heading' . $i,
            get_string('frontpageslidersettingspageheading', 'theme_shoehorn', array('slide' => $i)), null));

        // Image.
        $name = 'theme_shoehorn/frontpageslideimage' . $i;
        $title = get_string('frontpageslideimage', 'theme_shoehorn', array('slide' => $i));
        $description = get_string('frontpageslideimage_desc', 'theme_shoehorn', array('slide' => $i));
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpageslideimage' . $i);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // URL.
        $name = 'theme_shoehorn/frontpageslideurl' . $i;
        $title = get_string('frontpageslideurl', 'theme_shoehorn', array('slide' => $i));
        $description = get_string('frontpageslideurl_desc', 'theme_shoehorn', array('slide' => $i));
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // Caption title.
        $name = 'theme_shoehorn/frontpageslidecaptiontitle' . $i;
        $title = get_string('frontpageslidecaptiontitle', 'theme_shoehorn', array('slide' => $i));
        $description = get_string('frontpageslidecaptiontitle_desc', 'theme_shoehorn', array('slide' => $i));
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // Caption text.
        $name = 'theme_shoehorn/frontpageslidecaptiontext' . $i;
        $title = get_string('frontpageslidecaptiontext', 'theme_shoehorn', array('slide' => $i));
        $description = get_string('frontpageslidecaptiontext_desc', 'theme_shoehorn', array('slide' => $i));
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // Status.
        $name = 'theme_shoehorn/frontpageslidestatus' . $i;
        $title = get_string('frontpageslidestatus', 'theme_shoehorn', array('slide' => $i));
        $description = get_string('frontpageslidestatus_desc', 'theme_shoehorn');
        $default = 1;
        $choices = array(
            1 => new lang_string('draft', 'theme_shoehorn'),
            2 => new lang_string('published', 'theme_shoehorn')
        );
        $slidersettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

        // Display.
        $name = 'theme_shoehorn/frontpageslidedisplay' . $i;
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
        $name = 'theme_shoehorn/frontpageslidelang' . $i;
        $title = get_string('frontpageslidelang', 'theme_shoehorn', array('slide' => $i));
        $description = get_string('frontpageslidelang_desc', 'theme_shoehorn',
        array('slide' => $i, 'url' => html_writer::tag('a', get_string('langpack_urlname', 'theme_shoehorn'),
            array('href' => $langpackurl, 'target' => '_blank'))));
        $default = 'all';
        $setting = new admin_setting_configselect($name, $title, $description, $default, $langsinstalled);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);
    }
}
$ADMIN->add('theme_shoehorn', $slidersettings);

// Image bank....
$imagebanksettings = new admin_settingpage('theme_shoehorn_imagebank',
    get_string('imagebankheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Number of images in the image bank.
    $name = 'theme_shoehorn/numberofimagebankimages';
    $title = get_string('numberofimagebankimages', 'theme_shoehorn');
    $description = get_string('numberofimagebankimages_desc', 'theme_shoehorn');
    $default = 0;
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

    $theme = theme_config::load('shoehorn');
    $imagebanksettings->add(new admin_setting_heading('theme_shoehorn_marketingspots',
            get_string('imagebankheadingsub', 'theme_shoehorn'),
            format_text(get_string('imagebankheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    $imagebanksettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));
    $numberofimagebankimages = get_config('theme_shoehorn', 'numberofimagebankimages');
    for ($i = 1; $i <= $numberofimagebankimages; $i++) {
        $name = 'imagebankimage' . $i;
        $settingname = 'theme_shoehorn/' . $name;
        $title = get_string('imagebankimage', 'theme_shoehorn') . $i;
        if (empty($theme->settings->$name)) {
            $imagedesc = get_string('none', 'theme_shoehorn');
        } else {
            $imageurl = new moodle_url('/theme/shoehorn/imagebank.php');
            $imageurl->param('imageid', $i);
            $imagedesc = preg_replace('|^https?://|i', '//', $imageurl->out(false));
        }
        $description = get_string('imagebankimage_desc', 'theme_shoehorn', array('imagedesc' => $imagedesc));
        $setting = new admin_setting_configstoredfile($settingname, $title, $description, $name);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $imagebanksettings->add($setting);
    }
}
$ADMIN->add('theme_shoehorn', $imagebanksettings);

// Login page background image changer page....
$loginpagesettings = new admin_settingpage('theme_shoehorn_loginbackgroundchanger',
    get_string('loginbackgroundchangerheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Number of images.
    $name = 'theme_shoehorn/loginbackgroundchangernumberofimages';
    $title = get_string('loginbackgroundchangernumberofimages', 'theme_shoehorn');
    $description = get_string('loginbackgroundchangernumberofimages_desc', 'theme_shoehorn');
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
    $loginpagesettings->add(new admin_setting_heading('theme_shoehorn_loginbackgroundchanger',
        get_string('loginbackgroundchangerheadingsub', 'theme_shoehorn'),
        format_text(get_string('loginbackgroundchangerheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $loginpagesettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Image speed.
    $name = 'theme_shoehorn/loginbackgroundchangerspeed';
    $title = get_string('loginbackgroundchangerspeed', 'theme_shoehorn');
    $description = get_string('loginbackgroundchangerspeed_desc', 'theme_shoehorn');
    $default = 3000;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $loginpagesettings->add($setting);

    // Image fade.
    $name = 'theme_shoehorn/loginbackgroundchangerfade';
    $title = get_string('loginbackgroundchangerfade', 'theme_shoehorn');
    $description = get_string('loginbackgroundchangerfade_desc', 'theme_shoehorn');
    $default = 750;
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $loginpagesettings->add($setting);

    // Show on mobile.
    $name = 'theme_shoehorn/loginbackgroundchangermobile';
    $title = get_string('loginbackgroundchangermobile', 'theme_shoehorn');
    $description = get_string('loginbackgroundchangermobile_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $loginpagesettings->add($setting);

    // Show on tablet.
    $name = 'theme_shoehorn/loginbackgroundchangertablet';
    $title = get_string('loginbackgroundchangertablet', 'theme_shoehorn');
    $description = get_string('loginbackgroundchangertablet_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $loginpagesettings->add($setting);

    $numberofimages = get_config('theme_shoehorn', 'loginbackgroundchangernumberofimages');
    for ($i = 1; $i <= $numberofimages; $i++) {
        // Image.
        $name = 'theme_shoehorn/loginbackgroundchangerimage' . $i;
        $title = get_string('loginbackgroundchangerimage', 'theme_shoehorn', array('image' => $i));
        $description = get_string('loginbackgroundchangerimage_desc', 'theme_shoehorn', array('image' => $i));
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundchangerimage' . $i);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $loginpagesettings->add($setting);
    }
}
$ADMIN->add('theme_shoehorn', $loginpagesettings);

// Look and feel.
$landfsettings = new admin_settingpage('theme_shoehorn_landf', get_string('landfheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Layout.
    $landfsettings->add(new admin_setting_heading('theme_shoehorn_landf_layout',
        get_string('landflayout', 'theme_shoehorn'),
        format_text(get_string('landflayoutheading_desc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    $name = 'theme_shoehorn/landflayout';
    $title = get_string('landflayout', 'theme_shoehorn');
    $description = get_string('landflayoutdesc', 'theme_shoehorn');
    $default = 2;
    $choices = array(
        1 => get_string('landflayoutbutton', 'theme_shoehorn'),
        2 => get_string('landflayoutstep', 'theme_shoehorn')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Colours.
    $landfsettings->add(new admin_setting_heading('theme_shoehorn_landf_colours',
        get_string('landfcolours', 'theme_shoehorn'),
        format_text(get_string('landfcolours_desc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    // Text.
    $name = 'theme_shoehorn/textcolour';
    $title = get_string('textcolour', 'theme_shoehorn');
    $description = get_string('textcolourdesc', 'theme_shoehorn');
    $default = '#1F4D87';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Link.
    $name = 'theme_shoehorn/linkcolour';
    $title = get_string('linkcolour', 'theme_shoehorn');
    $description = get_string('linkcolourdesc', 'theme_shoehorn');
    $default = '#1F4D87';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Navbar Text.
    $name = 'theme_shoehorn/navbartextcolour';
    $title = get_string('navbartextcolour', 'theme_shoehorn');
    $description = get_string('navbartextcolourdesc', 'theme_shoehorn');
    $default = '#653CAE';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Navbar Background.
    $name = 'theme_shoehorn/navbarbackgroundcolour';
    $title = get_string('navbarbackgroundcolour', 'theme_shoehorn');
    $description = get_string('navbarbackgroundcolourdesc', 'theme_shoehorn');
    $default = '#FFD974';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Navbar Border.
    $name = 'theme_shoehorn/navbarbordercolour';
    $title = get_string('navbarbordercolour', 'theme_shoehorn');
    $description = get_string('navbarbordercolourdesc', 'theme_shoehorn');
    $default = '#FFD053';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Page Top.
    $name = 'theme_shoehorn/pagetopcolour';
    $title = get_string('pagetopcolour', 'theme_shoehorn');
    $description = get_string('pagetopcolourdesc', 'theme_shoehorn');
    $default = '#2E73C9';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Page Bottom.
    $name = 'theme_shoehorn/pagebottomcolour';
    $title = get_string('pagebottomcolour', 'theme_shoehorn');
    $description = get_string('pagebottomcolourdesc', 'theme_shoehorn');
    $default = '#C9E6FF';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Page Header Text.
    $name = 'theme_shoehorn/pageheadertextcolour';
    $title = get_string('pageheadertextcolour', 'theme_shoehorn');
    $description = get_string('pageheadertextcolourdesc', 'theme_shoehorn');
    $default = '#FFFFFF';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Footer Text.
    $name = 'theme_shoehorn/footertextcolour';
    $title = get_string('footertextcolour', 'theme_shoehorn');
    $description = get_string('footertextcolourdesc', 'theme_shoehorn');
    $default = '#B8D2E9';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Footer top.
    $name = 'theme_shoehorn/footertopcolour';
    $title = get_string('footertopcolour', 'theme_shoehorn');
    $description = get_string('footertopcolourdesc', 'theme_shoehorn');
    $default = '#269F00';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Footer bottom.
    $name = 'theme_shoehorn/footerbottomcolour';
    $title = get_string('footerbottomcolour', 'theme_shoehorn');
    $description = get_string('footerbottomcolourdesc', 'theme_shoehorn');
    $default = '#267F00';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Front page.
    $landfsettings->add(new admin_setting_heading('theme_shoehorn_landf_frontpage',
        get_string('landffontpage', 'theme_shoehorn'),
        format_text(get_string('landffontpage_desc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    // Front page background image.
    $name = 'theme_shoehorn/landffrontpagebackgroundimage';
    $title = get_string('landffrontpagebackgroundimage', 'theme_shoehorn');
    $description = get_string('landffrontpagebackgroundimage_desc', 'theme_shoehorn');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'landffrontpagebackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Front page content transparency.
    $name = 'theme_shoehorn/landffrontpagecontenttransparency';
    $title = get_string('landffrontpagecontenttransparency', 'theme_shoehorn');
    $description = get_string('landffrontpagecontenttransparency_desc', 'theme_shoehorn');
    $default = 100;
    $choices = array(
        100 => get_string('zeropercent', 'theme_shoehorn'),
        95 => get_string('fivepercent', 'theme_shoehorn'),
        90 => get_string('tenpercent', 'theme_shoehorn'),
        85 => get_string('fifteenpercent', 'theme_shoehorn'),
        80 => get_string('twentypercent', 'theme_shoehorn'),
        75 => get_string('twentyfivepercent', 'theme_shoehorn'),
        70 => get_string('thirtypercent', 'theme_shoehorn'),
        65 => get_string('thirtyfivepercent', 'theme_shoehorn'),
        60 => get_string('fortypercent', 'theme_shoehorn'),
        55 => get_string('fortyfivepercent', 'theme_shoehorn'),
        50 => get_string('fiftypercent', 'theme_shoehorn'),
        45 => get_string('fifyfivepercent', 'theme_shoehorn'),
        40 => get_string('sixtypercent', 'theme_shoehorn'),
        35 => get_string('sixtyfivepercent', 'theme_shoehorn'),
        30 => get_string('seventypercent', 'theme_shoehorn'),
        25 => get_string('seventyfivepercent', 'theme_shoehorn'),
        20 => get_string('eightypercent', 'theme_shoehorn'),
        15 => get_string('eightyfivepercent', 'theme_shoehorn'),
        10 => get_string('ninetypercent', 'theme_shoehorn'),
        5 => get_string('ninetyfivepercent', 'theme_shoehorn'),
        0 => get_string('onehundredpercent', 'theme_shoehorn')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // Quiz.
    $landfsettings->add(new admin_setting_heading('theme_shoehorn_landf_quiz',
        get_string('landfquiz', 'theme_shoehorn'),
        format_text(get_string('landfquiz_desc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    $name = 'theme_shoehorn/landfallhorizontalquiz';
    $title = get_string('landfallhorizontalquiz', 'theme_shoehorn');
    $description = get_string('landfallhorizontalquiz_desc', 'theme_shoehorn');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // All other pages.
    $landfsettings->add(new admin_setting_heading('theme_shoehorn_landf_allpages',
        get_string('landfallpages', 'theme_shoehorn'),
        format_text(get_string('landfallpages_desc', 'theme_shoehorn'), FORMAT_MARKDOWN)));

    // All other pages background image.
    $name = 'theme_shoehorn/landfallpagesbackgroundimage';
    $title = get_string('landfallpagesbackgroundimage', 'theme_shoehorn');
    $description = get_string('landfallpagesbackgroundimage_desc', 'theme_shoehorn');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'landfallpagesbackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);

    // All other pages content transparency.
    $name = 'theme_shoehorn/landfallpagescontenttransparency';
    $title = get_string('landfallpagescontenttransparency', 'theme_shoehorn');
    $description = get_string('landfallpagescontenttransparency_desc', 'theme_shoehorn');
    $default = 100;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $landfsettings->add($setting);
}
$ADMIN->add('theme_shoehorn', $landfsettings);


// Marketing spots....
$marketingspotssettings = new admin_settingpage('theme_shoehorn_marketingspots',
    get_string('marketingspotsheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Number of marketing spots.
    $name = 'theme_shoehorn/numberofmarketingspots';
    $title = get_string('numberofmarketingspots', 'theme_shoehorn');
    $description = get_string('numberofmarketingspots_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        0 => '0',
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4'
    );
    $marketingspotssettings->add(new admin_setting_heading('theme_shoehorn_marketingspots',
        get_string('marketingspotsheadingsub', 'theme_shoehorn'),
        format_text(get_string('marketingspotsheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $marketingspotssettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    $numberofmarketingspots = get_config('theme_shoehorn', 'numberofmarketingspots');
    for ($i = 1; $i <= $numberofmarketingspots; $i++) {
        $marketingspotssettings->add(new admin_setting_heading('theme_shoehorn_marketingspot_heading' . $i,
            get_string('marketingspotsettingspageheading', 'theme_shoehorn', array('spot' => $i)), null));

        // Marketing spot heading.
        $name = 'theme_shoehorn/marketingspotheading' . $i;
        $title = get_string('marketingspotheading', 'theme_shoehorn', array('spot' => $i));
        $description = get_string('marketingspotheading_desc', 'theme_shoehorn', array('spot' => $i));
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $marketingspotssettings->add($setting);

        // Marketing spot content.
        $name = 'theme_shoehorn/marketingspotcontent' . $i;
        $title = get_string('marketingspotcontent', 'theme_shoehorn', array('spot' => $i));
        $description = get_string('marketingspotcontent_desc', 'theme_shoehorn', array('spot' => $i));
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $marketingspotssettings->add($setting);

        // Status.
        $name = 'theme_shoehorn/marketingspotstatus' . $i;
        $title = get_string('marketingspotstatus', 'theme_shoehorn', array('spot' => $i));
        $description = get_string('marketingspotstatus_desc', 'theme_shoehorn');
        $default = 1;
        $choices = array(
            1 => new lang_string('draft', 'theme_shoehorn'),
            2 => new lang_string('published', 'theme_shoehorn')
        );
        $marketingspotssettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

        // Display.
        $name = 'theme_shoehorn/marketingspotdisplay' . $i;
        $title = get_string('marketingspotdisplay', 'theme_shoehorn', array('spot' => $i));
        $description = get_string('marketingspotdisplay_desc', 'theme_shoehorn', array('spot' => $i));
        $default = 1;
        $choices = array(
            1 => new lang_string('always', 'theme_shoehorn'),
            2 => new lang_string('loggedout', 'theme_shoehorn'),
            3 => new lang_string('loggedin', 'theme_shoehorn')
        );
        $marketingspotssettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

        // Marketing spot language only.
        $name = 'theme_shoehorn/marketingspotlang' . $i;
        $title = get_string('marketingspotlang', 'theme_shoehorn', array('spot' => $i));
        $description = get_string('marketingspotlang_desc', 'theme_shoehorn',
            array('spot' => $i, 'url' => html_writer::tag('a', get_string('langpack_urlname', 'theme_shoehorn'),
            array('href' => $langpackurl, 'target' => '_blank')))
        );
        $default = 'all';
        $setting = new admin_setting_configselect($name, $title, $description, $default, $langsinstalled);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $marketingspotssettings->add($setting);
    }
}
$ADMIN->add('theme_shoehorn', $marketingspotssettings);

// Site pages....
$sitepagessettings = new admin_settingpage('theme_shoehorn_sitepages',
    get_string('sitepagesheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Number of site pages.
    $name = 'theme_shoehorn/numberofsitepages';
    $title = get_string('numberofsitepages', 'theme_shoehorn');
    $description = get_string('numberofsitepages_desc', 'theme_shoehorn');
    $default = 1;
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

    $sitepagessettings->add(new admin_setting_heading('theme_shoehorn_sitepages',
        get_string('sitepagesheadingsub', 'theme_shoehorn'),
        format_text(get_string('sitepagesheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $sitepagessettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    $numberofsitepages = get_config('theme_shoehorn', 'numberofsitepages');
    for ($i = 1; $i <= $numberofsitepages; $i++) {
        $sitepagessettings->add(new admin_setting_heading('theme_shoehorn_sitepage_heading' . $i,
            get_string('sitepagesettingspageheading', 'theme_shoehorn', array('pageid' => $i)), null));

        // Site page title.
        $name = 'theme_shoehorn/sitepagetitle' . $i;
        $title = get_string('sitepagetitle', 'theme_shoehorn', array('pageid' => $i));
        $description = get_string('sitepagetitle_desc', 'theme_shoehorn', array('pageid' => $i));
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $sitepagessettings->add($setting);

        // Site page heading.
        $name = 'theme_shoehorn/sitepageheading' . $i;
        $title = get_string('sitepageheading', 'theme_shoehorn', array('pageid' => $i));
        $description = get_string('sitepageheading_desc', 'theme_shoehorn', array('pageid' => $i));
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $sitepagessettings->add($setting);

        // Site page content.
        $name = 'theme_shoehorn/sitepagecontent' . $i;
        $title = get_string('sitepagecontent', 'theme_shoehorn', array('pageid' => $i));
        $description = get_string('sitepagecontent_desc', 'theme_shoehorn', array('pageid' => $i));
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $sitepagessettings->add($setting);

        // Status.
        $name = 'theme_shoehorn/sitepagestatus' . $i;
        $title = get_string('sitepagestatus', 'theme_shoehorn', array('pageid' => $i));
        $description = get_string('sitepagestatus_desc', 'theme_shoehorn');
        $default = 1;
        $choices = array(
            1 => new lang_string('draft', 'theme_shoehorn'),
            2 => new lang_string('published', 'theme_shoehorn')
        );
        $sitepagessettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

        // Display.
        $name = 'theme_shoehorn/sitepagedisplay' . $i;
        $title = get_string('sitepagedisplay', 'theme_shoehorn', array('pageid' => $i));
        $description = get_string('sitepagedisplay_desc', 'theme_shoehorn', array('pageid' => $i));
        $default = 1;
        $choices = array(
            1 => new lang_string('always', 'theme_shoehorn'),
            2 => new lang_string('loggedout', 'theme_shoehorn'),
            3 => new lang_string('loggedin', 'theme_shoehorn')
        );
        $sitepagessettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

        // Site page language only.
        $name = 'theme_shoehorn/sitepagelang' . $i;
        $title = get_string('sitepagelang', 'theme_shoehorn', array('pageid' => $i));
        $description = get_string('sitepagelang_desc', 'theme_shoehorn',
            array('pageid' => $i, 'url' => html_writer::tag('a', get_string('langpack_urlname', 'theme_shoehorn'),
            array('href' => $langpackurl, 'target' => '_blank')))
        );
        $default = 'all';
        $setting = new admin_setting_configselect($name, $title, $description, $default, $langsinstalled);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $sitepagessettings->add($setting);
    }
}
$ADMIN->add('theme_shoehorn', $sitepagessettings);

// Social links page....
$socialsettings = new admin_settingpage('theme_shoehorn_social', get_string('socialheading', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    // Number of social links.
    $name = 'theme_shoehorn/numberofsociallinks';
    $title = get_string('numberofsociallinks', 'theme_shoehorn');
    $description = get_string('numberofsociallinks_desc', 'theme_shoehorn');
    $default = 2;
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

    $socialsettings->add(new admin_setting_heading('theme_shoehorn_social',
        get_string('socialheadingsub', 'theme_shoehorn'),
        format_text(get_string('socialheadingdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $socialsettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    $numberofsociallinks = get_config('theme_shoehorn', 'numberofsociallinks');
    for ($i = 1; $i <= $numberofsociallinks; $i++) {
        // Social url setting.
        $name = 'theme_shoehorn/social' . $i;
        $title = get_string('socialnetworklink', 'theme_shoehorn') . $i;
        $description = get_string('socialnetworklink_desc', 'theme_shoehorn') . $i;
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $socialsettings->add($setting);

        // Social icon setting.
        $name = 'theme_shoehorn/socialicon' . $i;
        $title = get_string('socialnetworkicon', 'theme_shoehorn') . $i;
        $description = get_string('socialnetworkicon_desc', 'theme_shoehorn') . $i;
        $default = 'globe';
        $choices = array(
            'dropbox' => 'Dropbox',
            'facebook-square' => 'Facebook',
            'flickr' => 'Flickr',
            'github' => 'Github',
            'google-plus-square' => 'Google Plus',
            'instagram' => 'Instagram',
            'linkedin-square' => 'Linkedin',
            'pinterest-square' => 'Pinterest',
            'skype' => 'Skype',
            'tumblr-square' => 'Tumblr',
            'twitter-square' => 'Twitter',
            'users' => 'Unlisted',
            'vimeo-square' => 'Vimeo',
            'vk' => 'Vk',
            'globe' => 'Website',
            'youtube-square' => 'YouTube'
        );
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $socialsettings->add($setting);
    }

    // Use the signpost.
    $name = 'theme_shoehorn/socialsignpost';
    $title = get_string('socialsignpost', 'theme_shoehorn');
    $description = get_string('socialsignpost_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, '1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $socialsettings->add($setting);
}
$ADMIN->add('theme_shoehorn', $socialsettings);

// Style guide.
$styleguidesetting = new admin_settingpage('theme_shoehorn_styleguide', get_string('styleguide', 'theme_shoehorn'));
if ($ADMIN->fulltree) {
    if (file_exists("{$CFG->dirroot}/theme/shoehorn/shoehorn_admin_setting_styleguide.php")) {
        require_once($CFG->dirroot . '/theme/shoehorn/shoehorn_admin_setting_styleguide.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/shoehorn/shoehorn_admin_setting_styleguide.php")) {
        require_once($CFG->themedir . '/shoehorn/shoehorn_admin_setting_styleguide.php');
    }
    $styleguidesetting->add(new shoehorn_admin_setting_styleguide('theme_shoehorn_styleguide',
        get_string('styleguidesub', 'theme_shoehorn'),
        get_string('styleguidedesc', 'theme_shoehorn',
            array(
                'origcodelicenseurl' => html_writer::link('https://github.com/twbs/bootstrap/blob/master/LICENSE', 'MIT',
                    array('target' => '_blank')),
                'holderlicenseurl' => html_writer::link('https://github.com/imsky/holder#license', 'MIT',
                    array('target' => '_blank')),
                'thiscodelicenseurl' => html_writer::link('http://www.gnu.org/copyleft/gpl.html', 'GPLv3',
                    array('target' => '_blank')),
                'compatible' => html_writer::link('http://www.gnu.org/licenses/license-list.en.html#apache2', 'compatible',
                    array('target' => '_blank')),
                'contentlicenseurl' => html_writer::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0',
                    array('target' => '_blank')),
                'overview' => html_writer::link('http://getbootstrap.com/css/#overview', 'Overview',
                    array('target' => '_blank'))
            )
        )
    ));
}
$ADMIN->add('theme_shoehorn', $styleguidesetting);
