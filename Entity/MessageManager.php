<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 15:43
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Entity;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SeoSA\FeedbackBundle\Entity\MessageManager
 */
class MessageManager implements MessageManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var string
     */
    protected $class;

    /**
     * @param EntityManager            $em
     * @param SecurityContextInterface $securityContext
     * @param string                   $class
     */
    public function __construct(EntityManager $em, SecurityContextInterface $securityContext, $class)
    {
        $this->em              = $em;
        $this->securityContext = $securityContext;
        $this->class           = (string) $class;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository($this->class);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findChecked(array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy(['read' => true], $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findNotChecked(array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy(['read' => false], $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function saveMessage(MessageInterface $message)
    {
        if ($message instanceof SignedMessageInterface) {
            $token = $this->securityContext->getToken();
            if ($token) {
                $user = $token->getUser();
                if ($user instanceof UserInterface) {
                    $message->setAuthor($token->getUser());
                }
            }
        }
        $this->em->persist($message);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function removeMessage(MessageInterface $message)
    {
        $this->em->remove($message);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function createMessage()
    {
        return new $this->class;
    }
}
 