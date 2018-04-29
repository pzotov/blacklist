<?php

namespace tests\models;

use app\models\Blacklist;

class BlacklistTest extends \Codeception\Test\Unit
{
    public function testFindItemById()
    {
        expect_that($item = Blacklist::findOne(12));
        expect($item->last_name)->equals('Иванов');
        
        expect_not($item = Blacklist::findOne(1));
    }
	
    public function testSetBirthdate()
    {
    	$item = new Blacklist();
    	$item->birthDate = '12.04.2018';
        expect($item->birthdate)->equals('2018-04-12');
    }

}
