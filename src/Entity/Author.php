<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $username = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column(type: 'integer')]
    private ?int $nb_books=0;

    // Relation OneToMany avec Book
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class, cascade: ['remove'], orphanRemoval: true)]
    private $books;
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /** @return Collection|Book[] */
    public function getBooks(): Collection
    {
        return $this->books;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNbBooks(): ?int
    {
       return $this->nb_books;
    }

    public function setNbBooks(int $nb_books): self
    {
        $this->nb_books = $nb_books;
        return $this;
    }

     // Ajout d’un livre à l’auteur
    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthor($this);
        }
        return $this;
    }

    // Retrait d’un livre
    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }
        return $this;
    }

}
