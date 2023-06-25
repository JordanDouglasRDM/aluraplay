<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

use http\Exception\InvalidArgumentException;

class Video
{
    public readonly string $url;
    public readonly int $id;
    public function __construct(
        string $url,
        public readonly string $title,
    )
    {
        $this->setUrl($url);
    }
    private function setUrl(string $url)
    {
        if (filter_input(INPUT_GET, 'url') === false) {
            throw new InvalidArgumentException();
        }

        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
}