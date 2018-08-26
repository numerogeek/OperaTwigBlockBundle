<?php

namespace Opera\TwigBlockBundle\Tests\BlockType;

use Opera\CoreBundle\Tests\TestCase;
use Opera\TwigBlockBundle\BlockType\Twig;

class TwigTest extends TestCase
{
    public function testGetType()
    {
        $blockType = new Twig();

        $this->assertEquals('twig', $blockType->getType());
    }
}