<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Description of PictureType
 *
 * @author Administrateur
 */
class PictureType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder->add('path', FileType::class, array('label' => 'Image'));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class'=>Picture::class));
    }
}
