<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

interface AttestationServicesInterface
{

    public function store(Request $request): object;
}
