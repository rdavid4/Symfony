<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(Form\CategoryType::class);
        $form->handleRequest($request);

        //Comprobamos que el formulario ha sido enviado
        if ($form->isSubmitted() && $form->isValid()) {
            //metemos los datos obtenidos del request en la variable $product
            /** @var TYPE_NAME $category */
            $category = $form->getData();
            //seteamos el nuevo producto con los datos de la clase product
            $category->setName(strtoupper($category->getName()) );

            //utilizamos doctrine para decirle a Doctrine que guarde este producto, esta vez en la BBDD
            $em->persist($category);
            //El metodo FLush Es el que realmente ejecuta las consoltas
            $em->flush();

            return new Response($category->getName().' Se ha añadido correctamente ID: '.$category->getId());
        }
            
            return $this->render('default/new.html.twig', array(
        'form' => $form->createView(), 'nombre'=>'Categorias'));


    }
    public function showAll(){
        $repositori = $this->getDoctrine()->getRepository(Category::class);
        $category = $repositori->findAll();
        if (!$category) {
            return new Response('La tabla no contiene categorias');
            //
        }

        return $this->render ('default/categorias.html.twig', array('category'=>$category));
    }

    /**
     * @Route("/category/delete/{id}", name="deleteCategory")
     */
    public function delete($id){
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
            ->getRepository(Category::class);
        $categories=$repository->find($id);
        $em->remove($categories);
        $em->flush();



        return $this->redirectToRoute('category');
    }


}
