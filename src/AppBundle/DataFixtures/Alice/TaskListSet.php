<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 06/04/15
 * Time: 04:42
 */

namespace AppBundle\DataFixtures\Alice;


use h4cc\AliceFixturesBundle\Fixtures\FixtureSet;

class TaskListSet extends FixtureSet
{
    public function __construct( array $options = array() )
    {
        $options = array(
            'locale' => 'es_ES',
            'do_drop' => true,
            'do_persist' => true,
        );

        parent::__construct( $options );

        $this->addFile(__DIR__.'/orm/taxonomy.yml', 'yaml');
        $this->addFile(__DIR__.'/orm/user.yml', 'yaml');
        $this->addFile(__DIR__.'/orm/classification.yml', 'yaml');
        $this->addFile(__DIR__.'/orm/organization.yml', 'yaml');
    }
}

return new TaskListSet();