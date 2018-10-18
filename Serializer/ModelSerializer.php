<?php

namespace Opera\TwigBlockBundle\Serializer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\PropertyInfo\Type;
use Nelmio\ApiDocBundle\Model\Model;
use Metadata\MetadataFactory;
use Doctrine\Common\Annotations\Reader;
use EXSyst\Component\Swagger\Schema;
use Nelmio\ApiDocBundle\Model\ModelRegistry;
use Nelmio\ApiDocBundle\ModelDescriber\JMSModelDescriber;
use EXSyst\Component\Swagger\Swagger;
use Opera\CoreBundle\Entity\Block;

class ModelSerializer
{
    private $factory;
    private $doctrineReader;
    private $modelDescriber;

    public function __construct(MetadataFactory $factory, Reader $reader, JMSModelDescriber $modelDescriber)
    {
        $this->factory = $factory;
        $this->doctrineReader = $reader;
        $this->modelDescriber = $modelDescriber;
    }

    public function serialize(string $className, array $serializedGroups = null)
    {
        $type = new Type('object', false, $className);
        $model = new Model($type, $serializedGroups ?? []);
        $schema = new Schema();
        $schema->setType('object');

        $swagger = new Swagger();
        $modelRegistry = new ModelRegistry($this->modelDescriber, $swagger, []);

        $this->modelDescriber->setModelRegistry($modelRegistry); // weird stuff


        $this->modelDescriber->describe($model, $schema);

        return $schema->getProperties();
    }

    public function getTwigBlockDoc(Block $block)
    {
        if (!$block || !isset($block->getConfiguration()['doc'])) {
            return [];
        }

        $doc = $block->getConfiguration()['doc'];

        foreach($doc as $key => $value) {
            if (isset($value['entity'])) {
                $model = $this->serialize($value['entity'], isset($value['groups']) ? $value['groups'] : null);
                $doc[$key]['model'] = $model;
            }
        }

        return $doc;
    }
}