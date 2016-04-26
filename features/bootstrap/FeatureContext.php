<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given there are no todo items
     */
    public function thereAreNoTodoItems()
    {
        $this->visit('/api/todo/todo');

        $content = $this->getSession()->getPage()->getContent();

        PHPUnit_Framework_Assert::assertJson($content);
        PHPUnit_Framework_Assert::assertEmpty(json_decode($content));
    }

    /**
     * @When I add a new todo item with description :description
     */
    public function iAddANewTodoItemWithDescription($description)
    {
        $this->visit('/todo/new');

        $page = $this->getSession()->getPage();

        $page->fillField('Description', $description);
        $page->pressButton('Submit');
    }

    /**
     * @Then a new todo item called :arg1 should be added
     */
    public function aNewTodoItemCalledShouldBeAdded($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then no item should be added
     */
    public function noItemShouldBeAdded()
    {
        throw new PendingException();
    }

    /**
     * @Then I should get an error with :arg1
     */
    public function iShouldGetAnErrorWith($arg1)
    {
        throw new PendingException();
    }

    /**
     * @BeforeScenario
     */
    public function clearDatabase()
    {
    }
}
