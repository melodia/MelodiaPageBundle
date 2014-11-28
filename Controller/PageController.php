<?php

/*
 * This file is part of the Melodia Page Bundle
 *
 * (c) Alexey Ryzhkov <alioch@yandex.ru>
 */

namespace Melodia\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Melodia\PageBundle\Entity\Page;
use Melodia\PageBundle\Entity\PageBlock;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Page controller
 *
 * @author Alexey Ryzhkov <alioch@yandex.ru>
 */
class PageController extends Controller
{
    public function indexAction($url)
    {
        $page = $this->getDoctrine()->getRepository(Page::REPOSITORY)
            ->findByUrl($url);

        if (!$page) {
            throw new NotFoundHttpException();
        }

        return $this->render('MelodiaPageBundle:Page:index.html.twig',
            array(
                'page' => $page,
                'blocks' => $page->getPageBlocks(),
            )
        );
    }
}
