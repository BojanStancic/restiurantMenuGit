<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findBy(
            ['tableNo' => 'tableNo1']
        );

        return $this->render('order/index.html.twig', [
            'orders' => $order
        ]);
    }


    #[Route('/orders/{id}', name: 'orders')]
    public function orders(Dishes $dishes): Response
    {

        $order = new Order();
        $order->setTableNo('tableNo1');
        $order->setName($dishes->getName());
        $order->setOrderNo($dishes->getId());
        $order->setPrice($dishes->getPrice());
        $order->setStatus('open');

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        $this->addFlash('orders', $order->getName() . ' was added to do order');

        return $this->redirect($this->generateUrl('menu'));


    }

    #[Route('/status/{id},{status}', name: 'status')]
    public function status($id, $status)
    {

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->find($id);

        $order->setStatus($status);
        $em->flush();

        return $this->redirect($this->generateUrl('order'));

    }

    #[Route('/remove/{id}', name: 'remove')]
    public function delete($id, OrderRepository $orderRepository) {


        $em = $this->getDoctrine()->getManager();

        $order = $orderRepository->find($id);
        $em->remove($order);
        $em->flush();

        return $this->redirect($this->generateUrl('order'));
    }
}
