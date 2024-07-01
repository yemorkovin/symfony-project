<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MyController extends AbstractController
{
    #[Route('/my', name: 'app_my')]
    public function index(): Response
    {
        echo 1;
        exit;
        return $this->render('my/index.html.twig', [
            'controller_name' => 'MyController',
        ]);
    }
    #[Route('/my1', name: 'app_my')]
    public function my1(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setName('Product Name');
        $product->setPrice(19);
        $entityManager->persist($product);
        $entityManager->flush();
        return $this->render('my/index.html.twig', [
            'controller_name' => 'MyController', 'id_product' => $product->getId(),
        ]);
    }

    #[Route('/product/{id}', name: 'productid')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return new Response('Product name: ' . $product->getName());
    }


    #[Route('/product/update/{id}', name: 'product_update')]
    public function update($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $product->setName('Updated Product Name');
        $entityManager->flush();

        return new Response('Updated product with id ' . $product->getId());
    }
 
    #[Route('/product/delete/{id}', name: 'product_delete')]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response('Deleted product with id ' . $product->getId());
    }



}
