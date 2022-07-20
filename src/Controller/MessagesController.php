<?php

namespace App\Controller;

use App\Form\MessageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Turbo\Stream\TurboStreamResponse;

class MessagesController extends AbstractController
{
    
    
    #[Route('/contact', name: 'app_contact')]
    
    
    public function new(Request $request): Response
    {
        
        
        $form = $this->createForm(MessageType::class);

        
        
        $emptyForm = clone $form;

        
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()){
            
            
            // send email
            
            
            $data = $form->getData();

            
            
            dump(sprintf('Incoming mail from %s <%s>...', $data['name'], $data['email']));

            
            // if (str_contains($request->headers->get('accept'), 'text/vnd.turbo-stream.html')){
            
            
            if (TurboStreamResponse::STREAM_FORMAT === $request->getPreferredFormat()) {



            //     $response = new Response;
            //     $response->setContent(
            //         $this->renderView('messages/success.stream.html.twig', [
            //             'name' => $data['name'],
            //             'form' => $emptyForm->createView()
            //         ])
            //     );

            //     $response->headers->set('Content-Type', 'text/vnd.turbo-stream.html');
            //     return $response;
                            
            // }



                return $this->render('messages/success.stream.html.twig', [

                    
                    'name' => $data['name'],

                    
                    'form' => $emptyForm->createView()

                
                ], new TurboStreamResponse);
            
            }

            
            $this->addFlash('success', "message sent! We'll get back to you very soon.");

            
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        
        
        
        }




        // if ($form->isSubmitted() && !$form->isValid()){
        //     $response = new Response;
        //     $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

        //     return $this->render('messages/new.html.twig', [
        //         'form' => $form->createView()
        //     ], $response);

        // }




        return $this->renderForm('messages/new.html.twig', [
            'form' => $form,


        ]);


    }


}
