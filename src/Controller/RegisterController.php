<?php


namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Trip;
use App\Enums\StateTypeEnum;
use App\Exception\InvalidArgumentException;
use App\Services\Trip\Register;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", methods={"GET"})
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws InvalidArgumentException
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('/');
        }

        if (!($id = $request->query->get('id'))) {
            throw new InvalidParameterException(sprintf('%s not exist', $request->query->get('id')));
        }

        if (!($idTrip = $request->query->get('id_trip'))) {
            throw new InvalidParameterException(sprintf('%s not exist', $request->query->get('id_trip')));
        }

        /** @var Participant $participant */
        $participant = $entityManager->getRepository(Participant::class)->find($id);
        /** @var Trip $trip */
        $trip = $entityManager->getRepository(Trip::class)->find($idTrip);


        if ($this->tripValidForRegistry($trip)) {
            Register::subscribe($participant, $trip);
        }

        return new Response('TODO: set message succes when user register on trip');
    }

    /**
     * @param Trip $trip
     * @return bool
     * @throws Exception
     */
    public function tripValidForRegistry(Trip $trip): bool
    {
        return ($trip->getState() !== StateTypeEnum::getAvailableTypes()[1] && new DateTime('now') < $trip->getEndDate(
            ));
    }
}
