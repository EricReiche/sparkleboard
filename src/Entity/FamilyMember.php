<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @ORM\Entity()
 * @ORM\Table(name="family_members")
 */
#[ApiResource(array(
    'description' => 'Family members represent user accounts and belong to a family.'
))]
class FamilyMember
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private ?string $uuid;

    /**
     * @ORM\Column
     * Firstname or username
     */
    #[Assert\NotBlank]
    public string $name = '';

    /**
     * @ORM\Column
     * Display this user in some interfaces with this color
     */
    #[Assert\Regex("/^#[0-9a-f]{6}$/i")]
    public string $color = '#000000';

    /**
     * @ORM\Column(nullable=true)
     * Photo or avatar of this user
     */
    public ?string $picture = null;

    /**
     * @ORM\Column(nullable=true)
     * Role of this user in the family (e.g. father, daughter, nanny)
     */
    public ?string $role = null;

    /**
     * @ORM\Column(nullable=true)
     * Email of this user
     */
    public ?string $email = null;

    /**
     * @ORM\Column(nullable=true)
     * Salt for hashing the password
     */
    private ?string $salt = null;

    /**
     * @ORM\Column(nullable=true)
     * Hashed password to authenticate the user
     */
    private ?string $password = null;

    /**
     * @ORM\Column(nullable=true)
     * Activation code for double opt-in
     */
    private ?string $activationCode = null;

    /**
     * @ORM\Column(type="smallint")
     * How many points does this user currently have?
     */
    #[Assert\DivisibleBy(1)]
    public int $pointBalance = 0;

    /**
     * @ORM\Column(type="boolean")
     * Can this user change family settings?
     */
    public bool $isAdmin = true;

    /**
     * @ORM\Column(type="boolean")
     * Can this user approve tasks?
     */
    public bool $isApprover = true;

    /**
     * @ORM\Column(type="boolean")
     * Can this user login?
     */
    public bool $isActive = true;

    /**
     * @ORM\Column(type="datetime_immutable")
     * When was this user first created?
     */
    #[Assert\NotNull]
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * What's this user's birthdate?
     */
    public ?\DateTimeInterface $birthday = null;

    /**
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="members")
     * @ORM\JoinColumn(name="family_uuid", referencedColumnName="uuid")
     * Family this user belongs to
     */
    #[Assert\NotNull]
    public ?Family $family = null;

    /**
     * @ORM\OneToMany(targetEntity="TasksPool", mappedBy="assignee")
     * @ORM\JoinColumn(name="tasks_pool_uuid", referencedColumnName="uuid")
     */
    private iterable $tasksPool;

    /**
     * @ORM\OneToMany(targetEntity="TasksFeed", mappedBy="assignee")
     * @ORM\JoinColumn(name="tasks_feed_uuid", referencedColumnName="uuid")
     */
    private iterable $tasksFeed;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function __construct()
    {
        $this->tasksPool = new ArrayCollection();
        $this->tasksFeed = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return ?\DateTimeInterface
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @var TasksPool[]
     * @return Collection
     */
    public function getTasksPool(): Collection
    {
        return $this->tasksPool;
    }

    public function addTasksPool(TasksPool $tasksPool): self
    {
        if (!$this->tasksPool->contains($tasksPool)) {
            $this->tasksPool[] = $tasksPool;
            $tasksPool->setAssignee($this);
        }

        return $this;
    }

    public function removeTasksPool(TasksPool $tasksPool): self
    {
        if ($this->tasksPool->removeElement($tasksPool)) {
            // set the owning side to null (unless already changed)
            if ($tasksPool->getAssignee() === $this) {
                $tasksPool->setAssignee(null);
            }
        }

        return $this;
    }

    /**
     * @var TasksFeed[]
     * @return Collection
     */
    public function getTasksFeed(): Collection
    {
        return $this->tasksFeed;
    }

    public function addTasksFeed(TasksFeed $tasksFeed): self
    {
        if (!$this->tasksFeed->contains($tasksFeed)) {
            $this->tasksFeed[] = $tasksFeed;
            $tasksFeed->setAssignee($this);
        }

        return $this;
    }
}
