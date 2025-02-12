<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CampaingRepositoryInterface
{
    public function getAllCampaings(): Collection;
}
