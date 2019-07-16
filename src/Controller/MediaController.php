<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Media;
use App\Form\MediaType;
use App\Util\UploadUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends Controller
{

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/music", name="music")
     */
    public function music(EntityManagerInterface $entityManager)
    {
        $list = $entityManager->getRepository(Media::class)->getMusic();
        return $this->render("pages/music.html.twig", [
            'list' => $list
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/video", name="video")
     */
    public function video(EntityManagerInterface $entityManager)
    {
        $list = $entityManager->getRepository(Media::class)->getVideo();
        return $this->render("pages/video.html.twig", [
            'list' => $list
        ]);
    }

    /**
     * @param Media $id
     * @return Response
     * @Route("/video/{id}", name="details")
     */
    public function displayVideo(Media $id)
    {
        return $this->render("pages/details.html.twig", [
            'media' => $id
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/podcast", name="podcast")
     */
    public function podcast(EntityManagerInterface $entityManager)
    {
        $list = $entityManager->getRepository(Media::class)->getPodcast();
        return $this->render("pages/podcast.html.twig", [
            'list' => $list
        ]);
    }

    /**
     * @Route("/admin/add_media", name="add_media")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UploadUtil $util
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager, UploadUtil $util)
    {
        $media = new Media();
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $form = $this->createForm(MediaType::class, $media, ['categories' => $categories]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mediaFile = $form['link']->getData();
            if ($mediaFile) {
                $mediaDir = $this->getParameter('media_dir');
                $newLink = $util->upload($mediaFile, $mediaDir);
                $media->setLink($newLink);
            }

            $mediaCover = $form['cover']->getData();
            if ($mediaCover) {
                $coverDir = $this->getParameter('pochette_dir');
                $newLink = $util->upload($mediaCover, $coverDir);
                $media->setCover($newLink);
            }

            $entityManager->persist($media);
            $entityManager->flush();
            $this->addFlash('script', "<script>M.toast({html: 'Media ajouté avec succès'})</script>");
            return $this->redirectToRoute('home');
        }
        return $this->render("admin/add_media.html.twig", [
            'media' => $media,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete_media/{id}", name="delete_media")
     * @param Media $id
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Media $id, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($id);
        $entityManager->flush();
        $this->addFlash('script', "<script>M.toast({html: 'Media supprimmé avec succès'})</script>");
        return $this->redirectToRoute('admin_zone');
    }

}