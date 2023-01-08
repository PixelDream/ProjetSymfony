<?php

namespace App\MessageHandler;

use App\Message\SendPropertiesEmailMessage;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;

final class SendPropertiesEmailMessageHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * Send an email to the user with the properties he has saved.
     * @param SendPropertiesEmailMessage $message
     * @return void
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendPropertiesEmailMessage $message)
    {
        $properties = $message->getProperties();
        $emailAdress = $message->getEmail();

        $this->logger->info('SendPropertiesEmailMessageHandler: ' . count($properties) . ' properties found => ' . $emailAdress);

        // send email to all emails with property information and link to property
        $email = (new TemplatedEmail())
            ->from(new Address('no_reply@safer.fr', 'Safer'))
            ->to($emailAdress)
            ->subject('Votre liste de biens')
            ->htmlTemplate('emails/properties_email.html.twig')
            ->context([
                'properties' => $properties
            ]);

        $this->mailer->send($email);
    }
}
