<?php

namespace App\Entity;

use App\Repository\FamilyMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FamilyMemberRepository::class)]
class FamilyMember
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $salt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activationCode = null;

    #[ORM\Column]
    private ?int $pointBalance = null;

    #[ORM\Column]
    private ?bool $isAdmin = null;

    #[ORM\Column]
    private ?bool $isApprover = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\ManyToOne(inversedBy: 'familyMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $Family = null;

    /**
     * @var Collection<int, TasksFeed>
     */
    #[ORM\OneToMany(targetEntity: TasksFeed::class, mappedBy: 'assignee')]
    private Collection $tasksFeeds;

    /**
     * @var Collection<int, TasksPool>
     */
    #[ORM\OneToMany(targetEntity: TasksPool::class, mappedBy: 'assignee')]
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


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(?string $salt): static
    {
        $this->salt = $salt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getActivationCode(): ?string
    {
        return $this->activationCode;
    }

    public function setActivationCode(?string $activationCode): static
    {
        $this->activationCode = $activationCode;

        return $this;
    }

    public function getPointBalance(): ?int
    {
        return $this->pointBalance;
    }

    public function setPointBalance(int $pointBalance): static
    {
        $this->pointBalance = $pointBalance;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function isApprover(): ?bool
    {
        return $this->isApprover;
    }

    public function setApprover(bool $isApprover): static
    {
        $this->isApprover = $isApprover;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->Family;
    }

    public function setFamily(?Family $Family): static
    {
        $this->Family = $Family;

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
            $tasksFeed->setAssignee($this);
        }

        return $this;
    }

    public function removeTasksFeed(TasksFeed $tasksFeed): static
    {
        if ($this->tasksFeeds->removeElement($tasksFeed)) {
            // set the owning side to null (unless already changed)
            if ($tasksFeed->getAssignee() === $this) {
                $tasksFeed->setAssignee(null);
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
            $tasksPool->setAssignee($this);
        }

        return $this;
    }

    public function removeTasksPool(TasksPool $tasksPool): static
    {
        if ($this->tasksPools->removeElement($tasksPool)) {
            // set the owning side to null (unless already changed)
            if ($tasksPool->getAssignee() === $this) {
                $tasksPool->setAssignee(null);
            }
        }

        return $this;
    }
}
