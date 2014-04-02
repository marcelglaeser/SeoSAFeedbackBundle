<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 15:35
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\SonataAdmin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class SeoSA\FeedbackBundle\SonataAdmin\MessageAdmin
 */
class MessageAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_order' => 'DESC', // sort direction
    );

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('title');
        $show->add('body');
        if ($this->isSignedMessagesAdmin()) {
            $show->add('author');
        }
        $show->add(
            'permalink',
            'url',
            [
                'template' => 'SeoSAFeedbackBundle:SonataAdmin:show_url.html.twig'
            ]
        );
        $show->add('createdAt');
        $show->add('read');
        $show->add(
            'Mark as read',
            'button',
            [
                'template' => 'SeoSAFeedbackBundle:SonataAdmin:show_mark_as_read.html.twig'
            ]
        );
    }


    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier(
            'id',
            'integer',
            [
                'route' => [
                    'name' => 'show'
                ]
            ]
        );
        $list->addIdentifier(
            'title',
            'string',
            [
                'route' => [
                    'name' => 'show'
                ]
            ]
        );
        if ($this->isSignedMessagesAdmin()) {
            $list->add('author');
        }

        $list->addIdentifier(
            'permalink',
            'url',
            [
                'template' => 'SeoSAFeedbackBundle:SonataAdmin:list_url.html.twig'
            ]
        );
        $list->add(
            'createdAt',
            'date',
            [
                'format' => 'Y-m-d H:i:s'
            ]
        );
        $list->add('read');
        $list->add(
            '_action',
            'actions',
            [
                'actions' => [
                    'show'   => [],
                    'delete' => [],
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title');
        if ($this->isSignedMessagesAdmin()) {
            $filter->add('author');
        }
        $filter->add('permalink');
        $filter->add(
            'createdAt',
            'doctrine_orm_date_range',
            [],
            'date',
            [
                'widget' => 'single_text',
            ]
        );
        $filter->add('read');
    }

    /**
     * {@inheritdoc}
     */
    protected function isSignedMessagesAdmin()
    {
        $reflection = new \ReflectionClass($this->getClass());

        return $reflection->implementsInterface('SeoSA\FeedbackBundle\Entity\SignedMessageInterface');
    }

    /**
     * {@inheritdoc}
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        // check user permissions
        if ($this->isGranted('EDIT')) {
            $actions['mark_ad_read'] = [
                'label'            => $this->trans('action_mark_as_read', array(), 'SeoSAFeedbackBundle'),
                'ask_confirmation' => false
            ];

        }

        return $actions;
    }


}
 