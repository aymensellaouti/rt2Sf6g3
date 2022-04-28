<?php

namespace App\Traits;
use Doctrine\ORM\Mapping as ORM;
trait TimeStampTrait
{
    #[ORM\Column(name: 'created_at' ,type: 'datetime', nullable: true)]
    private $createdAt;
    #[ORM\Column(type: 'datetime', name: 'updated_at' , nullable: true)]
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    #[ORM\PrePersist]
    public function onCreate() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    #[ORM\PreUpdate]
    public function onUpdate() {
        $this->updatedAt = new \DateTime();
    }

}