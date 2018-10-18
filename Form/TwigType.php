<?php

namespace Opera\TwigBlockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Opera\TwigBlockBundle\Serializer\ModelSerializer;

class TwigType extends AbstractType
{
    private $modelSeralizer;

    public function __construct(ModelSerializer $modelSeralizer)
    {
        $this->modelSeralizer = $modelSeralizer;
    }

    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\TextareaType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        parent::buildView($view, $form, $options);
        if ($form->getParent() && $form->getParent()->getParent()) {
            $block = $form->getParent()->getParent()->getData();

            if ($block && isset($block->getConfiguration()['doc'])) {
                $view->vars = array_merge($view->vars, array(
                    'vars' => $this->modelSeralizer->getTwigBlockDoc($block),
                ));
            }
        }
    }

}