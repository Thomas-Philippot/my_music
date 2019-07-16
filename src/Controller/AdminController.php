<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin_zone")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function admin(EntityManagerInterface $entityManager)
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $medias = $entityManager->getRepository(Media::class)->findAll();
        return $this->render("admin/list.html.twig", [
            'users' => $users,
            'medias' => $medias
        ]);
    }

}