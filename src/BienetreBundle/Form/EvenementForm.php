<?php

namespace BienetreBundle\Form;


use BienetreBundle\Entity\Evenement;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class EvenementForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEvenement',TextType::class)
            ->add('themeEvenement',TextType::class)
            ->add('lieuEvenement',TextType::class)
            ->add('nbrMAXParticipant',TextType::class)
            ->add('dateEvenement',DateType::class)
            ->add('heureEvenement',TimeType::class)
        ->add('imageEvenement', FileType::class ,array('data_class' => null,'required' => false ,'label' => 'Brochure (PDF file)'))

            ->add('descriptionEvenement',TextareaType::class)
            ->setMethod('POST')
            ->add('Ajouter',SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    { $resolver->setDefaults(array(
        'data_class' => 'BienetreBundle\Entity\Evenement',
    ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bienetre_modele';
    }


}