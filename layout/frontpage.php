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

require_once(\theme_shoehorn\toolbox::get_tile_file('additionaljs'));

if (!$PAGE->user_is_editing()) {
    $hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
    $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
} else {
    $hassidepre = $PAGE->blocks->is_known_region('side-pre');
    $hassidepost = $PAGE->blocks->is_known_region('side-post');
}

$PAGE->set_popup_notification_allowed(false);

$showslider = \theme_shoehorn\toolbox::showslider();
$regions = \theme_shoehorn\toolbox::grid($hassidepre, $hassidepost);
$settingshtml = \theme_shoehorn\toolbox::html_for_settings();

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<?php require_once(\theme_shoehorn\toolbox::get_tile_file('header')); ?>

<body <?php echo $OUTPUT->body_attributes($settingshtml->additionalbodyclasses); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page" class="<?php echo $settingshtml->containerclass; ?>">

    <div id="page-area" class="row">
        <?php require_once(\theme_shoehorn\toolbox::get_tile_file('navbar')); ?>

        <?php require_once(\theme_shoehorn\toolbox::get_tile_file('pageheader')); ?>

        <div id="page-content" class="row">
            <div id="region-main" class="<?php echo $regions['content']; ?>">
                <?php
                if ($showslider) {
                    require_once(\theme_shoehorn\toolbox::get_tile_file('frontpageslider'));
                }
                require_once(\theme_shoehorn\toolbox::get_tile_file('marketingspots'));
                ?>
                <section id="region-main-shoehorn">
                    <?php
                    echo $OUTPUT->course_content_header();
                    echo $OUTPUT->main_content();
                    echo $OUTPUT->course_content_footer();
                    ?>
                </section>
                <div id="region-main-shoehorn-shadow"></div>
            </div>

            <?php
            if ($hassidepre) {
                echo $OUTPUT->blocks('side-pre', $regions['pre']);
            }
            if ($hassidepost) {
                echo $OUTPUT->blocks('side-post', $regions['post']);
            }?>

            <?php require_once(\theme_shoehorn\toolbox::get_tile_file('pagebottom')); ?>
        </div>

    </div>

    <?php require_once(\theme_shoehorn\toolbox::get_tile_file('footer')); ?>

</div>
</body>
</html>
