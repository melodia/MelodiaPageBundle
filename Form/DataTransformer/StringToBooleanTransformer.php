<?php

namespace Melodia\PageBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class StringToBooleanTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return (bool) $value;
    }

    public function reverseTransform($string)
    {
        switch ($string) {
            case "true":
                $value = true;
                break;
            case "false":
                $value = false;
                break;
            default:
                $value = (bool) $string;
                break;
        }

        return $value;
    }
}
