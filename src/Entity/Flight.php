<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 * @ORM\Table(name="flights")
 */
class Flight implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $from;

    /**
     * @ORM\Column(type="string")
     */
    private string $to;

    /**
     * @ORM\Column(name="departure_time", type="datetimetz_immutable")
     */
    private \DateTimeImmutable $departureTime;

    /**
     * @ORM\Column(name="arrival_time", type="datetimetz_immutable")
     */
    private \DateTimeImmutable $arrivalTime;

    /**
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @ORM\Column(name="booking_token", type="text", unique=true)
     */
    private string $bookingToken;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'departure_time' => $this->departureTime->format('Y-m-d H:i:s'),
            'arrival_time' => $this->arrivalTime->format('Y-m-d H:i:s'),
            'price' => $this->price
        ];
    }
}
