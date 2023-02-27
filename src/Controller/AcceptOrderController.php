<?php
namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * Controller for Acceptance of a order
 * a part of Order API
 */
#[AsController]
class AcceptOrderController extends AbstractController
{
    public function __invoke(
        string $id, 
        Request $request, 
        OrderRepository $repository,
        MailerInterface $mailer
    ): Order
    {
        $order = $repository->find($id, $lockMode = true);
        /* Update the day of Accepted */
        $body = json_decode($request->content);
        if (property_exists($body, 'acceptedAt'))
            /* Pointed */
            $order->acceptedAt = $body->acceptedAt;
        else
            /* Now */    
            $order->acceptedAt = new \DateTimeImmutable();

        $repository->save($order);
        /* 
         * A notification of a order accepted
         * From: Maker
         * To:   Agent
         */
        $to = $order->getSite()->getAgent()->getUser()->getEmail();
        $email = (new TemplatedEmail())
            ->from($this->getParameter('maker.email'))
            ->to($to)
            ->bcc($this->getUser()->getUserIdentifier(), $this->getParameter('maker.email_bcc'))
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->htmlTemplate('emails/order_accepted.html.twig')
            ->context([
                'order' =>$order
            ]);
        $mailer->send($email);
        return $order;
    }
}