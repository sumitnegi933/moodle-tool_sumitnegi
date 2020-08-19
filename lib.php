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
    if (has_capability('tool/sumitnegi:view', $context)) {
        $url = new moodle_url('/admin/tool/sumitnegi/index.php', array('courseid' => $course->id));
        $name = get_string('pluginname', 'tool_sumitnegi');
        $parentnode->add($name, $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('icon', '', 'tool_sumitnegi'));
    }
}

/**
 * Serve the embedded files.
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param context $context the context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if the file not found, just send the file otherwise and do not return anything
 */
function tool_sumitnegi_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options) {
    // Check the contextlevel is as expected.
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'tool_sumitnegi') {
        return false;
    }

    // Make sure the user is logged and course access.
    require_login($course, false);

    // Check the relevant capabilities - these may vary depending on the filearea being accessed.
    if (!has_capability('tool/sumitnegi:view', $context)) {
        return false;
    }

    $itemid = array_shift($args); // The first item in the $args array.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'tool_sumitnegi', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false; // The file does not exist.
    }

    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering.
    send_stored_file($file, 86400, 0, $forcedownload, $options);
}
