Feature: Creating new todo items
  In order to see what needs to be done
  As a user
  I need to be able to create new todo items

  Scenario: Add new todo item with a description
    Given there are no todo items
    When I add a new todo item with description "Finish writing a book"
    Then a new todo item called "Finish writing a book" should be added

  Scenario: Add new todo item without a description
    Given there are no todo items
    When I add a new todo item with description ""
    Then no item should be added
    And I should get an error with "The description is required"