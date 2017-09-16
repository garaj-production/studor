<?php

namespace AppBundle\Form;

use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->remove('username');
        $builder->remove('current_password');

        $builder->add('name');

        $builder->add('avatar', VichImageType::class, [
            'required' => false,
            'image_uri' => true,
            'allow_delete' => false,
            'download_uri' => false,
            'translation_domain' => 'messages',
        ]);
    }

    public function getParent()
    {
        return ProfileFormType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_profile_type';
    }
}
