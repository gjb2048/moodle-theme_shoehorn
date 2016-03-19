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
?>
<nav role="navigation" class="<?php echo implode(' ', $settingshtml->navbarclass); ?>">
    <div class="<?php echo $settingshtml->containerclass; ?>">
    <div class="navbar-header navbar-left">
        <?php
        echo $OUTPUT->navbar_items();
        echo $OUTPUT->navbar_button();
        ?>
    </div>

    <div id="moodle-navbar" class="navbar-collapse collapse navbar-right">
        <ul class="nav navbar-nav">
        <?php echo $OUTPUT->custom_menu(); ?>        
        <?php echo $OUTPUT->user_menu(); ?>
        <?php echo $OUTPUT->page_heading_menu(); ?>
        </ul>
    </div>
    </div>
</nav>
