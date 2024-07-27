<?php

namespace App\MessageHandler;

use App\Message\RappelDeadline;
use App\Repository\ProjetRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

#[AsMessageHandler]
class RappelDeadlineHandler

{
    private MailerInterface $mailer;
    private $projetRepository;
    private $bus;

    public function __construct(MailerInterface $mailer, ProjetRepository $projetRepository)
    {
        $this->mailer = $mailer;
        $this->projetRepository = $projetRepository;
    }
    public function __invoke(RappelDeadline $msg, MailerInterface $mailer): void
    {
        $IDprojet = $msg->getId();
        $projets = $this->projetRepository->find($IDprojet);
        //$to = 'you@example.com';
        $to = 'allouchewafa@gmail.com';
        foreach ($projets as $projet) {

            $email = (new Email())
                ->from('your-email@example.com')
                ->to($to)

                ->subject('RAPPEL')
                ->text("La date limite de projet" . $projet->getNom() . "est dans 7jours");

            $this->mailer->send($email);
            //$this->notificationService->notify('The deadline for project ' . $projet->getNom() . ' is approaching.');
            /* } else {
            $email = (new Email())
                ->from('hello@example.com')
                ->to($to)

                ->subject('RAPPEL')
                ->text("il n y a aucun projet");

            $mailer->send($email);
            //$this->notificationService->notify('il n y a aucun projet');
        } */
        }
    }
}
