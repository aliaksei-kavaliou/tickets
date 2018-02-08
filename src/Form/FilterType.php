<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * FilterType
 *
 * @author aliaksei
 */
class FilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('requiredDate', DateType::class, [
            'format' => 'yyyy-MM-dd',
            'label' => 'Required date',
            'required' => false,
            'input' => 'datetime',
            'widget' => 'single_text',
            'html5' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\Model\Form\FilterType::class,
            'csrf_token_id'   => 'filter',
        ]);
    }
}
