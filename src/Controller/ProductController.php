<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use App\Entity\Category;
use App\Form;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;

class ProductController extends Controller
//Todas los metodos relativos a los productos
{
    /**
     * @Route("/product", name="product")
     */
    //Necesitamos añadir el objeto request
    private $category;
    public function index(Request $request)
    {
        $product = new Product();
        $category = new Category();

        //Llamamos a las funciones de doctrine
        $em = $this->getDoctrine()->getManager();
        //creamos un nuevo formulario - Lo ideal es llamarlo desde una clase
        $form = $this->createForm(Form\ProductType::class, $product);

            //metodo handleRequest pasa los datos del formulario a la variable form
            //Despues se obtienen llamando a $form-getData();
        $form->handleRequest($request);
           
        //Comprobamos que el formulario ha sido enviado
        if ($form->isSubmitted() && $form->isValid()) {


        //metemos los datos obtenidos del request en la variable $product
        $product = $form->getData();
        //necesitamos recoger en cada entidad los valores del request tanto en product y en category porque en el type tenemos a las dos entidades
        $category= $form->getData();

        //seteamos el nuevo producto con los datos de la clase product

        $product->setName(strtoupper($product->getName()));
        $product->setPrice($product->getPrice());
        $product->setDescription($product->getDescription());
        //Si queremos utiizar los valores de category en algun render necesitamos setear los valores a la clase sino nos devolvera error null
            $category->setId($category->getId());
            $category->setName($category->getName());
        //Aqui seteamos la categoria en la entidad product, pero el valor que le pasamos es el que recogemos por medio de category//Si no lo hacemos asi nos dara el error de que debe ser una instancia de categoria.

        $product->setCategory($category->getId());

        //utilizamos doctrine para decirle a Doctrine que guarde este producto, esta vez en la BBDD
        $em->persist($product);


      
        //El metodo FLush Es el que realmente ejecuta las consoltas
        $em->flush();
       
       

       
        //devolvemos un mensaje al usuario sobre el producto creado - Lo ideal es redirigir con reditectToRoute('path')
        //Symfony dice que esto se hace para evitar que los usuarios recargen y reenvien el formulario dos veces
        return new Response($product->getName().' Se ha añadido correctamente ID: '.$product->getId(). "<a href='/product/All'>Ver Productos</a>");

    }
    //En caso de no haber enviado ningun formulario, se mostrara el formulario de productos
    return $this->render('default/new.html.twig', array(
        'form'=>$form->createView(),'nombre'=>'Productos'));

    }

    public function showAction()
	{
    $product = $this->getDoctrine()

        ->getRepository(Product::class)
        ->findAll();

    if (!$product) {
        throw $this->createNotFoundException(
            'No product found for id '
        );
    }

    return $this->render ('default/success.html.twig', ['product'=>$product]);
	}

     public function showAll()
    {
        $repositori = $this->getDoctrine()
        ->getRepository(Product::class);

       $products=$repositori->findAll();


       //$categoryName = $product->getCategory()->getName();

    if (!$products) {
        return new Response('La tabla no contiene productos');
       //
    }

    return $this->render ('default/success.html.twig', array('product'=>$products));
    }

    /**
     *
     * @Route("/findById/{id}", name="porid")
     */
    public function showById()
    {
        $repositori = $this->getDoctrine()
            ->getRepository(Product::class);

        $products=$repositori->find(id);


        //$categoryName = $product->getCategory()->getName();

        if (!$products) {
            return new Response('La tabla no contiene productos');
            //
        }

        return $this->render ('default/success.html.twig', array('product'=>$products));
    }

    /**
     * @Route("/product/delete/{id}", name="deleteProduct")
     */
    public function delete($id){
        $em = $this->getDoctrine()->getManager();
        $repositori = $this->getDoctrine()
            ->getRepository(Product::class);
        $products=$repositori->find($id);
        $em->remove($products);
        $em->flush();



        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/product/edit/{id}")
     */
    public function updateAction($id, Request $request)
    {
        //Entity Manager llama a doctrine y manager
        $em = $this->getDoctrine()->getManager();
        //declaramos la variable product y a travez del entity manager hacemos la busqueda por ID
        $product = $em->getRepository(Product::class)->find($id);
        //Creamos un nuevo formulario con la plantilla de Productos
        $form = $this->createForm(Form\ProductType::class, $product);
        //Pasamos los valores capturados en el request a la variable form
        $form->handleRequest($request);
        //ahora capturamos todos los datos del form en una variable
        //debemos capturar los datos para cada entidad utilizada en los formularios
        $product = $form->getData();
        $category = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            //--Ahora podemos utilizar esos datos como mejor nos convenga
            $product->setName(strtoupper($product->getName()));
            $product->setPrice($product->getPrice());
            $product->setDescription($product->getDescription());
            //Si queremos utiizar los valores de category en algun render necesitamos setear los valores a la clase sino nos devolvera error null
            $category->setId($category->getId());
            $category->setName($category->getName());
            //Aqui seteamos la categoria en la entidad product, pero el valor que le pasamos es el que recogemos por medio de category
            //Si no lo hacemos asi nos dara el error de que debe ser una instancia de categoria.

            $product->setCategory($category->getId());


            if (!$product) {
                throw $this->createNotFoundException(
                    'No se ha encontrado un producto con ese id ' . $id
                );
            }

            $em->flush();

            return $this->redirectToRoute('products', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('default/new.html.twig', array(
            'form'=>$form->createView(),'nombre'=>'Actualizar Productos'));

    }






}//