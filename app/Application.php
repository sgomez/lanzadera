<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 5/09/14
 * Time: 13:45
 */

use Symfony\Bundle\FrameworkBundle\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function getDefaultCommands()
    {
        $commands = array();

        if (in_array($this->getKernel()->getEnvironment(), array('dev', 'test'))) {
            $commands[] = new \Stecman\Component\Symfony\Console\BashCompletion\CompletionCommand();
        }

        return array_merge(parent::getDefaultCommands(), $commands);
    }
} 