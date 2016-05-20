<?php

namespace SysTech\TestTaskBundle\Form\Common;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Doctrine\DBAL\Connection;
use Symfony\Component\VarDumper\VarDumper;

class TableRelationsType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('sourceTable')
          ->add('targetTable')
          ->add('sourceEntity')
          ->add('targetEntity')
          ->add('sourceField')
          ->add('targetField')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SysTech\TestTaskBundle\Entity\CommonDb\TableRelations'
        ));
    }
}
