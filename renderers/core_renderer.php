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

include_once($CFG->dirroot . "/theme/bootstrap/renderers/core_renderer.php");

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

    public function custom_menu($custommenuitems = '') {
        /* The custom menu is always shown, even if no menu items
           are configured in the global theme settings page. */
        global $CFG;

        if (!empty($CFG->custommenuitems)) {
            $custommenuitems .= $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    protected function render_custom_menu(custom_menu $menu) {
        global $CFG, $USER;

        /* TODO: eliminate this duplicated logic, it belongs in core, not
                 here. See MDL-39565. */

        $content = html_writer::start_tag('ul', array('class' => 'nav navbar-nav'));
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }
        $content .= html_writer::end_tag('ul');

        return $content;
    }

    public function user_menu() {
        global $CFG;
        $usermenu = new custom_menu('', current_language());
        return $this->render_user_menu($usermenu);
    }

    protected function render_user_menu(custom_menu $menu) {
        global $CFG, $USER, $DB;

        $addusermenu = true;
        $addlangmenu = true;
        $addmessagemenu = true;

        if (!isloggedin() || isguestuser()) {
            $addmessagemenu = false;
        }

        if ($addmessagemenu) {
            $messages = $this->get_user_messages();
            $messagecount = 0;
            foreach ($messages as $message) {
                if (!$message->from) { // Workaround for issue #103.
                    continue;
                }
                $messagecount++;
            }
            $messagemenutext = $messagecount . ' ';
            if ($messagecount == 1) {
                 $messagemenutext .= get_string('message', 'message');
            } else {
                 $messagemenutext .= get_string('messages', 'message');
            }
            $messagemenu = $menu->add(
                $messagemenutext,
                new moodle_url('/message/index.php', array('viewing' => 'recentconversations')),
                get_string('messages', 'message'),
                9999
            );
            foreach ($messages as $message) {
                if (!$message->from) { // Workaround for issue #103.
                    continue;
                }
                $senderpicture = new user_picture($message->from);
                $senderpicture->link = false;
                $senderpicture = $this->render($senderpicture);

                $messagecontent = $senderpicture;
                $messagecontent .= html_writer::start_span('msg-body');
                $messagecontent .= html_writer::start_span('msg-title');
                $messagecontent .= html_writer::span($message->from->firstname . ': ', 'msg-sender');
                $messagecontent .= $message->text;
                $messagecontent .= html_writer::end_span();
                $messagecontent .= html_writer::start_span('msg-time');
                $messagecontent .= html_writer::tag('i', '', array('class' => 'icon-time'));
                $messagecontent .= html_writer::span($message->date);
                $messagecontent .= html_writer::end_span();

                $messageurl = new moodle_url('/message/index.php', array('user1' => $USER->id, 'user2' => $message->from->id));
                $messagemenu->add($messagecontent, $messageurl, $message->text);
            }
        }

        $langs = get_string_manager()->get_list_of_translations();
        if (count($langs) < 2
        or empty($CFG->langmenu)
        or ($this->page->course != SITEID and !empty($this->page->course->lang))) {
            $addlangmenu = false;
        }

        if ($addlangmenu) {
            $language = $menu->add(get_string('language'), new moodle_url('#'), get_string('language'), 10000);
            foreach ($langs as $langtype => $langname) {
                $language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }

        if ($addusermenu) {
            if (isloggedin()) {
                $usermenu = $menu->add(fullname($USER), new moodle_url('#'), fullname($USER), 10001);
                $usermenu->add(
                    '<span class="glyphicon glyphicon-off"></span>' . get_string('logout'),
                    new moodle_url('/login/logout.php', array('sesskey' => sesskey(), 'alt' => 'logout')),
                    get_string('logout')
                );

                $usermenu->add(
                    '<span class="glyphicon glyphicon-user"></span>' . get_string('viewprofile'),
                    new moodle_url('/user/profile.php', array('id' => $USER->id)),
                    get_string('viewprofile')
                );

                $usermenu->add(
                    '<span class="glyphicon glyphicon-cog"></span>' . get_string('editmyprofile'),
                    new moodle_url('/user/edit.php', array('id' => $USER->id)),
                    get_string('editmyprofile')
                );
            } else {
                $usermenu = $menu->add(get_string('login'), new moodle_url('/login/index.php'), get_string('login'), 10001);
            }
        }

        $content = html_writer::start_tag('ul', array('class' => 'nav navbar-nav navbar-right'));
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }
        $content .= html_writer::end_tag('ul');

        return $content;
    }

    protected function process_user_messages() {

        $messagelist = array();

        foreach ($usermessages as $message) {
            $cleanmsg = new stdClass();
            $cleanmsg->from = fullname($message);
            $cleanmsg->msguserid = $message->id;

            $userpicture = new user_picture($message);
            $userpicture->link = false;
            $picture = $this->render($userpicture);

            $cleanmsg->text = $picture . ' ' . $cleanmsg->text;

            $messagelist[] = $cleanmsg;
        }

        return $messagelist;
    }

    protected function get_user_messages() {
        global $USER, $DB;
        $messagelist = array();

        $newmessagesql = "SELECT id, smallmessage, useridfrom, useridto, timecreated, fullmessageformat, notification
                            FROM {message}
                           WHERE useridto = :userid";

        $newmessages = $DB->get_records_sql($newmessagesql, array('userid' => $USER->id));

        foreach ($newmessages as $message) {
            $messagelist[] = $this->shoehorn_process_message($message);
        }

        $showoldmessages = (empty($this->page->theme->settings->showoldmessages)) ? 0 : $this->page->theme->settings->showoldmessages;
        if ($showoldmessages) {
            $maxmessages = 5;
            $readmessagesql = "SELECT id, smallmessage, useridfrom, useridto, timecreated, fullmessageformat, notification
                                 FROM {message_read}
                                WHERE useridto = :userid
                             ORDER BY timecreated DESC
                                LIMIT $maxmessages";

            $readmessages = $DB->get_records_sql($readmessagesql, array('userid' => $USER->id));

            foreach ($readmessages as $message) {
                $messagelist[] = $this->shoehorn_process_message($message);
            }
        }

        return $messagelist;

    }

    protected function shoehorn_process_message($message) {
        global $DB;
        $messagecontent = new stdClass();

        if ($message->notification) {
            $messagecontent->text = get_string('unreadnewnotification', 'message');
        } else {
            if ($message->fullmessageformat == FORMAT_HTML) {
                $message->smallmessage = html_to_text($message->smallmessage);
            }
            if (core_text::strlen($message->smallmessage) > 15) {
                $messagecontent->text = core_text::substr($message->smallmessage, 0, 15).'...';
            } else {
                $messagecontent->text = $message->smallmessage;
            }
        }

        if ((time() - $message->timecreated ) <= (3600 * 3)) {
            $messagecontent->date = format_time(time() - $message->timecreated);
        } else {
            $messagecontent->date = userdate($message->timecreated, get_string('strftimetime', 'langconfig'));
        }

        $messagecontent->from = $DB->get_record('user', array('id' => $message->useridfrom));
        return $messagecontent;
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
