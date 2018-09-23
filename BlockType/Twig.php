<?php

namespace Opera\TwigBlockBundle\BlockType;

use Opera\CoreBundle\BlockType\BaseBlock;
use Opera\CoreBundle\BlockType\BlockTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Opera\CoreBundle\Entity\Block;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Opera\TwigBlockBundle\Form\TwigType;

class Twig extends BaseBlock implements BlockTypeInterface
{
    public function getType() : string
    {
        return 'twig';
    }

    public function getTemplate(Block $block) : string
    {
        return sprintf('@OperaTwigBlock/blocks/%s.html.twig', $this->getType());
    }

    public function createAdminConfigurationForm(FormBuilderInterface $builder)
    {
        $builder->add('code', TwigType::class, [
            'attr' => [
                'rows' => 20,
            ],
        ]);    
    }

    public function configure(NodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('code')->defaultValue('')->end()
            ->end();
    }
}