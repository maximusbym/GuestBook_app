<?php
namespace AppBundle\Messages;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Message;
use AppBundle\Entity\User;

class MessagesManager
{
    protected $em;
    protected $tokenGenerator;
    public function __construct(EntityManager $em, $tokenGenerator)
    {
        $this->em = $em;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function saveMessage($data)
    {
        $em = $this->em;

        $user = $this->getUser($data);

        $message = new Message();
        $message->setText( $data['text'] );
        $message->setUser( $user );

        $em->persist($message);
        $em->flush();
        
        return true;
    }

    public function getUser($data)
    {
        $em = $this->em;

        $user = $em->getRepository('AppBundle:User')->findOneByEmail($data['email']);
        if( !$user ) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setUsername($data['username']);
            $password = substr($this->tokenGenerator->generateToken(), 0, 8);
            $user->setPassword($password);
        }

        return $user;
    }
    
    public function remove($count)
    {
        $em = $this->em;

        $repo = $em->getRepository('AppBundle:Message');

        return $lastMessages = $repo->deleteLast($count);
    }



}