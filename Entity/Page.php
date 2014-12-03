<?php

namespace Melodia\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="PageRepository")
 * @ORM\Table(name="pages")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Page
{
    const REPOSITORY = 'MelodiaPageBundle:Page';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="PageTemplate", inversedBy="pages", cascade={"persist"})
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    protected $template;

    /**
     * One-To-Many unidirectional association
     *
     * @ORM\ManyToMany(targetEntity="PageBlock", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="pages__page_blocks",
     *     joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="page_block_id", referencedColumnName="id", unique=true)}
     * )
     *
     * @Groups({"getOnePageBlock"})
     */
    protected $pageBlocks;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $url;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $isActive;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $isEditable;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"getAllPages", "getOnePage"})
     */
    protected $keywords;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    public function __construct()
    {
        $this->pageBlocks = new ArrayCollection();
        $this->isEditable = true;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setTemplate(PageTemplate $template = null)
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Page
     */
    public function setUrl($url)
    {
        if (substr($url, 0, 1) !== '/') {
            $url = '/' . $url;
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Page
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

    /**
     * Add pageBlocks
     *
     * @param \Melodia\PageBundle\Entity\PageBlock $pageBlocks
     * @return Page
     */
    public function addPageBlock(\Melodia\PageBundle\Entity\PageBlock $pageBlocks)
    {
        $this->pageBlocks[] = $pageBlocks;

        return $this;
    }

    /**
     * Remove pageBlocks
     *
     * @param \Melodia\PageBundle\Entity\PageBlock $pageBlocks
     */
    public function removePageBlock(\Melodia\PageBundle\Entity\PageBlock $pageBlocks)
    {
        $this->pageBlocks->removeElement($pageBlocks);
    }

    /**
     * Get pageBlocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks()
    {
        return $this->pageBlocks;
    }

    public function findPageBlock($keyword)
    {
        return $this->pageBlocks->filter(function ($pageBlock) use ($keyword) {
            return $pageBlock->getKeyword() === $keyword;
        })->first();
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Page
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Page
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isEditable
     *
     * @param boolean $isEditable
     * @return Page
     */
    public function setIsEditable($isEditable)
    {
        if ($isEditable !== null) {
            $this->isEditable = $isEditable;
        }

        return $this;
    }

    /**
     * Get isEditable
     *
     * @return boolean
     */
    public function getIsEditable()
    {
        return $this->isEditable;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Page
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}
