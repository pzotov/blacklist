<?php

namespace tests\models;

use app\models\Text;

class TextTest extends \Codeception\Test\Unit
{
    public function testFindTextById()
    {
        expect_that($text = Text::get(2));
        expect($text)->equals('text2');
        
        expect_not($text = Text::get(3));
    }

}
