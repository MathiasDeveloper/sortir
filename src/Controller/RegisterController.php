<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Trip;
use App\Entity\Participant;
use App\Enums\StateTypeEnum;
use App\Services\Trip\Register;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="registerTrip", methods={"GET"})
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     * @throws Exception
     *
     * @throws InvalidArgumentException
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('/');
        }

        if (!($id = $request->query->get('id'))) {
            throw new InvalidParameterException(sprintf('%s not exist', $id));
        }

        if (!($idTrip = $request->query->get('id_trip'))) {
            throw new InvalidParameterException(sprintf('%s not exist', $idTrip));
        }

        /** @var Participant $participant */
        $participant = $entityManager->getRepository(Participant::class)->find($id);
        /** @var Trip $trip */
        $trip = $entityManager->getRepository(Trip::class)->find($idTrip);

        if ($this->tripValidForRegistry($trip)) {
            Register::subscribe($participant, $trip);
            $entityManager->flush();
        }

        return $this->redirect('/sorties');
    }

    /**
     * @Route("/unsubscribe", name="unsubscribeTrip", methods={"GET"})
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     * @throws Exception
     *
     * @throws InvalidArgumentException
     */
    public function unsubscribe(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('/');
        }

        if (!($id = $request->query->get('id'))) {
            throw new InvalidParameterException(sprintf('%s not exist', $id));
        }

        if (!($idTrip = $request->query->get('id_trip'))) {
            throw new InvalidParameterException(sprintf('%s not exist', $idTrip));
        }

        /** @var Participant $participant */
        $participant = $entityManager->getRepository(Participant::class)->find($id);
        /** @var Trip $trip */
        $trip = $entityManager->getRepository(Trip::class)->find($idTrip);

        if ($this->tripValidForRegistry($trip)) {
            Register::unsubscribe($participant, $trip);
            $entityManager->flush();
        }

        return $this->redirect('/sorties');
    }

    /**
     * @param Trip $trip
     *
     * @return bool
     * @throws Exception
     *
     */
    public function tripValidForRegistry(Trip $trip): bool
    {
        return $trip->getState() !== StateTypeEnum::getAvailableTypes()[1] && new DateTime('now') < $trip->getEndDate();
    }
}
