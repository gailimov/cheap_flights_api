<?php

namespace App\Controller;

use App\Repository\FlightRepository;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Annotation\Route;

class FlightsController
{
    use ControllerTrait;

    private FlightRepository $flightRepository;

    public function __construct(FlightRepository $flightRepository)
    {
        $this->flightRepository = $flightRepository;
    }

    /**
     * @Route("/flights", methods={"GET"}, name="flights_list")
     */
    public function index(Request $request): JsonResponse
    {
        $flyFrom = $request->query->get('fly_from');
        $flyTo = $request->query->get('fly_to');
        $dateFrom = $request->query->get('date_from');
        $dateTo = $request->query->get('date_to');

        if (!$flyFrom || !$flyTo || !$dateFrom || !$dateTo) {
            return $this->errorResponse(400, 'Required parameters not specified');
        }

        if (!$this->isDateValid($dateTo) || !$this->isDateValid($dateTo)) {
            return $this->errorResponse(400, 'Invalid date');
        }

        $flights = $this->flightRepository->getByDates($flyFrom, $flyTo, $dateFrom, $dateTo);

        return new JsonResponse($flights);
    }

    private function isDateValid(string $date): bool
    {
        return (bool) \DateTime::createFromFormat('d/m/Y', $date);
    }
}
