<?php
namespace Framework\Twig;

/**
 * Serie de bla bla pour les textes
 */
class TextExtension extends \Twig_Extension
{

   
    public function getFilters()
    {
        return
        [
            new \Twig_SimpleFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    public function excerpt(string $content, int $maxLength = 100) : string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            $excerpt = mb_substr($content, 0, $lastSpace).' ...';

            return $excerpt;
        }
        return $content;
    }
}
