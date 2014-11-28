<?php

namespace Melodia\PageBundle\Twig;

use Sonata\BlockBundle\Templating\Helper\BlockHelper;
use Melodia\PageBundle\Entity\PageBlock;

class PageExtension extends \Twig_Extension
{
    protected $blockHelper;

    public function __construct(BlockHelper $blockHelper)
    {
        $this->blockHelper = $blockHelper;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'render_page_block',
                array($this, 'renderPageBlock'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function renderPageBlock(PageBlock $pageBlock)
    {
        return $this->blockHelper->render(
            array('type' => $pageBlock->getType()),
            $pageBlock->getJsonDecoded()
        );
    }

    public function getName()
    {
        return 'page_extension';
    }
}
