<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 15:25
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Twig;

use SeoSA\FeedbackBundle\Entity\SignedMessageInterface;

/**
 * Class SeoSA\FeedbackBundle\Twig\FeedbackExtension
 */
class FeedbackExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'seo_sa_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('seosa_feedback_signed_message', function ($value) {
                return $value instanceof SignedMessageInterface;
            })
        ];
    }
}
 