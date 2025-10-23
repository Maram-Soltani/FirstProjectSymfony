<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $enabled = null;

    #[ORM\Column(type: 'boolean')]
    private bool $published = true;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $category = null;

    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    //  Ajout du champ Ref
    #[ORM\Column(type: 'string', length: 50, unique: true)]
private ?string $ref = null;



    // ----------- GETTERS & SETTERS -----------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
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

    public function setEnabled(?int $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;
        return $this;
    }

    // Nouveau champ Ref
    
public function getRef(): ?string
{
    return $this->ref;
}

public function setRef(string $ref): self
{
    $this->ref = $ref;
    return $this;
}

}
