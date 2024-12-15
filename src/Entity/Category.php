<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @ORM\Entity()
 * @ORM\Table(name="categories")
 */
class Category
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
    private ?string $icon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\Regex("/^#[0-9a-f]{6}$/i")]
    private ?string $color;

    /**
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="ownCategories")
     * @ORM\JoinColumn(name="owner_family_uuid", referencedColumnName="uuid", nullable=true)
     * Family this category belongs to
     */
    public ?Family $owner = null;

    /**
     * @ORM\OneToMany(targetEntity="TasksPool", mappedBy="category")
     * @var TasksPool[] Pooltasks in this category
     */
    private iterable $tasksPool;

    /**
     * @ORM\OneToMany(targetEntity="TasksFeed", mappedBy="category")
     * @var TasksFeed[] Feedtasks in this category
     */
    private iterable $tasksFeed;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank]
    private ?string $name;

    public function __construct()
    {
        $this->tasksPool = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    /**
     * @return Collection|TasksPool[]
     */
    public function getTasksPool(): Collection
    {
        return $this->tasksPool;
    }

    public function addTasksPool(TasksPool $tasksPool): self
    {
        if (!$this->tasksPool->contains($tasksPool)) {
            $this->tasksPool[] = $tasksPool;
            $tasksPool->setCategory($this);
        }

        return $this;
    }

    public function removeTasksPool(TasksPool $tasksPool): self
    {
        if ($this->tasksPool->removeElement($tasksPool)) {
            // set the owning side to null (unless already changed)
            if ($tasksPool->getCategory() === $this) {
                $tasksPool->setCategory(null);
            }
        }

        return $this;
    }
}
