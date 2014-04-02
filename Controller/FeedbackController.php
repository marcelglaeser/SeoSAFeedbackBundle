<?php

namespace SeoSA\FeedbackBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use SeoSA\FeedbackBundle\Entity\MessageInterface;
use SeoSA\FeedbackBundle\Entity\MessageManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as ControllerConfiguration;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SeoSA\FeedbackBundle\Controller\FeedbackController
 */
class FeedbackController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @ControllerConfiguration\Put("/messages")
     *
     * @return \FOS\RestBundle\View\View
     */
    public function putAction(Request $request)
    {
        $form    = $this->getMessageForm();
        $message = $this->getMessageManger()->createMessage();
        $form->setData($message);
        $form->submit($request);

        if ($form->isValid()) {
            if ($this->getMessageManger()->saveMessage($message)) {
                if ($request->isXmlHttpRequest()) {
                    return new Response('Done');
                }

                return $this->handleView(
                    $this->redirectView(
                        $request->headers->get(
                            'referer',
                            $this->getRouter()->generate('seo_sa_feedback_get', ['messageId' => $message->getId()])
                        )
                    )
                );
            }
        }

        $view = $this
            ->view(
                [
                    'form' => $form->createView(),
                ],
                Codes::HTTP_BAD_REQUEST
            )
            ->setTemplate(
                $this->getTemplate('message_form')
            );

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @ControllerConfiguration\Get(
     *      "/messages/create",
     *      requirements={
     *          "_format"="html",
     *     }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $form    = $this->getMessageForm();
        $message = $this->getMessageManger()->createMessage();

        $message->setPermalink(
            $request->get(
                'permalink',
                $request->headers->get(
                    'referer',
                    $request->getRequestUri()
                )
            )
        );

        $form->setData($message);

        $view = $this
            ->view(
                [
                    'form' => $form->createView(),
                ]
            )
            ->setTemplate(
                $this->getTemplate('message_form')
            );

        return $this->handleView($view);
    }

    /**
     * @param int $messageId
     *
     * @ControllerConfiguration\Get(
     *      "/messages/{messageId}",
     *      requirements={
     *          "messageId"="\d+",
     *     }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getAction($messageId)
    {
        $message = $this->getMessageManger()->findById($messageId);
        if (!$message instanceof MessageInterface) {
            throw new NotFoundHttpException(
                sprintf(
                    'Message #%d not exists',
                    $messageId
                )
            );
        }

        $view = $this
            ->view(
                [
                    'message' => $message,
                ]
            )
            ->setTemplate(
                $this->getTemplate('message_show')
            );

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param int     $messageId
     *
     * @ControllerConfiguration\Patch(
     *      "/messages/{messageId}/state",
     *      requirements={
     *          "messageId"="\d+",
     *     }
     * )
     *
     * @return \FOS\RestBundle\View\View
     * @throws \RuntimeException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function patchMessageReadAction(Request $request, $messageId)
    {
        $message = $this->getMessageManger()->findById($messageId);
        if (!$message instanceof MessageInterface) {
            throw new NotFoundHttpException(
                sprintf(
                    'Message #%d not exists',
                    $messageId
                )
            );
        }

        $state = (bool) $request->get('state', false);
        $message->setRead($state);

        if ($this->getMessageManger()->saveMessage($message)) {
            return $this->handleView(
                $this->redirectView(
                    $request->headers->get(
                        'referer',
                        $this->getRouter()->generate('seo_sa_feedback_get', ['messageId' => $message->getId()])
                    )
                )
            );
        }

        throw new \RuntimeException(
            sprintf(
                'Message #%d not saved',
                $messageId
            )
        );
    }

    /**
     * @ControllerConfiguration\Get("/messages")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $view = $this
            ->view(
                [
                    'checked_messages'     => $this->getMessageManger()->findChecked(),
                    'not_checked_messages' => $this->getMessageManger()->findNotChecked()
                ]
            )
            ->setTemplate($this->getTemplate('message_list'));

        return $this->handleView($view);
    }

    /**
     * @return MessageManagerInterface
     */
    protected function getMessageManger()
    {
        return $this->get('seo_sa_feedback.message.manager');
    }

    /**
     * @return FormFactoryInterface
     */
    protected function getFormFactory()
    {
        return $this->get('form.factory');
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function getMessageForm()
    {
        return $this->getFormFactory()->create('seo_sa_feedback_message');
    }

    /**
     * @return \Symfony\Component\Routing\RouterInterface
     */
    protected function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * Overridden for push base layout into template
     *
     * {@inheritdoc}
     */
    protected function view($data = null, $statusCode = null, array $headers = array())
    {
        if (!isset($data['layout'])) {
            $data['layout'] = $this->getTemplate('layout');
        }

        return parent::view($data, $statusCode, $headers);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getTemplate($name)
    {
        return $this->container->getParameter('seo_sa_feedback.templating.'.$name);
    }
}
