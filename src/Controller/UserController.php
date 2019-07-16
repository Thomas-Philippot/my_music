<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Entity\User;
use App\Form\RoleType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashed = $encoder->encodePassword($user, $user->getPassword());
            $avatar = $em->getRepository(Avatar::class)->find($request->get('avatar'));

            $user->setPassword($hashed);
            $user->setAvatar($avatar);
            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush();

            $this->addFlash('script', "<script>M.toast({html: 'Compte crée avec succès'})</script>");
            return $this->redirectToRoute('home');
        }
        $avatars = $em->getRepository(Avatar::class)->findAll();

        return$this->render("pages/register.html.twig", array(
            'form' => $form->createView(),
            'avatars' => $avatars
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render("pages/login.html.twig", []);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/admin/delete_user/{id}", name="delete_user")
     * @param User $id
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(User $id, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($id);
        $entityManager->flush();
        $this->addFlash('script', "<script>M.toast({html: 'Utilisateur supprimmé avec succès'})</script>");
        return $this->redirectToRoute('admin_zone');
    }

    /**
     * @Route("/admin/edit_user/{id}", name="edit_user")
     * @param Request $request
     * @param User $id
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function edit(Request $request, User $id, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(RoleType::class, $id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($id);
            $entityManager->flush();
            $this->addFlash('script', "<script>M.toast({html: 'Utilisateur modifié avec succès'})</script>");
            return $this->redirectToRoute('home');
        }
        return $this->render("admin/edit_user.html.twig", [
            'user' => $id,
            'form' => $form->createView(),
        ]);
    }

}