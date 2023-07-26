<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteImageFrameController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            $this->addErrorMessage('ID inválido');
            return new Response(302,[
                'Location' => '/'
            ]);
        }
        $success = $this->videoRepository->removeFrame($id);

        if ($success === true) {
            return new Response(302,[
                'Location' => '/'
            ]);
        } else {
            $this->addErrorMessage('Erro ao remover frame');
            return new Response(302,[
                'Location' => '/'
            ]);
        }
    }
}