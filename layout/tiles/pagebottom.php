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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$knownregionpagebottom = $PAGE->blocks->is_known_region('page-bottom');
if ($knownregionpagebottom) {
?>
<div class="row">
    <?php
    echo $OUTPUT->shoehorn_pagebottom_block();
    ?>
</div>
<?php
}
?>
<div class="row">
<div id="page-info" class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4 panel panel-default">
    <div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
    <p class="helplink"><?php echo $OUTPUT->page_doc_link(); ?></p>
    <?php
    if ($PAGE->pagelayout != 'login') {
        echo $OUTPUT->login_info();
    }
    echo $OUTPUT->standard_footer_html();
    ?>
</div>
</div>
