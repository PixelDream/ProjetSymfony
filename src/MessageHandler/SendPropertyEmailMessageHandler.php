<?php

namespace App\MessageHandler;

use App\Message\SendPropertyEmailMessage;
use App\Repository\ResearchRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;

final class SendPropertyEmailMessageHandler implements MessageHandlerInterface
{

    private ResearchRepository $researchRepository;
    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(ResearchRepository $researchRepository, MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->researchRepository = $researchRepository;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * Send an email to the user with the properties he has saved.
     * @param SendPropertyEmailMessage $message
     * @return void
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendPropertyEmailMessage $message)
    {
        $property = $message->getProperty();

        // fetch all research in database and compare with property
        $research = $this->researchRepository->findBySameProperty($property);

        $emails = [];

        foreach ($research as $item) {
            var_dump($item->getEmail());
            $emails[] = $item->getEmail();
        }

        $this->logger->info('SendPropertyEmailMessageHandler: ' . count($emails) . ' emails found');

        // check if $emails array is empty
        if (empty($emails)) return;

        foreach ($emails as $email) {
            $this->logger->info('SendPropertyEmailMessageHandler: send email to ' . $email);
        }

        // send email to all emails with property information and link to property
        $email = (new TemplatedEmail())
            ->from(new Address('no_reply@safer.fr', 'Safer'))
            ->to(...$emails)
            ->subject('Un nouveau bien correspond à votre recherche')
            ->htmlTemplate('emails/new_research_email.html.twig')
            ->context([
                'property' => $property,
                'research' => $research[0]
            ]);

        $this->mailer->send($email);
    }
}
