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
 * Shoehorn theme.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2014-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_shoehorn\output;

use html_writer;

defined('MOODLE_INTERNAL') || die();

trait core_renderer_toolbox {

    public function get_setting($setting) {
        $tcr = array_reverse($this->themeconfig, true);

        $settingvalue = false;
        foreach ($tcr as $tconfig) {
            if (property_exists($tconfig->settings, $setting)) {
                $settingvalue = $tconfig->settings->$setting;
                break;
            }
        }
        return $settingvalue;
    }

    public function setting_file_url($setting, $filearea) {
        $tcr = array_reverse($this->themeconfig, true);
        $settingconfig = null;
        foreach ($tcr as $tconfig) {
            if (property_exists($tconfig->settings, $setting)) {
                $settingconfig = $tconfig;
                break;
            }
        }

        if ($settingconfig) {
            return $settingconfig->setting_file_url($setting, $filearea);
        }
        return null;
    }

    public function pix_url($imagename, $component = 'moodle') {
        return end($this->themeconfig)->pix_url($imagename, $component);
    }

    public function notification($message, $classes = 'notifyproblem') {
        $message = clean_text($message);

        if ($classes == 'notifyproblem') {
            return html_writer::div($message, 'alert alert-danger');
        }
        if ($classes == 'notifywarning') {
            return html_writer::div($message, 'alert alert-warning');
        }
        if ($classes == 'notifysuccess') {
            return html_writer::div($message, 'alert alert-success');
        }
        if ($classes == 'notifymessage') {
            return html_writer::div($message, 'alert alert-info');
        }
        if ($classes == 'redirectmessage') {
            return html_writer::div($message, 'alert alert-block alert-info');
        }
        return html_writer::div($message, $classes);
    }
}
