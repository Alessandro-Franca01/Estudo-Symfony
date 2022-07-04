<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class ExemploController extends AbstractController
{
    /**
    * @Route("/hello/")
    */
    public function helloByName(): Response
    {
        //$number = random_int(0, 100);
        $name = 'Alessandro de França';

        return new Response(
            '<html><body>Hello: '.$name.'</body></html>'
        );
    }

    /**
    * @Route("/home/{nome}")
    */
    public function home(string $nome): Response
    {
        $userFirstName = $nome;
        $frameWork = 'Symfony';

        // the template path is the relative file path from `templates/`
        return $this->render('home/page.html.twig', [
            'user_first_name' => $userFirstName,
            'frame_work' => $frameWork,
        ]);
    }




}
