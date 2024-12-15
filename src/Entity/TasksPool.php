<?php
namespace App\Entity;

use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tasks_pool")
 */
class TasksPool
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private ?string $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank]
    private string $name = '';

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\DivisibleBy(1)]
    private int $points = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tasksPool")
     * @ORM\JoinColumn(name="category_uuid", referencedColumnName="uuid", nullable=false)
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $icon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image;

    /**
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="tasksPool")
     * @ORM\JoinColumn(name="owner_family_uuid", referencedColumnName="uuid")
     * Family this pooltask belongs to
     */
    public ?Family $owner = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isRepeatable = false;

    /**
     * @ORM\ManyToOne(targetEntity="FamilyMember", inversedBy="tasksPool")
     * @ORM\JoinColumn(name="assignee", referencedColumnName="uuid", nullable=true)
     */
    private ?FamilyMember $assignee;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private ?string $cadence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cadenceDay;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $cadenceOverflow;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $lastExecution;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $nextExecution;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity="TasksFeed", mappedBy="tasksPool")
     * @ORM\JoinColumn(name="tasks_feed_uuid", referencedColumnName="uuid", nullable=true)
     */
    private iterable $tasksFeed;

    public function __construct()
    {
        $this->tasksFeed = new ArrayCollection();
    }

    public function getUuid()
    {
        return $this->uuid;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getOwner(): ?Family
    {
        return $this->owner;
    }

    public function setOwner(?Family $family): self
    {
        $this->owner = $family;

        return $this;
    }

    public function getIsRepeatable(): ?bool
    {
        return $this->isRepeatable;
    }

    public function setIsRepeatable(bool $isRepeatable): self
    {
        $this->isRepeatable = $isRepeatable;

        return $this;
    }

    public function getAssignee(): ?FamilyMember
    {
        return $this->assignee;
    }

    public function setAssignee(?FamilyMember $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getCadence(): ?string
    {
        return $this->cadence;
    }

    public function setCadence(?string $cadence): self
    {
        $this->cadence = $cadence;

        return $this;
    }

    public function getCadenceDay(): ?int
    {
        return $this->cadenceDay;
    }

    public function setCadenceDay(?int $cadenceDay): self
    {
        $this->cadenceDay = $cadenceDay;

        return $this;
    }

    public function getCadenceOverflow(): ?bool
    {
        return $this->cadenceOverflow;
    }

    public function setCadenceOverflow(?bool $cadenceOverflow): self
    {
        $this->cadenceOverflow = $cadenceOverflow;

        return $this;
    }

    public function getLastExecution(): ?\DateTimeInterface
    {
        return $this->lastExecution;
    }

    public function setLastExecution(?\DateTimeInterface $lastExecution): self
    {
        $this->lastExecution = $lastExecution;

        return $this;
    }

    public function getNextExecution(): ?\DateTimeInterface
    {
        return $this->nextExecution;
    }

    public function setNextExecution(?\DateTimeInterface $nextExecution): self
    {
        $this->nextExecution = $nextExecution;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|TasksFeed[]
     */
    public function getTasksFeed(): Collection
    {
        return $this->tasksFeed;
    }

    public function addTasksFeed(TasksFeed $tasksFeed): self
    {
        if (!$this->tasksFeeds->contains($tasksFeed)) {
            $this->tasksFeeds[] = $tasksFeed;
            $tasksFeed->setPoolTask($this);
        }

        return $this;
    }

    public function removeTasksFeed(TasksFeed $tasksFeed): self
    {
        if ($this->tasksFeeds->removeElement($tasksFeed)) {
            // set the owning side to null (unless already changed)
            if ($tasksFeed->getPoolTask() === $this) {
                $tasksFeed->setPoolTask(null);
            }
        }

        return $this;
    }
}
