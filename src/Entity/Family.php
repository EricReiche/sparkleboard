<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @ORM\Entity()
 * @ORM\Table(name="familys")
 */
#[ApiResource(array(
    'description' => 'Family contains a set of members sharing resources like categories, tasks and have a common feed.'
))]
class Family
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
     * Family name
     */
    #[Assert\NotBlank]
    public string $name = '';

    /**
     * @ORM\Column(type="boolean")
     * Is the 'tasks' feature active for this family?
     */
    public bool $tasksActive = true;

    /**
     * @ORM\Column(type="boolean")
     * Is the 'rewards' feature active for this family?
     */
    public bool $rewardsActive = true;

    /**
     * @ORM\Column(type="boolean")
     * Is the 'groceries' feature active for this family?
     */
    public bool $groceriesActive = true;

    /**
     * @ORM\Column(type="boolean")
     * Is the 'schedule' feature active for this family?
     */
    public bool $scheduleActive = true;

    /**
     * @ORM\Column(type="datetime_immutable")
     * When was this family first registered?
     */
    #[Assert\NotNull]
    private ?\DateTimeInterface $createdAt = null;

    /**
     * @ORM\OneToMany(targetEntity="FamilyMember", mappedBy="family")
     * @var FamilyMember[] Users in this family
     */
    public iterable $members;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="owner")
     * @var Category[] Categories created/owned by this family
     */
    private iterable $ownCategories;

    /**
     * @ORM\OneToMany(targetEntity="TasksPool", mappedBy="owner")
     * Set of predefined tasks
     */
    private iterable $tasksPool;

    /**
     * @ORM\OneToMany(targetEntity="TasksFeed", mappedBy="owner")
     * Set of task iterations
     */
    private iterable $tasksFeed;

    public function getUuid()
    {
        return $this->uuid;
    }

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function __toString() : string
    {
        return $this->name;
    }
}
