<?php

namespace App\Entity;

use App\Repository\TasksPoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: TasksPoolRepository::class)]
class TasksPool
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\ManyToOne(inversedBy: 'tasksPools')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $Category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'tasksPools')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $owner = null;

    #[ORM\Column]
    private ?bool $isRepeatable = null;

    #[ORM\ManyToOne(inversedBy: 'tasksPools')]
    private ?FamilyMember $assignee = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $cadence = null;

    #[ORM\Column(nullable: true)]
    private ?int $cadenceDay = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cadenceOverflow = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastExecution = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $nextExecution = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, tasksFeed>
     */
    #[ORM\OneToMany(targetEntity: tasksFeed::class, mappedBy: 'tasksPool')]
    private Collection $tasksFeed;
    
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable]
    public ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->tasksFeed = new ArrayCollection();
    }


    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

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

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getOwner(): ?Family
    {
        return $this->owner;
    }

    public function setOwner(?Family $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function isRepeatable(): ?bool
    {
        return $this->isRepeatable;
    }

    public function setRepeatable(bool $isRepeatable): static
    {
        $this->isRepeatable = $isRepeatable;

        return $this;
    }

    public function getAssignee(): ?FamilyMember
    {
        return $this->assignee;
    }

    public function setAssignee(?FamilyMember $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getCadence(): ?string
    {
        return $this->cadence;
    }

    public function setCadence(?string $cadence): static
    {
        $this->cadence = $cadence;

        return $this;
    }

    public function getCadenceDay(): ?int
    {
        return $this->cadenceDay;
    }

    public function setCadenceDay(?int $cadenceDay): static
    {
        $this->cadenceDay = $cadenceDay;

        return $this;
    }

    public function isCadenceOverflow(): ?bool
    {
        return $this->cadenceOverflow;
    }

    public function setCadenceOverflow(?bool $cadenceOverflow): static
    {
        $this->cadenceOverflow = $cadenceOverflow;

        return $this;
    }

    public function getLastExecution(): ?\DateTimeInterface
    {
        return $this->lastExecution;
    }

    public function setLastExecution(?\DateTimeInterface $lastExecution): static
    {
        $this->lastExecution = $lastExecution;

        return $this;
    }

    public function getNextExecution(): ?\DateTimeInterface
    {
        return $this->nextExecution;
    }

    public function setNextExecution(?\DateTimeInterface $nextExecution): static
    {
        $this->nextExecution = $nextExecution;

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

    /**
     * @return Collection<int, tasksFeed>
     */
    public function getTasksFeed(): Collection
    {
        return $this->tasksFeed;
    }

    public function addTasksFeed(tasksFeed $tasksFeed): static
    {
        if (!$this->tasksFeed->contains($tasksFeed)) {
            $this->tasksFeed->add($tasksFeed);
            $tasksFeed->setTasksPool($this);
        }

        return $this;
    }

    public function removeTasksFeed(tasksFeed $tasksFeed): static
    {
        if ($this->tasksFeed->removeElement($tasksFeed)) {
            // set the owning side to null (unless already changed)
            if ($tasksFeed->getTasksPool() === $this) {
                $tasksFeed->setTasksPool(null);
            }
        }

        return $this;
    }
}
