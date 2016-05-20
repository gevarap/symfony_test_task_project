<?php

namespace SysTech\TestTaskBundle\Form\Db2;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\VarDumper\VarDumper;

class SkuStockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('skuId', EntityType::class, array(
              'class' => 'BaseSynchronizeBundle:Sku',
              'em' => 'db2',
              'label' => 'Sku Name',
            ))
            ->add('stock')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SysTech\TestTaskBundle\Entity\Db2\SkuStock'
        ));
    }
}
