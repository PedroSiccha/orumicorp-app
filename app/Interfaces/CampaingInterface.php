<?php
namespace App\Interfaces;

interface CampaingInterface {
    public function getAllCampaingsByCustomer($request);
    public function getLastCampaingByCustomer($request);
}
