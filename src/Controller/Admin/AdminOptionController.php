<?php
namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("/admin/option")
 */
class AdminOptionController extends AbstractController
{

    /**
     *@return \Symfony\Component\HttpFoundation\Response
     *@Route("/", name="admin.option.index", methods="GET|POST")
     */
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render("admin/option/index.html.twig", [
            "options" => $optionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.option.new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();


            return $this->redirectToRoute("admin.option.index");
        }

        return $this->render("admin/option/new.html.twig", [
            "option" => $option,
            "form" => $form->createView(),
        ]);
    }


    /**
     *@param Request $request
     *@param Property $property
     *@Route("/{id}/edit", name="admin.option.edit", methods="GET|POST")
     *@return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function edit(Request $request, Option $option): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("admin.option.index");
        }

        return $this->render("admin/option/edit.html.twig", [
            "option" => $option,
            "form" => $form->createView(),
        ]);
    }

    /**
     *@Route("/{id}", name="admin.option.delete", methods="DELETE")
     *@param Property $property
     *@return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Request $request, Option $option): Response
    {
        if ($this->isCsrfTokenValid("admin/delete".$option->getId(), $request->request->get(".token"))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
        }

        return $this->redirectToRoute("admin.option.index");
    }
}
