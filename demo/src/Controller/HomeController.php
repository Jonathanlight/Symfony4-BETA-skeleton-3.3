<?php
namespace App\Controller;

#Composant Symfony
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

#Entity
use App\Entity\Product;

#Form
use App\Form\ProductType;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('App:Product');
        $reponses = $repository->findAll();

        $product = new Product();
        $product->setName('');
        $product->setPrice('');
        $product->setDescription('');

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('page/home.html.twig', ['reponses'=>$reponses, 'form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction(Request $request)
    {
        $session = new Session();
        $session->start();

        $id = $request->get('id');
        $repository = $this->getDoctrine()->getRepository('App:Product');
        $reponse = $repository->find($id);

        if ($reponse){
            $em = $this->getDoctrine()->getManager();
            $em->remove($reponse);
            $em->flush();
            $session->getFlashBag()->add('notice', 'Product delete');
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editAction(Request $request)
    {
        $session = new Session();
        $session->start();

        $id = $request->get('id');
        $repository = $this->getDoctrine()->getRepository('App:Product');
        $product = $repository->find($id);


        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('page/edit.html.twig', ['reponse'=>$product, 'form' => $form->createView()]);
    }

    /**
     * @Route("/other", name="other")
     */
    public function otherAction(Request $request)
    {
        return $this->render('page/other.html.twig', []);
    }

}