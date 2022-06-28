<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/ShowP", name="show_product")
     */
public function showP(ProductRepository $rep):Response{
    $prod=new Product();
    $em=$this->getDoctrine()->getManager();
    $prod=$rep->findAll();
    dd($prod);
}

    /**
     * @Route("/DeleteP/{id}", name="delete_product")
     */
    public function deleteP(ProductRepository $rep,$id):Response{
        $prod=new Product();
        $em=$this->getDoctrine()->getManager();
        $prod=$rep->find($id);
        $em->remove($prod);
        $em->flush();
        dd($prod);

    }

    /**
     * @Route("/InsertP", name="insert_product")
     */
    public function insertP(ProductRepository $rep, Request $request):Response{
        $prod=new Product();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(ProductType::class,$prod);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($prod);
            $em->flush();

        }
        return $this->render('product/insert.html.twig', [
            'form' => $form->createView(),
        ]);


    }






    /**
     * @Route("/UpdateP/{id}", name="update_product")
     */
    public function updateP(ProductRepository $rep,$id, Request $request):Response{
        $prod=new Product();
        $em=$this->getDoctrine()->getManager();
        $prod=$rep->find($id);

        $form=$this->createForm(ProductType::class,$prod);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em->flush();

        }
        return $this->render('product/insert.html.twig', [
            'form' => $form->createView(),
        ]);


    }









}
