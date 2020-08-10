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
 * lib file
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Extend the course navigation
 * 
 * @param navigation_node $parentnode
 * @param stdClass $course
 * @param context_course $context
 * @return void
 */
function tool_sumitnegi_extend_navigation_course(navigation_node $parentnode, stdClass $course, context_course $context) {
    $url = new moodle_url('/admin/tool/sumitnegi/index.php', array('id' => $course->id));
    $name = get_string('pluginname', 'tool_sumitnegi');
    $parentnode->add($name, $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('icon', '', 'tool_sumitnegi'));
}