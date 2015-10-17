<?php

namespace Duedinoi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DuedinoiUserBundle:Default:index.html.twig', array('name' => $name));
    }
    
    
    public function processAuthAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        var_dump($user);die;
        if(is_string($this->get('security.context')->getToken()->getUser()) && $this->get('security.context')->getToken()->getUser()!=='anon.') {
            if(!$user) {
                $user = $this->get('iog.facebook.user')->loadUserByUsername(null);
            }
        }
//        if(isset($user) && $user instanceof \Duedinoi\UserBundle\Entity\User) {
//            $this->logUser($user);
//        }
        if(isset($user) && $user->hasRole('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('duedinoi_admin_homepage'));
        } 
        return $this->redirect($this->generateUrl('duedinoi_web_homepage'));
    }
    
    
    private function logUser($user) {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles()); // 'main' is the name of the firewall
        $this->container->get('security.context')->setToken($token);
    }
    
}
