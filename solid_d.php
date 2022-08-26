<?php

interface HttpRequestInterface {
    public function request(string $url, array $options = []);
}

class XMLHttpService implements HttpRequestInterface {
    public function request(string $url, array $options = []) {}
}

class Http {
    private HttpRequestInterface $service;

    public function __construct(HttpRequestInterface $xmlHttpService) {
        $this->service = $xmlHttpService;
    }

    public function get(string $url, array $options) {
        $this->service->request($url, 'GET', $options);
    }

    public function post(string $url) {
        $this->service->request($url, 'GET');
    }
}