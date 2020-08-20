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
 *  tool_sumitnegi main output
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_sumitnegi\output;
use tool_sumitnegi\output\displayinfo_table as displayinfo_table;
use renderer_base;
/**
 *  tool_sumitnegi main output
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements \renderable, \templatable{
    /**
     * @var courseid
     */
    protected $courseid;

    /**
     * main constructor.
     * @param int $courseid
     */
    public function __construct($courseid) {
        $this->courseid = $courseid;
    }

    /**
     * Return final data to render
     * @param renderer_base $output
     * @return array|\stdClass
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function export_for_template(renderer_base $output) {
        // TODO: Implement export_for_template() method.
        $course = get_course($this->courseid);
        $coursecontext = \context_course::instance($course->id);
        $data = [];
        $data['coursename'] = $course->fullname;
        if (has_capability('tool/sumitnegi:edit', $coursecontext)) {
            $data['addentrylink'] = $output->single_button(new \moodle_url('/admin/tool/sumitnegi/edit.php',
                ['courseid' => $course->id]), get_string('add'), 'GET');
        }
        $table = new displayinfo_table("tool_sumitnegi", $course->id);
        $table->define_baseurl(new \moodle_url('/admin/tool/sumitnegi/index.php', ['courseid' => $course->id]));
        ob_start();
        $table->out(50, true);
        $data['contents'] = ob_get_contents();
        ob_clean();
        return $data;
    }


}