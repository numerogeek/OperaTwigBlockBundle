<?php

namespace Opera\TwigBlockBundle\BlockType;

use Opera\CoreBundle\BlockType\BaseBlock;
use Opera\CoreBundle\BlockType\BlockTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Opera\CoreBundle\Entity\Block;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Opera\TwigBlockBundle\Form\TwigType;
use Opera\CoreBundle\BlockType\CacheableBlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Twig\Environment;
use Opera\TwigBlockBundle\Serializer\ModelSerializer;

class Twig extends BaseBlock implements BlockTypeInterface, CacheableBlockInterface
{
    private $twigEnvironment;
    private $modelSeralizer;

    public function __construct(Environment $twigEnvironment, ModelSerializer $modelSeralizer)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->modelSeralizer = $modelSeralizer;
    }

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
        $builder->add('twig', TwigType::class, [
            'attr' => [
                'rows' => 20,
            ],
        ])
        -> add('code', HiddenType::class, [
            'attr' => [
                'class' => 'hidden_code'
            ]
        ]);
    }

    public function configure(NodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('code')->defaultValue('')->end()
                ->scalarNode('twig')->defaultValue('')->end()
                ->arrayNode('doc')
                    ->treatNullLike(array())
                    ->prototype('array')
                        ->children()
                            ->scalarNode('entity')->end()
                            ->scalarNode('type')->end()
                            ->arrayNode('groups')
                                ->scalarPrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->end()
                ->end()
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