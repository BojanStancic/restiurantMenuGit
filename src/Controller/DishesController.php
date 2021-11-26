<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Form\DishType;
use App\Repository\DishesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/dishes', name: 'dishes.')]

class DishesController extends AbstractController
{
    #[Route('/', name: 'edit')]
    public function index(DishesRepository $dishesRepository): Response
    {

        $dishes = $dishesRepository->findAll();

        return $this->render('dishes/index.html.twig', [
            'dishes' => $dishes
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request){
        
        $dish = new Dishes();
        
        //Form
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $image = $request->files->get('dish')['attachment'];
            // $image = $form->get('attachment')->getData();

            if ($image) {
                $filename = md5(uniqid()) . '.' . $image->guessClientExtension();
                $image->move(
                    $this->getParameter('images_folder'), 
                    $filename
                );

            $dish->setImage($filename);
            $em->persist($dish);
            $em->flush();
            }

            

            return $this->redirect($this->generateUrl('dishes.edit'));
        }

        

        //Response
        return $this->render('dishes/create.html.twig', [
            'createForm' => $form->createView()
        ]);

    }


    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, DishesRepository $dishesRepository) {


        $em = $this->getDoctrine()->getManager();

        $dish = $dishesRepository->find($id);
        $em->remove($dish);
        $em->flush();

        //message
        $this->addFlash('success', 'Dish was deleted successfully!');

        return $this->redirect($this->generateUrl('dishes.edit'));
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Dishes $dishes) {
        return $this->render('dishes/show.html.twig', [
            'dishes' => $dishes
        ]);

    }
    
} 
