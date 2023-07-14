<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class DeleteImageFrameController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit();
        }
        $success = $this->videoRepository->removeFrame($id);

        if ($success === true) {
            header('Location: /?sucesso=1');
        } else {
            header('Location: /?sucesso=0');
        }
    }
}