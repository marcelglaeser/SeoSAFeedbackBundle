<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 13:29
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface SeoSA\FeedbackBundle\Entity\SignedMessageInterface
 */
interface SignedMessageInterface extends MessageInterface
{
    /**
     * @param UserInterface|null $user
     *
     * @return $this
     */
    public function setAuthor(UserInterface $user = null);

    /**
     * @return UserInterface|null
     */
    public function getAuthor();
}
 