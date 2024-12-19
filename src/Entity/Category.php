<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Broadcast]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $icon = null;

    #[ORM\Column(length: 20)]
    #[Assert\Regex("/^#[0-9a-f]{6}$/i")]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $ownerFamily = null;

    /**
     * @var Collection<int, TasksFeed>
     */
    #[ORM\OneToMany(targetEntity: TasksFeed::class, mappedBy: 'category')]
    private Collection $tasksFeeds;

    /**
     * @var Collection<int, TasksPool>
     */
    #[ORM\OneToMany(targetEntity: TasksPool::class, mappedBy: 'Category')]
    private Collection $tasksPools;

    public function __construct()
    {
        $this->tasksFeeds = new ArrayCollection();
        $this->tasksPools = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOwnerFamily(): ?Family
    {
        return $this->ownerFamily;
    }

    public function setOwnerFamily(?Family $ownerFamily): static
    {
        $this->ownerFamily = $ownerFamily;

        return $this;
    }

    /**
     * @return Collection<int, TasksFeed>
     */
    public function getTasksFeeds(): Collection
    {
        return $this->tasksFeeds;
    }

    public function addTasksFeed(TasksFeed $tasksFeed): static
    {
        if (!$this->tasksFeeds->contains($tasksFeed)) {
            $this->tasksFeeds->add($tasksFeed);
            $tasksFeed->setCategory($this);
        }

        return $this;
    }

    public function removeTasksFeed(TasksFeed $tasksFeed): static
    {
        if ($this->tasksFeeds->removeElement($tasksFeed)) {
            // set the owning side to null (unless already changed)
            if ($tasksFeed->getCategory() === $this) {
                $tasksFeed->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TasksPool>
     */
    public function getTasksPools(): Collection
    {
        return $this->tasksPools;
    }

    public function addTasksPool(TasksPool $tasksPool): static
    {
        if (!$this->tasksPools->contains($tasksPool)) {
            $this->tasksPools->add($tasksPool);
            $tasksPool->setCategory($this);
        }

        return $this;
    }

    public function removeTasksPool(TasksPool $tasksPool): static
    {
        if ($this->tasksPools->removeElement($tasksPool)) {
            // set the owning side to null (unless already changed)
            if ($tasksPool->getCategory() === $this) {
                $tasksPool->setCategory(null);
            }
        }

        return $this;
    }
}
