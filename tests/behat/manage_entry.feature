@tool @tool_sumitnegi
Feature: My first behat test with the plugin
  As teacher I will be able to add new entry in my tool

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |

    And the following "courses" exist:
      | fullname | shortname |
      | SC       | SC        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | SC     | editingteacher |

  @javascript
  Scenario: Add / Edit Entry
    When I log in as "teacher1"
    And I am on "SC" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    And I click on "Add" "button"
    And I set the following fields to these values:
      | Name      | Behat entry 1 |
      | Completed | 0             |
    And I press "Save changes"
    And I click on "Edit" "link" in the "Behat entry 1" "table_row"
    And I set the following fields to these values:
      | Completed | 1 |
    And I press "Save changes"
    And I log out

  @javascript
  Scenario: Delete Entry
    When I log in as "teacher1"
    And I am on "SC" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    And I click on "Add" "button"
    And I set the following fields to these values:
      | Name      | Behat entry 1 |
      | Completed | 0             |
    And I press "Save changes"
    And I click on "Delete" "link" in the "Behat entry 1" "table_row"
    And I should not see "Behat entry 1"
    And I log out
