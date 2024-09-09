<?php
namespace App\Interfaces;

interface ProviderInterface {
    public function getAllProvidersByCustomer($request);
    public function getLastProviderByCustomer($request);
}
