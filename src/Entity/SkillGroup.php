<?php

namespace App\Entity;

use App\Repository\SkillGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillGroupRepository::class)
 */
class SkillGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $custom_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $aquired_percentage;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="skillGroup")
     */
    private $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomName(): ?string
    {
        return $this->custom_name;
    }

    public function setCustomName(?string $custom_name): self
    {
        $this->custom_name = $custom_name;

        return $this;
    }

    public function getAquiredPercentage(): ?int
    {
        return $this->aquired_percentage;
    }

    public function setAquiredPercentage(int $aquired_percentage): self
    {
        $this->aquired_percentage = $aquired_percentage;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setSkillGroup($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getSkillGroup() === $this) {
                $skill->setSkillGroup(null);
            }
        }

        return $this;
    }
}
