<?php
namespace App\Entity;

// On importe les classes dont on aura besoin
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


// Ici, on fait le pont entre Doctrine et la base de donnée, puis on expose grâce à l'API Platform
#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Patch(),
        new Delete()
    ]
)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // On définit le champs Title, string, de 255 caractères, non null
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    // On définit le champs description, text, qui peut être null grâce à "nullable"
    #[ORM\Column(type: Types::TEXT, nullable: true)] 
    private ?string $description = null;

    // On définit le champs status, string, de 20 caractères, non null, avec 3 valeurs possibles dont "todo" par défaut
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['todo', 'in_progress', 'done'])]
    private ?string $status = 'todo';

    // On définit un attribut pour y assigner la date de création de la tâche
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // Attribution automatique de la date actuelle
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    // Pour la suite, les fonction get* permettent d'obtenir l'élément suivi
    //                             set* permettent de définir l'élément suivi
    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}