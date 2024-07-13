<?php
namespace App\Interfaces;

interface ComunicationInterface {
    public function saveComunication($request);
    public function updateComunication($request);
    public function getLocationByAgent($request);
    public function getLocationByCustomer($request);
}
