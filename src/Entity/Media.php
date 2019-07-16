<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="le nom ne peut être vide")
     * @Assert\Length(
     *     min="5", minMessage="le nom doit faire plus de 5 caractère",
     *     max="50", maxMessage="le nom ne doit pas faire plus de 50 caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @Assert\NotBlank(message="l'auteur ne peut être vide")
     * @Assert\Length(
     *     min="5", minMessage="l'auteur doit faire plus de 5 caractère",
     *     max="50", maxMessage="l'auteur ne doit pas faire plus de 50 caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="medias")
     */
    private $category;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink(string $link)
    {
        $this->link = $link;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function setCover(string $cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Media
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
        return $this;
    }

}
