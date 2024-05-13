<?php
namespace App\Interfaces;

interface ClientInterface
{
    public function index();
    public function saveClient($request);
    public function asignAgent($request);
    public function assignGroupAgent($request);
    public function changeStatusClient($request);
    public function updateClient($request);
    public function deleteClient($request);
    public function profileClient($id);
}
