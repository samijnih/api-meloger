<?php

namespace Controllers;

use Services\Selenium\SeLogerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    /**
     * @var SeLogerService
     */
    private $selogerService;


    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(SeLogerService $selogerService)
    {
        $this->selogerService = $selogerService;
    }

    /**
     * Indexes user's data.
     * 
     * @param  Request
     *
     * @return JsonResponse
     */
    public function indexData(Request $request) : JsonResponse
    {
        $this->selogerService->login(
            $request->get('email'),
            $request->get('password')
        );

        return new JsonResponse([
            'version' => '1.0.0-dev',
            'status' => 'success',
        ]);
    }
}
