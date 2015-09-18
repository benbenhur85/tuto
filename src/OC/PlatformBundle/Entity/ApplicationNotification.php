<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OC\PlatformBundle\Entity\Application;

/**
 * ApplicationNotification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\ApplicationNotificationRepository")
 */
class ApplicationNotification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer", type="string", length=255)
     */
    private $mailer;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mailer
     *
     * @param string $mailer
     *
     * @return ApplicationNotification
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * Get mailer
     *
     * @return string
     */
    public function getMailer()
    {
        return $this->mailer;
    }

     public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getEntity();

    // On veut envoyer un email que pour les entités Application
    if (!$entity instanceof Application) {
      return;
    }

    $message = new \Swift_Message(
      'Nouvelle candidature',
      'Vous avez reçu une nouvelle candidature.'
    );
    
    $message
      ->addTo($entity->getAdvert()->getAuthor()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->addFrom('admin@votresite.com')
    ;

    $this->mailer->send($message);
  }
}

