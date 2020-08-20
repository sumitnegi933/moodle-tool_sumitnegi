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
 * sumitnegi tool locallib
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_sumitnegi;
defined('MOODLE_INTERNAL') || die;

/**
 * sumitnegi tool locallib
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class api {
    /**
     * Add record to table
     *
     * @param stdClass $data
     * @return int
     */
    public static function add(\stdClass $data) {
        global $DB, $PAGE;
        $entry = new \stdClass();
        $entry->name = $data->name;
        $entry->completed = $data->completed ?? 0;
        $entry->courseid = $data->courseid;
        $entry->timecreated = time();
        $entry->timemodified = time();
        if (isset($data->description)) {
            $entry->description = $data->description;
            $entry->descriptionformat = 1;
        }
        if ($entryid = $DB->insert_record('tool_sumitnegi', $entry)) {
            $context = \context_course::instance($data->courseid);
            $upateentry = new \stdClass();
            $upateentry->id = $entryid;
            if (!empty($data->description_editor)) {
                $data = file_postupdate_standard_editor($data, 'description', self::editor_options(),
                    $context, 'tool_sumitnegi', 'entry', $entryid);
                $upateentry->description = $data->description;
                $upateentry->descriptionformat = 1;
                self::update($upateentry, true);
            }
            return $entryid;
        }
        return 0;
    }

    /**
     * Update record
     *
     * @param \stdClass $data
     * @param false $skipdescription
     * @return bool
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public static function update(\stdClass $data, $skipdescription = false) {
        global $DB;
        if (!$data->id) {
            print_error("Data must have id in order to update");
        }
        if (!$skipdescription) {
            $entry = new \stdClass();
            $entry->id = $data->id;
            $entry->name = $data->name;
            $entry->completed = $data->completed ?? 0;
            $entry->timemodified = time();
            if (isset($data->description)) {
                $entry->description = $data->description;
                $entry->descriptionformat = 1;
            } else if (!empty($data->description_editor)) {
                $context = \context_course::instance($data->courseid);
                $data = file_postupdate_standard_editor($data, 'description', self::editor_options(),
                    $context, 'tool_sumitnegi', 'entry', $data->id);
                $entry->description = $data->description;
                $entry->descriptionformat = 1;
            }
        } else {
            $entry = new \stdClass();
            $entry = $data;
        }
        return $DB->update_record('tool_sumitnegi', $entry);
    }

    /**
     * Delete record from the table
     *
     * @param int $deleteid
     * @return void
     */
    public static function remove(int $deleteid) {
        global $DB;
        $DB->delete_records('tool_sumitnegi', ['id' => $deleteid]);
    }

    /**
     * get record from the table
     *
     * @param int $id
     * @return object
     */
    public static function get(int $id) {
        global $DB;
        return $DB->get_record('tool_sumitnegi', ['id' => $id], '*', IGNORE_MISSING);
    }

    /**
     * Description format options
     *
     * @return array
     */
    public static function editor_options() {
        global $PAGE;
        return [
            'maxfiles' => -1,
            'maxbytes' => 0,
            'context' => $PAGE->context,
            'noclean' => true,
            'format' => 1
        ];
    }
}