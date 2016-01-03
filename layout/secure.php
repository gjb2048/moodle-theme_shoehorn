<?php
// This file is part of The Bootstrap 3 Moodle theme
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

require_once(\theme_shoehorn\toolbox::get_tile_file('additionaljs'));

if (!$PAGE->user_is_editing()) {
    $hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
    $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
} else {
    $hassidepre = $PAGE->blocks->is_known_region('side-pre');
    $hassidepost = $PAGE->blocks->is_known_region('side-post');
}

$regions = \theme_shoehorn\toolbox::grid($hassidepre, $hassidepost);
$settingshtml = \theme_shoehorn\toolbox::html_for_settings();

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<?php require_once(\theme_shoehorn\toolbox::get_tile_file('header')); ?>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page" class="<?php echo $settingshtml->containerclass; ?>">

    <div id="page-area" class="row">
        <?php require_once(\theme_shoehorn\toolbox::get_tile_file('navbar')); ?>

        <header class="moodleheader col-md-12">
            <?php echo $OUTPUT->page_heading(); ?>
        </header>

        <div id="page-content" class="row">
            <?php
            if (($hassidepre) && ($regions['layout'] == 1)) {
                echo $OUTPUT->blocks('side-pre', $regions['pre']);
            }?>
            <div id="region-main" class="<?php echo $regions['content']; ?>">
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
            if (($hassidepre) && ($regions['layout'] == 2)) {
                echo $OUTPUT->blocks('side-pre', $regions['pre']);
            }
            if ($hassidepost) {
                echo $OUTPUT->blocks('side-post', $regions['post']);
            }?>
            <?php require_once(\theme_shoehorn\toolbox::get_tile_file('pagebottom')); ?>
        </div>
    </div>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>