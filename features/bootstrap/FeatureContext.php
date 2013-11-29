<?php

use Behat\MinkExtension\Context\MinkContext;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @var Dafiti\Dojo\Github
     */
    private $app;

    /**
     * @var Repositories
     */
    private $repositories;

    /**
     * @Given /^I get app to connect to Github$/
     */
    public function iGetAppToConnectToGithub()
    {
        $this->app = new Dafiti\Dojo\Github;
    }

    /**
     * @When /^I call info for public repositories from "([^"]*)"$/
     */
    public function iCallToGetInfoAboutPublicRepositoriesFrom($user)
    {
        $this->repositories = $this->app->getRepositories($user);
    }


    /**
     * @Then /^I get "([^"]*)" repositorie\(s\)$/
     */
    public function iGetRepositories($qtd)
    {
        if ( $qtd != count($this->repositories) ) {
            throw new LengthException('Repositores Count is not Equals ');
        }
    }

    /**
     * @Given /^repository name is "([^"]*)"$/
     */
    public function repositoryNameIs($name)
    {
        PHPUnit_Framework_Assert::assertEquals($name, $this->repositories[0]['name'], 'Repository name is wrong');
    }

    /**
     * @Then /^I log content page$/
     */
    public function logContent()
    {
        $content = $this->getSession()->getPage()->getContent();
        file_put_contents(__DIR__ . '/../log/debug.log', $content);
    }

    /**
     * Click on the element with the provided xpath query
     *
     * @When /^I follow xpath "([^"]*)"$/
     */
    public function iClickOnElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        );

        if (null === $element) {
            throw new InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        $element->click();
    }
}
