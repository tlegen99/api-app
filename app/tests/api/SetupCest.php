<?php


namespace Api;

use \ApiTester;

class SetupCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testCodeceptionSetup(ApiTester $I) {

        $I->assertTrue(true);
    }
}
