<?php

namespace App\Task;

use App\Entity\Projet;
use App\Message\ProjectDeadlineNotification;
use App\Message\RappelDeadline;
use App\MessageHandler\RappelDeadlineHandler;
use App\Repository\ProjetRepository;
use DateTime;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendProjectDeadlineNotificationTask
{
    private MessageBusInterface $bus;
    private $projetRepository;
    private Projet $projets;
    private MailerInterface $mailer;
    public function __construct(MessageBusInterface $bus, ProjetRepository $projetRepository, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->bus = $bus;
        $this->projetRepository = $projetRepository;
    }

    public function __invoke()
    {
        // Fetch projects from the database (pseudo-code)
        $dn = new \DateTime();
        $dn->modify('+7 day');
        $projets = $this->projetRepository->findProjetsDeadline($dn);

        foreach ($projets as $projet) {
            $this->bus->dispatch(new RappelDeadlineHandler($this->mailer, $this->projetRepository));
        }
    }
}
