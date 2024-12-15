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
 * @ORM\Table(name="tasks_feed")
 */
class TasksFeed
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
     * @ORM\ManyToOne(targetEntity="TasksPool", inversedBy="tasksFeed")
     * @ORM\JoinColumn(name="tasks_pool_uuid", referencedColumnName="uuid", nullable=true)
     */
    private TasksPool $tasksPool;

    /**
     * @ORM\Column(type="integer")
     */
    #[Assert\DivisibleBy(1)]
    private int $points = 0;

    /**
     * @ORM\ManyToOne(targetEntity="FamilyMember", inversedBy="tasksFeed")
     * @ORM\JoinColumn(name="assignee", referencedColumnName="uuid", nullable=false)
     */
    private ?FamilyMember $assignee;

    /**
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="tasksFeed")
     * @ORM\JoinColumn(name="owner_family_uuid", referencedColumnName="uuid")
     * Family this feedtask belongs to
     */
    public ?Family $owner = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isComplete = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $completedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Assert\NotBlank]
    private ?\DateTimeInterface $scheduledAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $dueAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $duration;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="tasksFeed")
     * @ORM\JoinColumn(name="category_uuid", referencedColumnName="uuid", nullable=false)
     */
    private ?Category $category;


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

    public function getTasksPool(): ?TasksPool
    {
        return $this->tasksPool;
    }

    public function setTasksPool(?TasksPool $tasksPool): self
    {
        $this->tasksPool = $tasksPool;

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

    public function getAssignee(): ?FamilyMember
    {
        return $this->assignee;
    }

    public function setAssignee(?FamilyMember $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getOwner(): ?Family
    {
        return $this->owner;
    }

    public function setOwner(?Family $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getScheduledAt(): ?\DateTimeInterface
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getDueAt(): ?\DateTimeInterface
    {
        return $this->dueAt;
    }

    public function setDueAt(?\DateTimeInterface $dueAt): self
    {
        $this->dueAt = $dueAt;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

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
}
