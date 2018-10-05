<?php

namespace Opera\TwigBlockBundle\BlockType;

use Opera\CoreBundle\BlockType\BaseBlock;
use Opera\CoreBundle\BlockType\BlockTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Opera\CoreBundle\Entity\Block;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Opera\TwigBlockBundle\Form\TwigType;
use Opera\CoreBundle\BlockType\CacheableBlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Twig extends BaseBlock implements BlockTypeInterface, CacheableBlockInterface
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
        $builder->add('code', TextareaType::class, [
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

    public function getCacheConfig(OptionsResolver $resolver, Block $block)
    {
        $resolver->setDefaults([
            // Set your configs for cache
            'vary' => 'cookie',
            // 'expires_after' => \DateInterval::createFromDateString('1 hour'),
        ]);
    }
}