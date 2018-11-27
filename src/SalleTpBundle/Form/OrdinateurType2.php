<?php

namespace SalleTpBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SalleTpBundle\Repository\SalleRepository;

class OrdinateurType2 extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ip')->add('numero')->add('salle', EntityType::class, ['class' => 'SalleTpBundle:Salle',
            'query_builder' => function(SalleRepository $rep){
            return $rep->createQueryBuilder('s')->where('s.etage <= 1')->orderBy('s.numero', 'ASC');
            }]);
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SalleTpBundle\Entity\Ordinateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'salletpbundle_ordinateur';
    }


}
