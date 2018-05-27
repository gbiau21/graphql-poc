<?php

namespace App\Vehicle\Infra\Repository;

use App\Common\Infra\Repository\DataRepository;
use App\Vehicle\App\Query\VehiclesQuery;
use App\Person\Domain\Person;

class VehicleRepository
{
    /**
     * @param Person $person
     * @return array
     */
    public function findByPerson(Person $person): array
    {
        if (array_key_exists($person->getId(), DataRepository::getVehiclesByPersons())) {
            return DataRepository::getVehiclesByPersons()[$person->getId()];
        }

        return [];
    }

    /**
     * @return array
     */
    public function findAll(VehiclesQuery $query): array
    {
        $vehicles = DataRepository::getVehicles();

        if ($query->hasPersonId()) {
            if (array_key_exists($query->getPersonId(), DataRepository::getVehiclesByPersons())) {
                $vehicles = DataRepository::getVehiclesByPersons()[$query->getPersonId()];
            } else {
                $vehicles = [];
            }
        }

        if ($query->hasVehicleId()) {
            $search = $query->getVehicleId();

            return array_filter(
                $vehicles,
                function ($e) use ($search) {
                    return $e->getId() == $search;
                }
            );
        }

        return $vehicles;
    }
}
