<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @Vich\Uploadable
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePicture;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="profile_picture", fileNameProperty="profilePicture", size="imageSize")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $followers = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $following = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="profile", cascade={"persist", "remove"})
     */
    private $owner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;



    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->following = [];
        $this->followers = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getFollowers(): ?array
    {
        return $this->followers;
    }

    public function setFollowers(?array $followers): self
    {
        $this->followers = $followers;

        return $this;
    }

    public function addFollowers(int $i)
    {
        array_push($this->followers, $i);
        return $this;
    }

    public function removeFollower(int $i)
    {
        foreach ($this->followers as $k => $val) {
            if ($val == $i) {
                unset($this->followers[$k]);
            }
        }
    }

    public function getFollowing(): ?array
    {
        return $this->following;
    }

    public function setFollowing(?array $following): self
    {
        $this->following = $following;

        return $this;
    }

    public function addFollowing(int $i)
    {
        array_push($this->following, $i);
        return $this;
    }


    public function removeFollowing(int $i)
    {
        foreach ($this->following as $k => $val) {
            if ($val == $i) {
                unset($this->following[$k]);
            }
        }
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }


    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
