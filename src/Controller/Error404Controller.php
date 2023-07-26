<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Error404Controller implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->addErrorMessage('Página não encontrada');
        return new Response(404,[
            'Location' => '/'
        ]);
    }
}