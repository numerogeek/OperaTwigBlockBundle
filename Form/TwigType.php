<?php

namespace Opera\TwigBlockBundle\Form;

use Symfony\Component\Form\AbstractType;

class TwigType extends AbstractType
{
    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\TextareaType::class;
    }
}