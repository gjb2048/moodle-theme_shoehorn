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
$slides = shoehorn_shown_frontpageslides(); // In lib.php.
$slidestoshow = false;
foreach ($slides as $sideid => $shown) {
    if ($shown == 2) {
        $slidestoshow = true;
        break;
    }
}

if ($slidestoshow) {
$speed = (!isset($PAGE->theme->settings->frontpagesliderspeed)) ? 5000 : $PAGE->theme->settings->frontpagesliderspeed;
if ($speed == 0) {
    $speed = '';
}
?>
<div id="frontpageslider" class="carouselslider">
    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="<?php echo $speed?>">
        <ol class="carousel-indicators">
            <?php
            $first = true;
            $fs = 1;
            foreach ($slides as $sideid => $shown) {
                if ($shown == 2) {
            ?>
                    <li data-target="#myCarousel" data-slide-to="<?php echo $fs-1; ?>" <?php if ($first) { echo 'class="active"'; $first = false; } ?>></li>
            <?php
                    $fs++;
                }
            } ?>
        </ol>
        <div class="carousel-inner">
        <?php
            $first = true;
            foreach ($slides as $slideid => $shown) {
                if ($shown == 2) {
                    $urlsetting = 'frontpageslideurl'.$slideid;
                    if (!empty($PAGE->theme->settings->$urlsetting)) {
                        echo '<a href="'.$PAGE->theme->settings->$urlsetting.'" target="_blank"';
                    } else {
                        echo '<div';
                    }
                    echo ' class="';
                    if ($first) { 
                        echo 'active '; 
                        $first = false;
                    }
                    echo 'item">';
                    $imagesetting = 'frontpageslideimage'.$slideid;
                    if (!empty($PAGE->theme->settings->$imagesetting)) {
                        $image = $PAGE->theme->setting_file_url($imagesetting, $imagesetting);
                    } else {
                        $image = $OUTPUT->pix_url('Default_Slide', 'theme');
                    }
                    $slidecaptiontitle = 'frontpageslidecaptiontitle'.$slideid;
                    if (!empty($PAGE->theme->settings->$slidecaptiontitle)) {
                        $imgalt = $PAGE->theme->settings->$slidecaptiontitle;
                    } else {
                        $imgalt = 'No caption title';
                    }
                    ?>
                    <div class="carousel-image-container">
                        <img src="<?php echo $image; ?>" alt="<?php echo $imgalt; ?>" />
                    </div>
                    <?php
                    $slidecaptiontext = 'frontpageslidecaptiontext'.$slideid;
                    if ((!empty($PAGE->theme->settings->$slidecaptiontitle)) || (!empty($PAGE->theme->settings->$slidecaptiontext))) { ?>
                        <div class="carousel-caption">
                        <?php
                            if (!empty($PAGE->theme->settings->$slidecaptiontitle)) { echo '<h4>'.$PAGE->theme->settings->$slidecaptiontitle.'</h4>'; }
                            if (!empty($PAGE->theme->settings->$slidecaptiontext)) { echo '<p>'.$PAGE->theme->settings->$slidecaptiontext.'</p>'; }
                        ?> </div> <?php
                    }
                    if (!empty($PAGE->theme->settings->$urlsetting)) {
                        echo '</a>';
                    } else {
                        echo '</div>';
                    }
                }
            } ?>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <?php if (!right_to_left()) { ?>
            <?php if ($PAGE->theme->settings->fontawesome) { ?>
            <i class="fa fa-chevron-circle-left"></i>
            <?php } else { ?>
            <span class="glyphicon glyphicon-chevron-left"></i>
            <?php } ?>
        <?php } else { ?>
            <?php if ($PAGE->theme->settings->fontawesome) { ?>
            <i class="fa fa-chevron-circle-right"></i>
            <?php } else { ?>
            <span class="glyphicon glyphicon-chevron-right"></i>
            <?php } ?>
        <?php } ?>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <?php if (!right_to_left()) { ?>
            <?php if ($PAGE->theme->settings->fontawesome) { ?>
            <i class="fa fa-chevron-circle-right"></i>
            <?php } else { ?>
            <span class="glyphicon glyphicon-chevron-right"></i>
            <?php } ?>
        <?php } else { ?>
            <?php if ($PAGE->theme->settings->fontawesome) { ?>
            <i class="fa fa-chevron-circle-left"></i>
            <?php } else { ?>
            <span class="glyphicon glyphicon-chevron-left"></i>
            <?php } ?>
        <?php } ?>
        </a>
    </div>
</div>
<?php } ?>
