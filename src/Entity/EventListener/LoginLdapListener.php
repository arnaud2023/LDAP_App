<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class LoginLdapListener
{


    private $manager;


    public function _construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }

    public function OnSuccessLogin(InteractiveLoginEvent $event)
    {
        $request=$event->getRequest();
        $token=$event->getAuthenticationToken();
        $LogUser=$token->getUser();
        dd($LogUser);

        if($LogUser Instanceof User)
        {
            dd($LogUser);
        }
    }
  

}




