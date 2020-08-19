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
 * upgrade tool_sumitnegi.
 *
 * @package   tool_sumitnegi
 * @copyright 2020, Sumit Negi
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Upgrade plugin function
 *
 * @param [type] $oldversion
 * @return void
 */
function xmldb_tool_sumitnegi_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2020080701) {
        // Define table tool_sumitnegi to be created.
        $table = new xmldb_table('tool_sumitnegi');

        // Adding fields to table tool_sumitnegi.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('completed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table tool_sumitnegi.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for tool_sumitnegi.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Sumitnegi savepoint reached.
        upgrade_plugin_savepoint(true, 2020080701, 'tool', 'sumitnegi');
    }
    if ($oldversion < 2020080702) {

         // Define key foreign (foreign) to be added to tool_sumitnegi.
        $table = new xmldb_table('tool_sumitnegi');
        $key = new xmldb_key('coursefrkey', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);

        // Launch add key foreign.
        $dbman->add_key($table, $key);

          // Define index nameandcourse (unique) to be added to tool_sumitnegi.
        $table = new xmldb_table('tool_sumitnegi');
        $index = new xmldb_index('nameandcourse', XMLDB_INDEX_UNIQUE, ['courseid', 'name']);

        // Conditionally launch add index nameandcourse.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Sumitnegi savepoint reached.
        upgrade_plugin_savepoint(true, 2020080702, 'tool', 'sumitnegi');
    }

    if ($oldversion < 2020081900) {
        // Define field description to be added to tool_sumitnegi.
        $table = new xmldb_table('tool_sumitnegi');
        $field = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null, 'priority');

        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Define field descriptionformat to be added to tool_sumitnegi.
        $table = new xmldb_table('tool_sumitnegi');
        $field = new xmldb_field('descriptionformat', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'description');

        // Conditionally launch add field descriptionformat.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Sumitnegi savepoint reached.
        upgrade_plugin_savepoint(true, 2020081900, 'tool', 'sumitnegi');
    }

    return true;
}
