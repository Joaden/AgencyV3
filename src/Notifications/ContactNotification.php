<?php
namespace App\Notifications;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment;
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        // instance de swiftmessage + nom du bien
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
        // sender
        ->setFrom('noreply@agence.fr')
        // destinataire
        ->setTo('contact@agence.fr')
        // Email de l'utilisateur
        ->setReplyTo($contact->getEmail())
        // injection du html
        ->setBody($this->renderer->render('emails/contact.html.twig', [
            'contact' => $contact
        ]), 'text/html');
        $this->mailer->send($message);
    }

}