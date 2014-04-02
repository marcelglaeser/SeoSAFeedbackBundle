<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 14:38
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Entity;

/**
 * Interface SeoSA\FeedbackBundle\Entity\MessageManagerInterface
 */
interface MessageManagerInterface
{
    /**
     * @return MessageInterface[]
     */
    public function findAll();

    /**
     * @param array    $orderBy
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return MessageInterface[]
     */
    public function findChecked(array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param array    $orderBy
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return MessageInterface[]
     */
    public function findNotChecked(array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param int $id
     *
     * @return MessageInterface
     */
    public function findById($id);

    /**
     * @param MessageInterface $message
     *
     * @return boolean
     */
    public function saveMessage(MessageInterface $message);

    /**
     * @param MessageInterface $message
     *
     * @return boolean
     */
    public function removeMessage(MessageInterface $message);

    /**
     * @return MessageInterface
     */
    public function createMessage();
}
 