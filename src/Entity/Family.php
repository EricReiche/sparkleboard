<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'ownerFamily')]
    private Collection $categories;

    /**
     * @var Collection<int, FamilyMember>
     */
    #[ORM\OneToMany(targetEntity: FamilyMember::class, mappedBy: 'Family')]
    private Collection $familyMembers;

    /**
     * @var Collection<int, TasksFeed>
     */
    #[ORM\OneToMany(targetEntity: TasksFeed::class, mappedBy: 'owner')]
    private Collection $tasksFeeds;

    /**
     * @var Collection<int, TasksPool>
     */
    #[ORM\OneToMany(targetEntity: TasksPool::class, mappedBy: 'owner')]
    private Collection $tasksPools;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->familyMembers = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setOwnerFamily($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getOwnerFamily() === $this) {
                $category->setOwnerFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FamilyMember>
     */
    public function getFamilyMembers(): Collection
    {
        return $this->familyMembers;
    }

    public function addFamilyMember(FamilyMember $familyMember): static
    {
        if (!$this->familyMembers->contains($familyMember)) {
            $this->familyMembers->add($familyMember);
            $familyMember->setFamily($this);
        }

        return $this;
    }

    public function removeFamilyMember(FamilyMember $familyMember): static
    {
        if ($this->familyMembers->removeElement($familyMember)) {
            // set the owning side to null (unless already changed)
            if ($familyMember->getFamily() === $this) {
                $familyMember->setFamily(null);
            }
        }

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
            $tasksFeed->setOwner($this);
        }

        return $this;
    }

    public function removeTasksFeed(TasksFeed $tasksFeed): static
    {
        if ($this->tasksFeeds->removeElement($tasksFeed)) {
            // set the owning side to null (unless already changed)
            if ($tasksFeed->getOwner() === $this) {
                $tasksFeed->setOwner(null);
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
            $tasksPool->setOwner($this);
        }

        return $this;
    }

    public function removeTasksPool(TasksPool $tasksPool): static
    {
        if ($this->tasksPools->removeElement($tasksPool)) {
            // set the owning side to null (unless already changed)
            if ($tasksPool->getOwner() === $this) {
                $tasksPool->setOwner(null);
            }
        }

        return $this;
    }
}
