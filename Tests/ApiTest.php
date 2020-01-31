<?php

set_include_path(__DIR__ . '/../Classes/');
spl_autoload_register();
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    /**
     * @throws Exception
     * Tests whether the API call returns a successful response
     * We cannot rely on the status code as it still returns 200 with an error so have to check for the `error` property in the object
     * Test should always pass due to the retry delay that was implemented
     */
    public function testApiCall()
    {
        $api = new Api('someapikey');
        $list = $api->apiCall('/list');
        $this->assertObjectNotHasAttribute('error', $list) && $this->assertNotEmpty($list);
    }
}
