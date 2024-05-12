<?php

namespace App\Interfaces;

interface AgentInterface
{
    public function index();

    public function searchAgent($request);

    public function saveAgent($requestData);

    public function updateAgent($requestData);

    public function cambiarEstadoAgente($agentId, $status);

    public function eliminarAgente($agentId);

    public function saveNumberTurns($agentId, $cantidad);

    public function uploadImg($request);

    public function changePassword($request);

    public function filterAgent($request);
}
