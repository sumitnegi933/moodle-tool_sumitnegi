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
 *  tool_sumitnegi.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
use tool_sumitnegi\output;
global $DB, $PAGE, $OUTPUT;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
require_login();
$coursecontext = context_course::instance($courseid);
require_capability('tool/sumitnegi:view', $coursecontext);
$url = new moodle_url('/admin/tool/sumitnegi/index.php', ['courseid' => $courseid]);
$PAGE->set_context($coursecontext);
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('title', 'tool_sumitnegi'));
$PAGE->set_heading(get_string('pluginname', 'tool_sumitnegi'));
$data = new tool_sumitnegi\output\main($courseid);
$output = $PAGE->get_renderer('tool_sumitnegi');
echo $output->header();
echo $output->render($data);
echo $output->footer();