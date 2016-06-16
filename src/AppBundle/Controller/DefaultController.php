<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\MessageType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $this->get('app.messages_manager')->saveMessage($data);
            unset($form);
            $form = $this->createForm(MessageType::class);
        }

        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->findAllDesc();

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'messages' => $messages,
        ]);
    }
}
