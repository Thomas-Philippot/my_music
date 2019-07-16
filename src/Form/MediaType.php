<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = $options['categories'];
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('link', FileType::class, [
                'label' => 'media',
                'attr' => ['class' => 'input-field'],
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'audio/mp3',
                            'audio/mpeg',
                            'video/mp4',
                        ],
                        'mimeTypesMessage' => 'Veuillez envoyer un fichier au format mp3 ou mp4',
                    ])
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur'
            ])
            ->add('cover', FileType::class, [
                'label' => 'Pochette',
                'attr' => ['class' => 'input-field'],
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '500K',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez envoyer un fichier au format png ou jpeg',
                    ])
                ]
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Categorie',
                'translation_domain' => 'validators',
                'choices' => $categories,
                'choice_label' => 'name'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'categories' => null
        ]);
    }
}
