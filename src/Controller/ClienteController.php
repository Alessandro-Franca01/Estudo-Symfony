<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cliente;

class ClienteController extends AbstractController
{
    #[Route('/clientes', name: 'clientes')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Pegar os dados dos clientes:
        $clientes = $doctrine->getRepository(Cliente::class)->findAll();

        return $this->render('cliente/index.html.twig', [
            'clientes' => $clientes,
        ]);
    }

    #[Route('/clientes/create/', name: 'create_cliente')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
    	$cliente = new Cliente();

    	$form = $this->createFormBuilder($cliente)
    		->add('nome', TextType::class, ['required' => true, 'label' => "Nome"])
            ->add('idade', IntegerType::class, ['label' => "Idade"])
            ->add('email', IntegerType::class, ['label' => "Email"])
            ->add('save', SubmitType::class, ['label' => "Salvar"])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	
        	$cliente = new Cliente();
        	$cliente = $form->getData();
        
        	$entityManager = $doctrine->getManager();
        	// Levantando 1 Exeption de 'ProdutoRepository' não existe!
            $entityManager->persist($cliente);
            $entityManager->flush();

            $this->addFlash(
	            'notice',
	            'Produto salvo com sucesso!'
        	);
            
            return $this->redirectToRoute('clientes');
        }

        return $this->renderForm("cliente/create.html.twig", [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/cliente/create", name="create_cliente_antigo")
     */
    public function createOld(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $cliente = new Cliente();
        $cliente->setNome('Alessandro');
        $cliente->setIdade(33);
        //$product->setEmail();

        $entityManager->persist($cliente);
        $entityManager->flush();

        return new Response('Cliente salvo, seu ID:'.$cliente->getId());
    }
}
