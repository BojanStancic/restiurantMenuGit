<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchiveController extends AbstractController
{
    #[Route('/archive', name: 'archive')]
    public function index(OrderRepository $orderRepository): Response
    {
        $archive = $orderRepository->findBy([
            'status' => 'archive'
        ]);


        return $this->render('archive/index.html.twig', [
            'archive' => $archive
        ]);
    }

    #[Route('/removeArchived/{id}', name: 'removeArchived')]
    public function deleteArchived($id, OrderRepository $orderRepository) {


        $em = $this->getDoctrine()->getManager();

        $order = $orderRepository->find($id);
        $em->remove($order);
        $em->flush();

        return $this->redirect($this->generateUrl('archive'));
    }
}
