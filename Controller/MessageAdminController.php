<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.04.14
 * Time: 10:07
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SeoSA\FeedbackBundle\Controller\MessageAdminController
 */
class MessageAdminController extends Controller
{
    /**
     * @param ProxyQuery $pq
     *
     * @return RedirectResponse
     */
    public function batchActionMarkAdRead(ProxyQuery $pq)
    {
        /** @var \Symfony\Component\HttpFoundation\Request $request */
        $request = $this->container->get('request');
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb =  $pq->getQueryBuilder();

        $class = $this->container->getParameter('seo_sa_feedback.message.class');
        $qb->update($class, 'o')->set('o.read', true);

        $qb->getQuery()->execute();

        return new RedirectResponse(
            $request->headers->get('referer')
        );
    }
}
 