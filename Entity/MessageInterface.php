<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 13:25
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Entity;

/**
 * Interface SeoSA\FeedbackBundle\Entity\MessageInterface
 */
interface MessageInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param boolean $boolean
     *
     * @return $this
     */
    public function setRead($boolean);

    /**
     * @return boolean
     */
    public function isRead();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $data
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $data);

    /**
     * @param string $permalink
     *
     * @return $this
     */
    public function setPermalink($permalink);

    /**
     * @return string
     */
    public function getPermalink();
}
 