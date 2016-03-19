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
$slides = \theme_shoehorn\toolbox::shown_frontpageslides();

$slidestoshow = false;
foreach ($slides as $sideid => $shown) {
    if ($shown == 2) {
        $slidestoshow = true;
        break;
    }
}

if ($slidestoshow) {
    $speed = \theme_shoehorn\toolbox::get_setting('frontpagesliderspeed', 5000);
    if ($speed == 0) {
        $speed = '';
    }
?>
<div id="frontpageslider" class="carouselslider">
    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="<?php echo $speed?>">
        <?php
        echo '<ol class="carousel-indicators">';
        $first = true;
        $fs = 1;
        foreach ($slides as $sideid => $shown) {
            if ($shown == 2) {
                echo '<li data-target="#myCarousel" data-slide-to="';
                echo $fs - 1;
                echo '"';
                if ($first) {
                    echo 'class="active"';
                    $first = false;
                }
                echo '></li>';
                $fs++;
            }
        }
        echo '</ol>';
        echo '<div class="carousel-inner">';
        $first = true;
        foreach ($slides as $slideid => $shown) {
            if ($shown == 2) {
                $urlsetting = \theme_shoehorn\toolbox::get_setting('frontpageslideurl'.$slideid);
                if ($urlsetting) {
                    echo '<a href="'.$urlsetting.'" target="_blank"';
                } else {
                    echo '<div';
                }
                echo ' class="';
                if ($first) {
                    echo 'active ';
                    $first = false;
                }
                echo 'item">';
                $imagesetting = \theme_shoehorn\toolbox::get_setting('frontpageslideimage'.$slideid);
                if ($imagesetting) {
                    $image = \theme_shoehorn\toolbox::setting_file_url('frontpageslideimage'.$slideid,
                        'frontpageslideimage'.$slideid);
                } else {
                    $image = \theme_shoehorn\toolbox::pix_url('Default_Slide', 'theme');
                }
                $slidecaptiontitle = \theme_shoehorn\toolbox::get_setting('frontpageslidecaptiontitle'.$slideid);
                if ($slidecaptiontitle) {
                    $imgalt = $slidecaptiontitle;
                } else {
                    $imgalt = 'No caption title';
                }
                echo '<div class="carousel-image-container">';
                echo '<img src="'.$image.'" alt="'.$imgalt.'">';
                echo '</div>';
                $slidecaptiontext = \theme_shoehorn\toolbox::get_setting('frontpageslidecaptiontext'.$slideid);
                if ($slidecaptiontitle || $slidecaptiontext) {
                    echo '<div class="carousel-caption">';
                    if ($slidecaptiontitle) {
                        echo '<h4>'.$slidecaptiontitle.'</h4>';
                    }
                    if ($slidecaptiontext) {
                        echo '<p>'.$slidecaptiontext.'</p>';
                    }
                    echo '</div>';
                }
                if ($urlsetting) {
                    echo '</a>';
                } else {
                    echo '</div>';
                }
            }
        }
        echo '</div>';
        echo '<a class="left carousel-control" href="#myCarousel" data-slide="prev">';
        $fontawesome = \theme_shoehorn\toolbox::get_setting('fontawesome');
        if (!right_to_left()) {
            if ($fontawesome) {
                echo '<span aria-hidden="true" class="fa fa-chevron-circle-left"></span>';
            } else {
                echo '<span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>';
            }
        } else {
            if ($fontawesome) {
                echo '<span aria-hidden="true" class="fa fa-chevron-circle-right"></span>';
            } else {
                echo '<span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>';
            }
        }
        echo '</a>';
        echo '<a class="right carousel-control" href="#myCarousel" data-slide="next">';
        if (!right_to_left()) {
            if ($fontawesome) {
                echo '<span aria-hidden="true" class="fa fa-chevron-circle-right"></span>';
            } else {
                echo '<span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>';
            }
        } else {
            if ($fontawesome) {
                echo '<span aria-hidden="true" class="fa fa-chevron-circle-left"></span>';
            } else {
                echo '<span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>';
            }
        }
        echo '</a>';
        ?>
    </div>
</div>
<?php
}
