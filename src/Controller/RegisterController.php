<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $registrationForm = $this->createFormBuilder()
            ->add('username', TextType::class, [
                    'label' => 'Employee'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Retype Password']
            ])

            ->add('register', SubmitType::class)
            ->getForm()
        ;

        $registrationForm->handleRequest($request);

        if($registrationForm->isSubmitted()) {

            $input = $registrationForm->getData();

            $user = new User();
            $user->setUsername($input['username']);

            $user->setPassword(
                $passwordHasher -> hashPassword($user, $input['password'])
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));


        }

        return $this->render('register/index.html.twig', [
            'registrationForm' => $registrationForm->createView()
        ]);
    }
}
