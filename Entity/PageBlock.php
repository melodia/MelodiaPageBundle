<?php

namespace Melodia\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="page_blocks")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class PageBlock
{
    const REPOSITORY = 'MelodiaPageBundle:PageBlock';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"getOnePageBlock"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"getOnePageBlock"})
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"getOnePageBlock"})
     */
    protected $keyword;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"getOnePageBlock"})
     */
    protected $json;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return PageBlock
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return PageBlock
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set json
     *
     * @param string $json
     * @return PageBlock
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * @return string
     */
    public function getJson()
    {
        return $this->json;
    }

    public function getJsonDecoded()
    {
        return json_decode($this->json, $assoc = true);
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return PageBlock
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
