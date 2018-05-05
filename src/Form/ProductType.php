<?php
// src/Form/ProductType.php
namespace App\Form;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Product;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
        ->add('name', TextType::class, array('label' => 'Nombre: '))
        ->add('price', NumberType::class, array('label' => 'Precio: '))
        ->add('description', TextareaType::class, array('label' => 'Descripcion: '))
            ->add('id', EntityType::class, array('label'=> 'Categoria',
                // looks for choices from this entity
                'class' => Category::class,
                //Aqui se ha de poner una propiedad (campo de la tabla) de la clase por ejemplo nombre (de la categoria)
                'choice_label' => 'name',
            ))
        ->add('save', SubmitType::class, array('label' => 'Añadir'))
        ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class));
    }

}