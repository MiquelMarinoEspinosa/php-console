<?php

namespace Php\Console\Tests\Acceptance\UserInterface\Command\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class UserContext implements Context
{
    /** @var array */
    private $sources;
    /** @var string */
    private $response;

    public function __construct()
    {
        $this->sources = [];
        $this->response = '';
    }

    /**
     * @Given /^no source$/
     */
    public function noSource()
    {
    }

    /**
     * @Given /^a source$/
     */
    public function aSource(TableNode $table)
    {
        $this->sources = array_column($table->getColumnsHash(), 'source');
    }

    /**
     * @When /^execute the command$/
     */
    public function executeTheCommand()
    {
        $cmd = "php /app/bin/console video:importer " . implode(' ', $this->sources);
        $this->response = shell_exec($cmd);
    }

    /**
     * @Then /^should response with message$/
     */
    public function shouldResponseWithMessage(PyStringNode $string)
    {
        if (trim($string->getRaw()) !== trim($this->response)) {
            $strDiff = strlen(trim($this->response)) - strlen(trim($string->getRaw()));
            if ($strDiff > 1 || $strDiff < -1) {
                throw new \Exception(
                    'Fails to assert the response. ' . PHP_EOL
                    . 'Expected: ' . trim($string->getRaw()) . PHP_EOL
                    . 'Actual: ' . trim($this->response)
                );
            }
        }
    }
}
