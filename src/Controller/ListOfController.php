<?php

namespace App\Controller;

use App\Entity\ListOf;
use App\Form\ListOfType;
use App\Repository\ListOfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/list/of')]
class ListOfController extends AbstractController
{
    #[Route('/', name: 'list_of_index', methods: ['GET'])]
    public function index(ListOfRepository $listOfRepository): Response
    {
        return $this->render('list_of/index.html.twig', [
            'list_ofs' => $listOfRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'list_of_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listOf = new ListOf();
        $form = $this->createForm(ListOfType::class, $listOf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listOf);
            $entityManager->flush();

            return $this->redirectToRoute('list_of_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('list_of/new.html.twig', [
            'list_of' => $listOf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_of_show', methods: ['GET'])]
    public function show(ListOf $listOf): Response
    {
        return $this->render('list_of/show.html.twig', [
            'list_of' => $listOf,
        ]);
    }

    #[Route('/{id}/edit', name: 'list_of_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListOf $listOf, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListOfType::class, $listOf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('list_of_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('list_of/edit.html.twig', [
            'list_of' => $listOf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_of_delete', methods: ['POST'])]
    public function delete(Request $request, ListOf $listOf, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listOf->getId(), $request->request->get('_token'))) {
            $entityManager->remove($listOf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_of_index', [], Response::HTTP_SEE_OTHER);
    }
}
