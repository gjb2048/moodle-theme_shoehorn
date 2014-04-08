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
class theme_shoehorn_core_renderer extends theme_bootstrap_core_renderer {

    /**
     * Gets HTML for the page heading.
     *
     * @param string $tag The tag to encase the heading in. h1 by default.
     * @return string HTML.
     */
    public function page_heading($tag = 'h1') {
        $o = '';

        $logo = $this->page->theme->setting_file_url('logo', 'logo');
        if (!is_null($logo)) {
            $o .= html_writer::empty_tag('img', array('src' => $logo, 'alt' => get_string('logo', 'theme_shoehorn'), 'class' => 'logo'));
            $o .= html_writer::tag($tag, $this->page->heading, array('class' => 'logoheading'));
        } else {
            $o .= parent::page_heading($tag);
        }
        return $o;
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (right_to_left()) {
            $dividericon = 'fa-angle-left';
        } else {
            $dividericon = 'fa-angle-right';
        }
        $divider = html_writer::tag('span', html_writer::start_tag('i', array('class' => 'fa '. $dividericon .' fa-lg')) .
                        html_writer::end_tag('i'), array('class' => 'divider'));
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $list_items = html_writer::start_tag('li') . implode("$divider" . html_writer::end_tag('li') .
                        html_writer::start_tag('li'), $breadcrumbs) . html_writer::end_tag('li');
        $title = html_writer::tag('span', get_string('pagepath'), array('class' => 'accesshide'));
        return $title . html_writer::tag('ul', "$list_items", array('class' => 'breadcrumb'));
    }

    function footer_menu() {
        $o = '';
        $items = array();

        // Footer menu setting.
        if (!empty($this->page->theme->settings->footermenu)) {
            $lang = current_language();
            $lines = explode("\n", $this->page->theme->settings->footermenu);

            foreach ($lines as $line) {
                $line = trim($line);
                $bits = explode('|', $line, 4); // name|url|title|lang
                if ((!empty($bits[3]) or (array_key_exists(3, $bits)))) {
                    if ($bits[3] !== $lang) {
                        continue;
                    }
                }
                $title = '';
                if ((!empty($bits[2]) or (array_key_exists(2, $bits)))) {
                    $title = $bits[2];
                }

                if (strstr($bits[1], '[[site]]')) {
                    // If URL has the '[[site]]' tag, then replace with moodle_url for the site....
                    $bits[1] = str_replace('[[site]]', '', $bits[1]);  // Strip....
                    $thispageurl = new moodle_url($bits[1]);
                    $bits[1] = $thispageurl->out();
                }
                $items[] = html_writer::tag('a', $bits[0], array('href' => $bits[1], 'title' => $title));
            }
        }

        // Site page setting.
        $pages = shoehorn_shown_sitepages(); // lib.php.
        $loggedin = isloggedin();
        $sesskey = sesskey();
        foreach($pages as $pageid => $status) {
            if ($status == 2) {
                $url = new moodle_url('/theme/shoehorn/pages/sitepage.php');
                $url->param('pageid', $pageid);
                if ($loggedin) {
                    $url->param('sesskey', $sesskey);
                }
                $url = preg_replace('|^https?://|i', '//', $url->out(false));
                $sitepagetitle = 'sitepagetitle'.$pageid;
                $items[] .= html_writer::tag('a', $this->page->theme->settings->$sitepagetitle, array('href' => $url, 'class' => 'sitepagelink'));
            }
        }

        // Copyright setting.
        if (!empty($this->page->theme->settings->copyright)) {
            $items[] .= html_writer::tag('span', ' '.$this->page->theme->settings->copyright.' '.userdate(time(), '%Y'), array('class' => 'copyright'));
        }

        if (count($items) > 0) {
            $o = html_writer::start_tag('div', array('id' => 'footermenu'));
            if (count($items) == 1) {
                $o .= $items[0];
            } else {
                /* $divider = html_writer::tag('span', html_writer::start_tag('i', array('class' => 'fa fa-arrows-h fa-lg')) .
                                html_writer::end_tag('i'), array('class' => 'divider')); */
                $divider = html_writer::tag('span', '|', array('class' => 'divider'));
                $o .= implode("$divider", $items);
            }
            $o .= html_writer::end_tag('div');
        }

        return $o;
    }

    // Page bottom block region.
    /**
     * Get the HTML for blocks for region page-bottom.
     *
     * @return string HTML.
     */
    public function shoehorn_pagebottom_block() {
        $region = 'page-bottom';
        $classes = array();
        $classes[] = 'block-region';
        $classes[] = 'col-md-12';
        $editing = $this->page->user_is_editing();

        $attributes = array(
            'id' => 'block-region-' . preg_replace('#[^a-zA-Z0-9_\-]+#', '-', $region),
            'class' => join(' ', $classes),
            'data-blockregion' => $region,
            'data-droptarget' => '1'
        );

        $output = html_writer::start_tag('aside', $attributes);
        $output .= html_writer::start_tag('div', array('class' => 'row'));

        $region = $this->page->apply_theme_region_manipulations($region);
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);

        $blockcount = count($blockcontents);

        if ($blockcount >= 1) {
            $blocks = $this->page->blocks->get_blocks_for_region($region);
            $lastblock = null;
            $zones = array();
            foreach ($blocks as $block) {
                $zones[] = $block->title;
            }

            $blocksperrow = $this->page->theme->settings->numpagebottomblocks;
            // When editing we want all the blocks to be the same.
            if (($blocksperrow > 4) || ($editing)) {
                $blocksperrow = 4; // Will result in a 'col-sm-3 col-md-3 col-lg-3'.
            }
            $rows = $blockcount / $blocksperrow; // Maximum blocks per row.

            if (!$editing) {
                if ($rows <= 1) {
                    $col = 12 / $blockcount;
                    if ($col < 1) {
                        // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                        $col = 1;
                    }
                } else {
                    $col = 12 / $blocksperrow;
                }
            } else {
                $col = 3;
            }

            $currentblockcount = 0;
            $currentrow = 0;
            $currentrequiredrow = 1;
            foreach ($blockcontents as $bc) {
                if (!$editing) { // When not editing use rows to break up the blocks.
                    $currentblockcount++;
                    if ($currentblockcount > ($currentrequiredrow * $blocksperrow)) {
                        // Tripping point.
                        $currentrequiredrow++;
                        // Break...
                        $output .= html_writer::end_tag('div');
                        $output .= html_writer::start_tag('div', array('class' => 'row'));
                        // Recalculate col if needed...
                        $remainingblocks = $blockcount - ($currentblockcount - 1);
                        if ($remainingblocks < $blocksperrow) {
                            $col = 12 / $remainingblocks;
                            if ($col < 1) {
                                // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                                $col = 1;
                            }
                        }
                    }

                    if ($currentrow < $currentrequiredrow) {
                        $currentrow = $currentrequiredrow;
                    }
                }
                //$bc->attributes['class'] .= ' col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col;

                $output .= html_writer::start_tag('div', array('class' => 'col-sm-'.$col.' col-md-'.$col.' col-lg-'.$col));
                if ($bc instanceof block_contents) {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                } else if ($bc instanceof block_move_target) {
                    $output .= $this->block_move_target($bc, $zones, $lastblock);
                } else {
                    throw new coding_exception('Unexpected type of thing (' . get_class($bc) . ') found in list of block contents.');
                }
                $output .= html_writer::end_tag('div');
            }
        }

        $output .= html_writer::end_tag('div'); // row.
        $output .= html_writer::end_tag('aside');
        return $output;
    }
}
