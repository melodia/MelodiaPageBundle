<?php

namespace Melodia\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="page_templates")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class PageTemplate
{
    const REPOSITORY = 'MelodiaPageBundle:PageTemplate';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * One-To-Many unidirectional association
     *
     * @ORM\ManyToMany(targetEntity="PageBlock", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="page_templates__page_blocks",
     *     joinColumns={@ORM\JoinColumn(name="ptemplate_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="page_block_id", referencedColumnName="id", unique=true)}
     * )
     */
    protected $templateBlocks;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="template")
     */
    protected $pages;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    public function __construct()
    {
        $this->templateBlocks = new ArrayCollection();
        $this->pages = new ArrayCollection();
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

    /**
     * Set name
     *
     * @param string $name
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Add templateBlocks
     *
     * @param \Melodia\PageBundle\Entity\TemplateBlock $templateBlocks
     * @return PageTemplate
     */
    public function addTemplateBlock(\Melodia\PageBundle\Entity\TemplateBlock $templateBlocks)
    {
        $this->templateBlocks[] = $templateBlocks;

        return $this;
    }

    /**
     * Remove templateBlocks
     *
     * @param \Melodia\PageBundle\Entity\TemplateBlock $templateBlocks
     */
    public function removeTemplateBlock(\Melodia\PageBundle\Entity\TemplateBlock $templateBlocks)
    {
        $this->templateBlocks->removeElement($templateBlocks);
    }

    /**
     * Get templateBlocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemplateBlocks()
    {
        return $this->templateBlocks;
    }

    public function findTemplateBlock($keyword)
    {
        return $this->templateBlocks->filter(function ($pageBlock) use ($keyword) {
            return $pageBlock->getKeyword() === $keyword;
        })->first();
    }

    public function addPage(Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    public function removePage(Page $page)
    {
        $this->pages->removeElement($page);
    }

    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return PageTemplate
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

