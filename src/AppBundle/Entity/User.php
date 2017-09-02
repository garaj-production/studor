<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
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
     * @ORM\Column(name="avatar", type="string", length=255)
     *
     * @var string
     */
    private $avatarName;

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
    }

    /**
     * @return File|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatarName(string $avatarName)
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
