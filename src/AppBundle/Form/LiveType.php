<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\DataTransformer\DateTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LiveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, array(
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid startdate',
                'html5' => true,
                'input'  => 'datetime',
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text' ))
            ->add('endDate',  DateType::class, array(
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid enddate',
                'html5' => true,
                'input'  => 'datetime',
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text' ))
            ->add('draft',  CheckboxType::class, array(
                'label'    => 'Draft',
                'required' => false))
            ->add('member')
            ->add('people', EntityType::class, array(
                'class' => 'AppBundle:Person',
                'multiple' => true,
                'required' => false,
                'choice_label' => function ($person) {
                    return $person->getFirstName() ." ". $person->getSurname() . " (" . $person->getAddress() . ")";
                }));


            //$builder->get('startDate')->addModelTransformer();
            $builder->get('endDate')->addModelTransformer(new DateTransformer());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Live'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_live';
    }
}
