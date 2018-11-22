<?php

namespace KRG\MessageBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use KRG\MessageBundle\Entity\Blacklist;
use KRG\MessageBundle\Entity\BlacklistInterface;
use KRG\MessageBundle\Form\Type\BlacklistType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message/blacklist")
 */
class BlacklistController extends Controller
{
    /**
     * @Route("/unsubscribe/{address}/{message}/{token}")
     */
    public function unsubscribeAction(Request $request, $address, $message, $token)
    {
        if ($token !== self::tokenize($address, $message, $this->getParameter('secret'))) {
            throw $this->createAccessDeniedException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        try {
            $blacklist = $entityManager->getClassMetadata(BlacklistInterface::class)->getReflectionClass()->newInstance();
            $blacklist->setAddress($address);
            $blacklist->setMessage($message);
            $entityManager->persist($blacklist);
            $entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {}

        // Nous avons bien enregistré votre demande de désabonnement
        $request->getSession()->getFlashBag()->add('success', 'message.blacklist.unsubscriped');

        return $this->redirect('/');
    }

    /**
     * @Route("/edit/{address}")
     */
    public function editAction(Request $request, $address)
    {
        $form = $this->createFormBuilder()
                            ->add('blacklist', BlacklistType::class, ['address' => Blacklist::canonicalize($address)])
                            ->add('submit', SubmitType::class)
                        ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $blacklists = $form->get('blacklist')->getData();
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'message.blacklist.success');
        }

        return $this->render('KRGMessageBundle:Blacklist:edit.html.twig', ['address' => $address, 'form' => $form->createView()]);
    }

    static public function tokenize(string $address, string $message, string $secret)
    {
        return sha1(sprintf('%s:%s:%s', Blacklist::canonicalize($address), $secret, $message));
    }
}