<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\DataTransformer\DateTransformer;

class PeriodType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('startDate', 'date', array(
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid startdate',
                'html5' => true,
                'input'  => 'datetime',
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text' ))
            ->add('endDate', 'date', array(
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid enddate',
                'html5' => true,
                'input'  => 'datetime',
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text' ))
            ->add('draft',  'checkbox', array(
                'label'    => 'Draft',
                'required' => false))
            ->add('contact');
        
            //$builder->get('startDate')->addModelTransformer();
            $builder->get('endDate')->addModelTransformer(new DateTransformer());
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Period'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_period';
    }
}
