<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RedirectController extends AbstractController
{
   #[Route('/redirect', name: 'app_redirect')]
public function redirectAfterLogin(): Response
{
    if ($this->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('admin_dashboard');
    }

    return $this->redirectToRoute('user_dashboard');
}
}