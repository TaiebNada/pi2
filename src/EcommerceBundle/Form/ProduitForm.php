<?php

namespace EcommerceBundle\Form;

use EcommerceBundle\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProduitForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('categorie',ChoiceType::class, array('label' => 'Type',
                'choices' => array('Animal' =>'animaux',
                'Nutrition animaux' =>'nutrition',
                    'Accessoires animaux' =>'accessoire',
                    'Hygiene animaux'=>'hygiene'),
                'required'=>true))
            ->add('prix',TextType::class)
            ->add('quantiteStock',IntegerType::class)
            ->add('image', FileType::class, array(
                'data_class' => null))
            ->setMethod('POST')
            ->add('Ajouter',SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {$resolver->setDefaults(array(
        'data_class' => Produit::class,
    ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecommerce_produit';
    }


}