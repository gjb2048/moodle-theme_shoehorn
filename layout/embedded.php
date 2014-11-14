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

$settingshtml = theme_shoehorn_html_for_settings($PAGE);
echo $OUTPUT->doctype() 
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<?php require_once(dirname(__FILE__).'/tiles/header.php'); ?>

<body <?php echo $OUTPUT->body_attributes($settingshtml->additionalbodyclasses); ?>>
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page" class="container-fluid">
    <div id="page-area" class="row">
        <div id="page-content" class="clearfix row">
            <div id="region-main" class="col-md-12">
            <section id="region-main-shoehorn">
                <?php echo $OUTPUT->main_content(); ?>
            </section>
            <div id="region-main-shoehorn-shadow"></div>
            </div>
        </div>
    </div>
    <div id="footer-shadow" class="row"></div>
    <footer id="page-footer" class="row">
    </footer>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</div>
</body>
</html>