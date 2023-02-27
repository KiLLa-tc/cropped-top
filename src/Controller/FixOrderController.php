<?php
namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Controller for Fixing of a order
 * a part of Order API
 */
#[AsController]
class FixOrderController extends AbstractController
{
    public function __invoke(
        string $id, 
        Request $request, 
        OrderRepository $repository,
        MailerInterface $mailer
        ): Order
    {
        $order = $repository->find($id, $lockMode = true);
        /* Update the day of Ordered */
        $body = json_decode($request->content);
        if (property_exists($body, 'orderedAt'))
            /* Pointed */
            $order->orderedAt = $body->orderedAt;
        else
            /* Now */    
            $order->orderedAt = new \DateTimeImmutable();
        $repository->save($order);
        /* 
         * A notification of a order accepted
         * From: Agent
         * To:   Maker
         */
        return $order;
    }
}