<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
        return $this->render( 'user/list.html.twig', ['users' => $this->getDoctrine()->getRepository( 'AppBundle:User' )->findAll()] );
    }

    /**
     * @Route("/users/create", name="user_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm( UserType::class, $user );
        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get( 'app.user_manager' )->createUser( $user );

            $this->addFlash( 'success', "L'utilisateur a bien été ajouté." );

            return $this->redirectToRoute( 'user_list' );
        }

        return $this->render( 'user/create.html.twig', ['form' => $form->createView()] );
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(User $user, Request $request)
    {
        // On vérifie que l'utilisateur dispose bien du rôle ROLE_ADMIN
        $this->denyAccessUnlessGranted( 'ROLE_ADMIN' );

        $form = $this->createForm( UserType::class, $user );

        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get( 'app.user_manager' )->editUser( $user );

            return $this->redirectToRoute( 'user_list' );
        }

        return $this->render( 'user/edit.html.twig', ['form' => $form->createView(), 'user' => $user] );
    }
}
