<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_user")
 *
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Vich\UploadableField(mapping="avatar", fileNameProperty="avatarName")
     *
     * @var File
     */
    private $avatar;

    /**
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $avatarName;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @inheritdoc
     */
    public function setEmail($email)
    {
        $email = $email ?? '';
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    public function setAvatar(File $avatar = null)
    {
        $this->avatar = $avatar;

        if ($this->avatar instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatarName(string $avatarName = null)
    {
        $this->avatarName = $avatarName;
    }

    /**
     * @return string|null
     */
    public function getAvatarName()
    {
        return $this->avatarName;
    }
}
