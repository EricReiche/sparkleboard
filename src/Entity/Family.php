<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

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
    private Collection $tasksFeed;

    /**
     * @var Collection<int, TasksPool>
     */
    #[ORM\OneToMany(targetEntity: TasksPool::class, mappedBy: 'owner')]
    private Collection $tasksPool;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->familyMembers = new ArrayCollection();
        $this->tasksFeed = new ArrayCollection();
        $this->tasksPool = new ArrayCollection();
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
        return $this->tasksFeed;
    }

    public function addTasksFeed(TasksFeed $tasksFeed): static
    {
        if (!$this->tasksFeed->contains($tasksFeed)) {
            $this->tasksFeed->add($tasksFeed);
            $tasksFeed->setOwner($this);
        }

        return $this;
    }

    public function removeTasksFeed(TasksFeed $tasksFeed): static
    {
        if ($this->tasksFeed->removeElement($tasksFeed)) {
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
        return $this->tasksPool;
    }

    public function addTasksPool(TasksPool $tasksPool): static
    {
        if (!$this->tasksPool->contains($tasksPool)) {
            $this->tasksPool->add($tasksPool);
            $tasksPool->setOwner($this);
        }

        return $this;
    }

    public function removeTasksPool(TasksPool $tasksPool): static
    {
        if ($this->tasksPool->removeElement($tasksPool)) {
            // set the owning side to null (unless already changed)
            if ($tasksPool->getOwner() === $this) {
                $tasksPool->setOwner(null);
            }
        }

        return $this;
    }
}
