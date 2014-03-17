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
 * Shoelace theme with the underlying Bootstrap theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

    $settings = null;
    $ADMIN->add('themes', new admin_category('theme_shoehorn', 'Shoehorn'));

    $generalsettings = new admin_settingpage('theme_shoehorn_general', get_string('generalsettings', 'theme_shoehorn'));

    /* CDN Fonts - 1 = no, 2 = yes. */
    $name = 'theme_shoehorn/cdnfonts';
    $title = get_string('cdnfonts', 'theme_shoehorn');
    $description = get_string('cdnfonts_desc', 'theme_shoehorn');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'),   // No.
        2 => new lang_string('yes')   // Yes.
    );
    $generalsettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Invert Navbar to dark background.
    $name = 'theme_shoehorn/invert';
    $title = get_string('invert', 'theme_shoehorn');
    $description = get_string('invertdesc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Logo file setting.
    $name = 'theme_shoehorn/logo';
    $title = get_string('logo','theme_shoehorn');
    $description = get_string('logodesc', 'theme_shoehorn');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Footer menu.
    $name = 'theme_shoehorn/footermenu';
    $title = get_string('footermenu', 'theme_shoehorn');
    $description = get_string('footermenu_desc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Custom CSS file.
    $name = 'theme_shoehorn/customcss';
    $title = get_string('customcss', 'theme_shoehorn');
    $description = get_string('customcss_desc', 'theme_shoehorn');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $generalsettings->add($setting);

    // Number of slides.
    $name = 'theme_shoehorn/numberofslides';
    $title = get_string('numberofslides', 'theme_shoehorn');
    $description = get_string('numberofslides_desc', 'theme_shoehorn');
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
    $generalsettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

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
    $generalsettings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    $ADMIN->add('theme_shoehorn', $generalsettings);

    // Slider page....
    $slidersettings = new admin_settingpage('theme_shoehorn_slider', get_string('sliderheading', 'theme_shoehorn'));
    $slidersettings->add(new admin_setting_heading('theme_moment_slider', get_string('sliderheadingsub', 'theme_shoehorn'),
            format_text(get_string('socialdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $numberofslides = get_config('theme_shoehorn', 'numberofslides');

    // Show on mobile.
    $name = 'theme_shoehorn/slidermobile';
    $title = get_string('slidermobile', 'theme_shoehorn');
    $description = get_string('slidermobile_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    // Show on tablet.
    $name = 'theme_shoehorn/slidertablet';
    $title = get_string('slidertablet', 'theme_shoehorn');
    $description = get_string('slidertablet_desc', 'theme_shoehorn');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $slidersettings->add($setting);

    for ($i = 1; $i <= $numberofslides; $i++) {
        // Image.
        $name = 'theme_shoehorn/slideimage'.$i;
        $title = get_string('slideimage', 'theme_shoehorn').$i;
        $description = get_string('slideimage_desc', 'theme_shoehorn').$i;
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slideimage'.$i);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // URL.
        $name = 'theme_shoehorn/slideurl'.$i;
        $title = get_string('slideurl', 'theme_shoehorn').$i;
        $description = get_string('slideurl_desc', 'theme_shoehorn').$i;
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // Caption title.
        $name = 'theme_shoehorn/slidecaptiontitle'.$i;
        $title = get_string('slidecaptiontitle', 'theme_shoehorn').$i;
        $description = get_string('slidecaptiontitle_desc', 'theme_shoehorn').$i;
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);

        // Caption text.
        $name = 'theme_shoehorn/slidecaptiontext'.$i;
        $title = get_string('slidecaptiontext', 'theme_shoehorn').$i;
        $description = get_string('slidecaptiontext_desc', 'theme_shoehorn').$i;
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $slidersettings->add($setting);
    }

    $ADMIN->add('theme_shoehorn', $slidersettings);

    // Social links page....
    $socialsettings = new admin_settingpage('theme_shoehorn_social', get_string('socialheading', 'theme_shoehorn'));
    $socialsettings->add(new admin_setting_heading('theme_shoehorn_social', get_string('socialheadingsub', 'theme_shoehorn'),
            format_text(get_string('socialdesc', 'theme_shoehorn'), FORMAT_MARKDOWN)));
    $numberofsociallinks = get_config('theme_shoehorn', 'numberofsociallinks');
    for ($i = 1; $i <= $numberofsociallinks; $i++) {
        // Social url setting.
        $name = 'theme_shoehorn/social'.$i;
        $title = get_string('socialnetworklink', 'theme_shoehorn').$i;
        $description = get_string('socialnetworklink_desc', 'theme_shoehorn').$i;
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $socialsettings->add($setting);

        // Social icon setting.
        $name = 'theme_shoehorn/socialicon'.$i;
        $title = get_string('socialnetworkicon', 'theme_shoehorn').$i;
        $description = get_string('socialnetworkicon_desc', 'theme_shoehorn').$i;
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
    $ADMIN->add('theme_shoehorn', $socialsettings);
