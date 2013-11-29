<?php

namespace Dafiti\Dojo;

use Github\Client;

class Github
{
    private $client;

    public function __construct($client = null)
    {
        if ( !$client ) {
            $client = new Client;
        }
        $this->client = $client;
    }

    /**
     * @When /^I call api to get repositories from "([^"]*)"$/
     */
    public function getRepositories($user)
    {
        return $this->client->api('user')->repositories($user);
    }
}