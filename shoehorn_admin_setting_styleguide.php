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
        if ($PAGE->bodyid == 'page-admin-setting-' . $name) {
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
        $return .= ".show-grid {";
        $return .= "margin-left: 0;";
        $return .= "margin-right: 0;";
        $return .= "}";
        $return .= ".bs-docs-example .navbar {";
        $return .= "position: static;";
        $return .= "}";
        $return .= ".bs-docs-example .carousel-indicators {";
        $return .= "background-color: #30add1;";
        $return .= "border-radius: 4px;";
        $return .= "padding: 2px;";
        $return .= "}";
        $return .= ".bs-docs-example .carousel-indicators li {";
        $return .= "margin-left: 2px;";
        $return .= "margin-right: 2px;";
        $return .= "}";
        $return .= ".bs-docs-example .carousel-inner img {";
        $return .= "margin: 0 auto;";
        $return .= "}";
        $return .= "#forms .checkbox input[type=checkbox] {";
        $return .= "margin-left: 0;";
        $return .= "margin-right: 0;";
        $return .= "}";
        $return .= '.'.$this->name.' .thumbnail-container {';
        $return .= 'width: 100%;';
        $return .= 'position: relative;';
        $return .= 'padding-bottom: 75%;';
        $return .= '}';
        $return .= '.'.$this->name.' .thumbnail-container img {';
        $return .= 'position: absolute;';
        $return .= 'max-height: 100%;';
        $return .= 'left: 0;';
        $return .= 'right: 0;';
        $return .= 'top: 0;';
        $return .= 'bottom: 0;';
        $return .= 'margin: auto;';
        $return .= '}';
        $return .= '/* ]]> */';
        $return .= '</style>';

        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/css.html');

        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/components.html');

        $return .= '</div>';

        $return .= '<script>';
        $return .= \theme_shoehorn\toolbox::get_file_contents('styleguide/holder.min.js');
        $return .= '</script>';

        return $return;
    }

    private function sixtyfoursixtyfour() {
        $return = '<img class="media-object" alt="64x64" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2264%22%20height';
        $return .= '%3D%2264%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2064%2064%22%20preserve';
        $return .= 'AspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15319846969%20text%20%7B%';
        $return .= '20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif';
        $return .= '%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15319846969%22%3E';
        $return .= '%3Crect%20width%3D%2264%22%20height%3D%2264%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%';
        $return .= '2214.5%22%20y%3D%2236.5%22%3E64x64%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" ';
        $return .= 'style="width: 64px; height: 64px;">';
        return $return;
    }

    private function onesixtyonetwenty() {
        $return = '<img alt="160x120" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22160%22%20height%3D%22120%22%20xml';
        $return .= 'ns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20160%20120%22%20preserveAspectRatio%3D%';
        $return .= '22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1531984695a%20text%20%7B%20fill%3A%23AAA';
        $return .= 'AAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace';
        $return .= '%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1531984695a%22%3E%3Crect%20width';
        $return .= '%3D%22160%22%20height%3D%22120%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2255.5%22%20y';
        $return .= '%3D%2264.5%22%3E160x120%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" ';
        $return .= 'style="width: 160px; height: 120px;">';
        return $return;
    }

    private function twosixtyonetwenty() {
        $return = '<img alt="260x120" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22260%22%20height%3D%22120%22%20xml';
        $return .= 'ns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20260%20120%22%20preserveAspectRatio%3D%';
        $return .= '22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15319846957%20text%20%7B%20fill%3A%23AAA';
        $return .= 'AAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace';
        $return .= '%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15319846957%22%3E%3Crect%20width';
        $return .= '%3D%22260%22%20height%3D%22120%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2296.2734375%';
        $return .= '22%20y%3D%2266%22%3E260x120%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" ';
        $return .= 'style="width: 260px; height: 120px;">';
        return $return;
    }

    private function twosixtyoneeighty() {
        $return = '<img alt="260x180" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22260%22%20height%3D%22180%22%20xml';
        $return .= 'ns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20260%20180%22%20preserveAspectRatio%3D%';
        $return .= '22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15319846937%20text%20%7B%20fill%3A%23AAA';
        $return .= 'AAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace';
        $return .= '%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15319846937%22%3E%3Crect%20width';
        $return .= '%3D%22260%22%20height%3D%22180%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2296.2734375%';
        $return .= '22%20y%3D%2296%22%3E260x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" ';
        $return .= 'style="width: 260px; height: 180px;">';
        return $return;
    }

    private function threehundredtwohundred() {
        $return = '<img alt="300x200" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22300%22%20height%3D%22200%22%20xml';
        $return .= 'ns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20300%20200%22%20preserveAspectRatio%3D%';
        $return .= '22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1531984694b%20text%20%7B%20fill%3A%23AAA';
        $return .= 'AAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace';
        $return .= '%3Bfont-size%3A15pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1531984694b%22%3E%3Crect%20width';
        $return .= '%3D%22300%22%20height%3D%22200%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22111.0703125';
        $return .= '%22%20y%3D%22106.6%22%3E300x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" ';
        $return .= 'style="width: 300px; height: 200px;">';
        return $return;
    }

    private function threesixtytwoseventy() {
        $return = '<img alt="360x270" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22360%22%20height%3D%22270%22%20xml';
        $return .= 'ns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20360%20270%22%20preserveAspectRatio%3D%';
        $return .= '22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15319846955%20text%20%7B%20fill%3A%23AAA';
        $return .= 'AAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace';
        $return .= '%3Bfont-size%3A18pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15319846955%22%3E%3Crect%20width';
        $return .= '%3D%22360%22%20height%3D%22270%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22133.2890625';
        $return .= '%22%20y%3D%22143.1%22%3E360x270%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" ';
        $return .= 'style="width: 360px; height: 270px;">';
        return $return;
    }
}
