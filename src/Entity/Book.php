<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $title = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $enabled = null;

    #[ORM\Column(type: 'boolean')]
    private $published = true; // valeur par défaut

    // Getter
    public function getPublished(): ?bool
    {
    return $this->published;
    }

    // Setter
    public function setPublished(bool $published): self{
    $this->published = $published;
    return $this;
    }

    #[ORM\Column(type: 'string', length: 255)]
    private $category;
    // Getter
    public function getCategory(): ?string
    {
        return $this->category;
    }

    // Setter
    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

     // Relation ManyToOne avec Author
    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(nullable: false)] // l'auteur est obligatoire pour un livre
    private $author;
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

   public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    public function getEnabled(): ?int
    {
        return $this->enabled;
    }

    public function setEnabled(?int $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }



    
}
