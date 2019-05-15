<?php

namespace Php\Console\Tests\Acceptance\UserInterface\Command\User\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class UserContext implements Context
{
    /** @var array */
    private $name;
    /** @var string */
    private $response;

    public function __construct()
    {
        $this->name = '';
        $this->response = '';
    }

    /**
     * @Given /a user name "([^"]*)"$/
     */
    public function aUserName($name)
    {
        $this->name = $name;
    }

    /**
     * @When /^execute the command$/
     */
    public function executeTheCommand()
    {
        $cmd = "php /app/bin/console user:create " . $this->name;
        $this->response = shell_exec($cmd);
    }

    /**
     * @Then /^should response with message$/
     */
    public function shouldResponseWithMessage(PyStringNode $string)
    {
        if (false === strpos($this->response, $string->getRaw())) {
            throw new \Exception(
                'Fails to assert the response. ' . PHP_EOL
                . 'Expected included: ' . trim($string->getRaw()) . PHP_EOL
                . 'Actual: ' . trim($this->response)
            );
        }
    }
}
