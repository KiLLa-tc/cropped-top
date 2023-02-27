<?php
namespace App\Controller;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Controller for Fixing of a invoice
 * a part of Invoice API
 */
#[AsController]
class FixInvoiceController extends AbstractController
{
    public function __invoke(
        string $id,
        Request $request,
        InvoiceRepository $repository,
        MailerInterface $mailer
    ): Invoice
    {
        $invoice = $repository->find($id, $lockMode = true);
        /* Update the day of Published */
        $body = json_decode($request->content);
        if (property_exists($body, 'publishAt'))
            /* Pointed */
            $invoice->publishedAt = $body->publishAt;
        else
            /* Now */    
            $invoice->publishedAt = new \DateTimeImmutable();

        $repository->save($invoice);
        /* 
         * A notification of a order accepted
         * From: Maker
         * To:   Agent
         */
        $to = $invoice->getSite()->getAgent()->getUser()->getEmail();
        $email = (new TemplatedEmail())
            ->from($this->getParameter('maker.email'))
            ->to($to)
            ->bcc($this->getParameter('maker.email_bcc'))
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->htmlTemplate('emails/invoice_fixed.html.twig')
            ->context([
                'invoice' =>$invoice
            ]);
        $mailer->send($email);

        return $invoice;
    }
}