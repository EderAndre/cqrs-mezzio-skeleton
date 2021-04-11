<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS;

class ConfigProvider
{

    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates()
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories' => [],
            'services' => []
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => [
                    __DIR__ . '/./resources/templates/app'
                ],
                'error' => [
                    __DIR__ . '/./resources/templates/error'
                ],
                'layout' => [
                    __DIR__ . '/./resources/templates/layout'
                ]
            ]
        ];
    }
}
