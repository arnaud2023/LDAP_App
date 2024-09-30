<?php
namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginLdapListener
{
    private $manager;

   private $hashPass;


    public function _construct(EntityManagerInterface $manager,UserPasswordHasherInterface $hashPass)
    {
        $this->manager=$manager;
        $this->hashPass=$hashPass; 
    }

    public function OnSuccessLogin(LoginLdapListener $event)
    {
        $request=$event->getRequest();
        $token=$event->getAuthenticationToken();
        $LogUser=$token->getUser();
        dd($LogUser);

        if(!($LogUser Instanceof User))
        {
            // dd($LogUser);
            $name->$LogUser->getEntry()->getAttributes()['cn'][0];
            dd($name);
            $email=$LogUser->getEntry()->getAttributes()['mail'][0];
            $username=$request->request->get('_usename');
            
            $password=$request->request->get('_password');

            // l'utilisateur existe dans ma base de données

            $check_user=$this->manager->getRepository(User::class)->findOneByEmail($email);

            if($check_user)
            {
                $check_user->setName($name)
                            ->setPassword($this->hashPass->hashPassword($check_user.$password));
                            // ->setRoles($LogUser->getRoles())
                            // ->setUsername($username);
                            // ajouter
                $this->manager->flush();
            }

            else
            {
                $user= new User();
                $user->setName($name)
                     ->setEmail($email)
                     ->setPassword($this->hashPass->hashPassword($user.$password));
                    //  ->setRoles($LogUser->getRoles())
                    //  ->setUsername($username);
                    //  ->setNoms($noms);

                $this->manager->persist($user);

                $this->manager->flush();
            }

        }


    }
  

}





// namespace App\EventListener;

// use App\Entity\User;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpKernel\Event\ExceptionEvent;
// use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

// class ExceptionListener
// {
//     public function __invoke(ExceptionEvent $event): void
//     {
//         // You get the exception object from the received event
//         $exception = $event->getThrowable();
//         $message = sprintf(
//             'My Error says: %s with code: %s',
//             $exception->getMessage(),
//             $exception->getCode()
//         );

//         // Customize your response object to display the exception details
//         $response = new Response();
//         $response->setContent($message);

//         // HttpExceptionInterface is a special type of exception that
//         // holds status code and header details
//         if ($exception instanceof HttpExceptionInterface) {
//             $response->setStatusCode($exception->getStatusCode());
//             $response->headers->replace($exception->getHeaders());
//         } else {
//             $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
//         }

//         // sends the modified response object to the event
//         $event->setResponse($response);
//     }
// }