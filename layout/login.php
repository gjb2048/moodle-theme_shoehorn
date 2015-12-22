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

/**
 * This layout file is designed maintenance related tasks such as upgrade and installation of plugins.
 *
 * It's ultra important that this layout file makes no use of API's unless it absolutely needs to.
 * Under no circumstances should it use API calls that result in database or cache interaction.
 *
 * If you are modifying this file please be extremely careful, one wrong API call and you could end up
 * breaking installation or upgrade unwittingly.
 */

$loggedin = isloggedin();
require_once(\theme_shoehorn\toolbox::get_tile_file('additionaljs'));

$settingshtml = \theme_shoehorn\toolbox::html_for_settings();
if (!empty($loginpageimages)) {  // Variable $loginpageimages defined in additionaljs.php.
    $settingshtml->additionalbodyclasses[] = 'loginpageimages';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<?php require_once(\theme_shoehorn\toolbox::get_tile_file('header')); ?>

<body <?php echo $OUTPUT->body_attributes($settingshtml->additionalbodyclasses); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<?php require_once(\theme_shoehorn\toolbox::get_tile_file('navbar')); ?>

<div id="page" class="<?php echo $settingshtml->containerclass; ?>">

    <div id="page-content" class="row">
        <div id="region-main" class="col-md-12<?php echo (!$loggedin) ? ' loggedout' : ''; ?>">
            <?php
            if ($loggedin) {
                echo html_writer::start_tag('section', array('id' => 'region-main-shoehorn'));
            }
            echo $OUTPUT->main_content();
            if ($loggedin) {
                echo html_writer::end_tag('section');
            }
            ?>
        </div>
        <?php require_once(\theme_shoehorn\toolbox::get_tile_file('pagebottom')); ?>
    </div>

    <?php require_once(\theme_shoehorn\toolbox::get_tile_file('footer')); ?>

</div>
</body>
</html>
