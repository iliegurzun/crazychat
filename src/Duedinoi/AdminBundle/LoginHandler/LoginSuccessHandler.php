<?php

namespace Duedinoi\AdminBundle\LoginHandler;
 
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
 
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
            if ($this->security->isGranted('ROLE_ADMIN')) {
                $response = new RedirectResponse($this->router->generate('duedinoi_admin_homepage'));			
            }
            else {
                $response = new RedirectResponse($this->router->generate('duedinoi_dashboard'));
            }

            return $response;
    }

    private function matchRoute(Request $request)
    {
        $referer = $request->headers->get('referer');
        $baseUrl = $request->getBaseUrl();
        $locale = $request->get('_locale');
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
        $lastPath = str_replace('/'.$locale, '', $lastPath);

        return $lastPath;
    }
}
