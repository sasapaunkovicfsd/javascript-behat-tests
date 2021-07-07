<?php

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{

    /**
     * @Then I wait for the page to load :arg1 element
     */
    public function iWaitForThePageToLoadElement($arg1)
    {
        $this->getSession()->wait(10000, 'jQuery("' . $arg1 . '").is(":visible") === true');
    }

    /**
     * @Then I pause
     */
    public function iPause()
    {
        $this->getSession()->wait(3000);
    }

    /**
     * @Then I click the :arg1 element
     */
    public function iClickTheElement($arg1)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('named', array('content', $arg1));
        if (empty($element)) {
            throw new Exception("No html element found for the selector ('$arg1')");
        }
        $element->click();
    }

    /**
     * @Then /^I click the "([^"]*)" link$/
     */
    public function iClickTheLink($arg1)
    {
        $page = $this->getSession()->getPage();
        $link = $page->findLink($arg1);
        if (null === $link) {
            throw new \Exception('The link $arg1 is not found');
        }
        $link->click();
    }

    /**
     * adds a breakpoints
     * stops the execution until you hit enter in the console
     * @Then /^breakpoint/
     */
    public function breakpoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while (fgets(STDIN, 1024) == '') {
        }
        fwrite(STDOUT, "\033[u");
        return;
    }

    /**
     * @Then /^I enter "([^"]*)" with "([^"]*)"$/
     * @throws ElementNotFoundException
     */
    public function iEnterWith($arg1, $arg2)
    {
        $page = $this->getSession()->getPage();

        $form = $page->find('css', 'form');
        if (null === $form) {
            throw new \Exception('The element is not found');
        }

        $input = $form->findField($arg1);
        if (null === $input) {
            throw new \Exception('The element is not found');
        }
        $input->focus();

        //not working ??
        //$page->fillField($arg1, $arg2);
        $xpath = $input->getXpath();
        $driver = $this->getSession()->getDriver();
        $this->getSession()->wait(500);
        $this->getSession()
            ->executeScript("jQuery('input[name=" . $arg1 . "]').val('" . $arg2 . "')[0].dispatchEvent(new Event('input'));");
        $this->getSession()->wait(500);
    }

    /**
     * @Then /^I wait for the page to show "([^"]*)"$/
     */
    public function iWaitForThePageToShow($arg1)
    {
        $page = $this->getSession()->getPage();
        $page->waitFor(5000,
            function () use ($page, $arg1) {
                return $page->find('named', array('content', $arg1))->isVisible();
            }
        );
    }

    public function spin(callable $lambda, $wait = 5)
    {
        $lastErrorMessage = '';

        for ($i = 0; $i < $wait; $i++) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
                $lastErrorMessage = $e->getMessage();
            }

            sleep(1);
        }


        throw new ElementNotVisible('The element is not visible ' . $lastErrorMessage);
    }

    /**
     * @Then /^I wait for the page to show "([^"]*)" if not click "([^"]*)"$/
     */
    public function iWaitForThePageToShowIfNotClick($arg1, $arg2)
    {
        $page = $this->getSession()->getPage();
        $page->waitFor(5000,
            function () use ($page, $arg1, $arg2) {
                if (!$page->find('named', array('content', $arg1))->isVisible())
                    $page->pressButton($arg2);
            }
        );
    }

    /**
     * @Then /^if I see "([^"]*)" I should press "([^"]*)" "([^"]*)"$/
     */
    public function ifISeeIShouldPress($arg1, $arg2, $arg3)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('named', array('content', $arg1));

        if (null === $element)
            return;

        if($arg2 == 'link')
            $page->clickLink($arg3);
        elseif ($arg2 == 'button')
            $page->pressButton($arg3);
    }

}