<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_index')]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'Productes',
            'products' => $repository->findAll(),
        ]);
    }

    #[Route('/products/{id<\d+>}', name: 'product_show')]
    public function show(Product $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/products/new}', name: 'products_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product;

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Producte creat correctament'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('products/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/products/{id}<\d+>/edit}', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Producte editat correctament'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('products/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/products/{id}<\d+>/delete}', name: 'product_delete')]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {

            $entityManager->remove($product);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Producte eliminat correctament'
            );

            return $this->redirectToRoute('products_index');
        }

        return $this->render('products/delete.html.twig', [
            'id' => $product->getId(),
        ]);
    }
}
