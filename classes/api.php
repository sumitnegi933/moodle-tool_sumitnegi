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
     * @return void
     */
    public static function add(\stdClass $data) {
        global $DB;
        return $DB->insert_record('tool_sumitnegi', $data);
    }
    /**
     * Update existing record
     *
     * @param stdClass $data
     * @return void
     */
    public static function update(\stdClass $data) {
        global $DB;
        return $DB->update_record('tool_sumitnegi', $data);
    }
    /**
     * Delete record from the table
     *
     * @param int $deleteid
     * @return void
     */
    public static function remove(int $deleteid) {
        global $DB;
        return $DB->delete_records('tool_sumitnegi', ['id' => $deleteid]);
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
}