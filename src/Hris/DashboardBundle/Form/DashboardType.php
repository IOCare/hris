<?php

namespace Hris\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Hris\DashboardBundle\Form\OrganisationunitToIdTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;

class DashboardType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // assuming $entityManager is passed in options
        $em = $options['em'];
        $transformer = new OrganisationunitToIdTransformer($em);
        $builder
            ->add('name')
            ->add($builder->create('organisationunit','hidden',array(
                    'constraints'=> array(
                        new NotBlank(),
                    ),
                    'mapped'=>False,
                ))->addModelTransformer($transformer)
            )
            ->add('lowerLevels','checkbox',array(
                'required'=>False,
            ))
            ->add('systemWide','checkbox',array(
                'required'=>False,
            ))
            ->add('form','entity', array(
                'class'=>'HrisFormBundle:Form',
                'multiple'=>true,
                'constraints'=>array(
                    new NotBlank(),
                )
            ))
            ->add('fieldOne','entity',array(
                'required'=> True,
                'constraints'=> array(
                    new NotBlank(),
                )
            ))
            ->add('fieldTwo',null,array(
                'required'=>False,
                'constraints'=> array(
                    new NotBlank(),
                )
            ))
            ->add('graphType','choice',array(
                'choices'=>array(
                    'bar'=>'Bar Chart',
                    'line'=>'Line Chart',
                    'pie'=>'Pie Chart'
                ),
                'constraints'=>array(
                    new NotBlank(),
                )
            ))
            ->add('submit','submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(
            array('em')
        );
        $resolver->setAllowedTypes(array(
            'em'=>'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hris_dashboardbundle_dashboardtype';
    }
}
