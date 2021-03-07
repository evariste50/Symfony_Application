<?php
namespace App\Controller\Admin;


use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\AdminPropertyController;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController{


    /**
     * @var PropertyRepository
     */

     private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em=$em;
    }

    /**
     *@Route("/admin", name="admin.property.index")
     *@return \Symfony\Component\HttpFoundation\Response
     */ 
    public function index(){

        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }


    /**
     *@Route("admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
    $property = new Property();
    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request); 

    if ($form->isSubmitted() && $form->isValid()){

        $this->em->persist($property);
        $this->em->flush();
        $this->addFlash('success', 'Bien creer avec Succes');
        return $this->redirectToRoute('admin.property.index');

   }
   return $this->render('admin/property/new.html.twig', [
    'property' => $property,
    'form' => $form->createView()
]);


    }


    /**
     *@param Request $request
     *@param Property $property
     *@Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     *@return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function edit(Property $property, Request $request)
    {

        //permet Ajouter un nouveau bien a la fonction edit 
        // $option = new Option();
        // $property->addOption($option);
        
        $form = $this->createForm(PropertyType::class, $property);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

             $this->em->flush();
             $this->addFlash('success', 'Bien Modifié avec Succes');
             return $this->redirectToRoute('admin.property.index');

        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);


    }


    /**
     *@Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     *@param Property $property
     *@return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property,Request $request)
    {

          if($this->isCsrfTokenValid('delete'. $property->getId() ,  $request->get('_token')))
          {
              
          $this->em->remove( $property);
          $this->em->flush();
          $this->addFlash('success', 'Bien supprimmer avec Succes');
          
          }
          return $this->redirectToRoute('admin.property.index');
    }
    
}



