<?php

namespace UseStoriesBundle\Controller;

use UseStoriesBundle\Entity\Person;
use UseStoriesBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Person controller.
 *
 * @Route("person")
 */
class PersonController extends Controller
{
    /**
     * Lists all person entities.
     *
     * @Route("/", name="person_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $people = $em->getRepository('UseStoriesBundle:Person')->findAll();

        

        return $this->render('person/index.html.twig', array(
            'people' => $people,
           
        ));
    }

    /**
     * Creates a new person entity.
     *
     * @Route("/new", name="person_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('UseStoriesBundle\Form\PersonType', $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush($person);

           // return $this->redirectToRoute('person_show', array('id' => $person->getId()));
        }
        $address = new Address();
        $address->setPerson($person);
        $form_address = $this->createForm('UseStoriesBundle\Form\AddressType', $address);
        $form_address->handleRequest($request);

        if ($form_address->isSubmitted() && $form_address->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush($address);

           // return $this->redirectToRoute('address_show', array('id' => $address->getId()));
        }

        return $this->render('person/new.html.twig', array(
            'person' => $person,
            'address'=>$address,
            'form' => $form->createView(),
            'form_address' => $form_address->createView(),
        ));
    }

    /**
     * Finds and displays a person entity.
     *
     * @Route("/{id}", name="person_show")
     * @Method("GET")
     */
    public function showAction(Person $person)
    {
        $deleteForm = $this->createDeleteForm($person);

        return $this->render('person/show.html.twig', array(
            'person' => $person,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing person entity.
     *
     * @Route("/{id}/edit", name="person_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Person $person)
    {
        $addressrepository = $this->getDoctrine()->getRepository('UseStoriesBundle:Address');

       $address  = $addressrepository->findOneByPerson($person);
        
        $deleteForm = $this->createDeleteForm($person);
        $editForm = $this->createForm('UseStoriesBundle\Form\PersonType', $person);
        $addressForm = $this->createForm('UseStoriesBundle\Form\AddressType',$address);
        
        $editForm->handleRequest($request);
        $addressForm->handleRequest($request);
           

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('person_edit', array('id' => $person->getId()));
        }
        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('address_edit', array('id' => $address->getId()));
        }

        return $this->render('person/edit.html.twig', array(
            'person' => $person,
            'edit_form' => $editForm->createView(),
            'address_form' => $addressForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a person entity.
     *
     * @Route("/{id}", name="person_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Person $person)
    {
        $form = $this->createDeleteForm($person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($person);
            $em->flush($person);
        }

        return $this->redirectToRoute('person_index');
    }

    /**
     * Creates a form to delete a person entity.
     *
     * @param Person $person The person entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Person $person)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('person_delete', array('id' => $person->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
