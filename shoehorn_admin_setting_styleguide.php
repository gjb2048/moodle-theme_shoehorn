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
 * Style guide.
 *
 * @package    theme
 * @subpackage shoehorn
 * @copyright  &copy; 2016-onwards G J Barnard.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @license    PHP Code: http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 * @license    Source HTML Code: http://www.apache.org/licenses/LICENSE-2.0 Apache License v2.0:
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Which is a compatible license, see: http://www.gnu.org/licenses/license-list.en.html#apache2.
 *
 * @license    Content: http://creativecommons.org/licenses/by/3.0/ Creative Commons Attribution 3.0 Unported (CC BY 3.0).
 *
 * Content source reference: http://getbootstrap.com/2.3.2/base-css.html.
 */
class shoehorn_admin_setting_styleguide extends admin_setting {

    /**
     * Constructor
     *
     * @param string $name unique ascii name, either 'mysetting' for settings that in config, or
     * 'myplugin/mysetting' for ones in config_plugins.
     * @param string $visiblename localised
     * @param string $description long localised info
     */
    public function __construct($name, $visiblename, $description) {
        $this->nosave = true;

        global $PAGE;
        if (($PAGE->bodyid == 'page-admin-setting-' . $name) ||
            ($PAGE->bodyid == 'page-theme-'.$PAGE->theme->name.'-pages-styleguide')) {
            $bc = new block_contents();
            $bc->title = get_string('styleguide', 'theme_shoehorn');
            $bc->attributes['class'] = 'block block_style_guide';
            $bc->content = \theme_shoehorn\toolbox::get_file_contents('styleguide/nav.html');
            $defaultregion = $PAGE->blocks->get_default_region();
            $PAGE->blocks->add_fake_block($bc, $defaultregion);

            $PAGE->requires->js_call_amd('theme_shoehorn/styleguide', 'init');
        }

        parent::__construct($name, $visiblename, $description, '');
    }

    /**
     * Always returns true
     * @return bool Always returns true
     */
    public function get_setting() {
        return true;
    }

    /**
     * Always returns true
     * @return bool Always returns true
     */
    public function get_defaultsetting() {
        return true;
    }

    /**
     * Never write settings
     * @return string Always returns an empty string
     */
    public function write_setting($data) {
        // Do not write any setting.
        return '';
    }

    /**
     * Returns an HTML string
     * @return string Returns an HTML string
     */
    public function output_html($data, $query = '') {
        global $OUTPUT;
        $return = '';
        if ($this->visiblename != '') {
            $return .= $OUTPUT->heading($this->visiblename, 3, 'main');
        }
        if ($this->description != '') {
            $return .= $OUTPUT->box(highlight($query, markdown_to_html($this->description)),
                    'generalbox formsettingheading');
        }

        $return .= '<div class="'.$this->name.'">';

        $return .= '<style type="text/css" media="screen">';
        $return .= '/* <![CDATA[ */';
        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/docs.css');
        $return .= '/* ]]> */';
        $return .= '</style>';

        $return .= '<style type="text/css" media="screen">';
        $return .= '/* <![CDATA[ */';
        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/ie10-viewport-bug-workaround.css');
        $return .= '/* ]]> */';
        $return .= '</style>';

        // Beyond docs.css.
        $return .= '<style type="text/css" media="screen">';
        $return .= '/* <![CDATA[ */';
        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/beyonddocs.css');
        $return .= '/* ]]> */';
        $return .= '</style>';

        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/css.html');

        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/components.html');

        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/javascript.html');

        $return .= '</div>';

        return $return;
    }
}
