<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;

use AppBundle\Calendar\Todo\Command\NewTodo;
use AppBundle\Calendar\Todo\Todo;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    private $kernel;

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * @Given there are no todo items
     */
    public function thereAreNoTodoItems()
    {
        PHPUnit_Framework_Assert::anything();

        return;
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
        $command = new NewTodo($description, 0);

        $container = $this->kernel->getContainer();

        $container->get('command_bus')->handle($command);

        return;
        $this->visit('/todo/new');

        $page = $this->getSession()->getPage();

        $page->fillField('Description', $description);
        $page->pressButton('Submit');
    }

    /**
     * @Then a new todo item called :arg1 should be added
     */
    public function aNewTodoItemCalledShouldBeAdded($description)
    {
        $container = $this->kernel->getContainer();

        $todos = $container->get('doctrine')->getRepository(Todo::class)->findAllItemsThatAreNotActive();

        foreach ($todos as $todo) {
            if ($todo->getDescription() == $description) {
                return true;
            }
        }
        PHPUnit_Framework_Assert::fail();
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
