<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers\FFS\Traits;

trait TeamFinancialServicesTrait
{
    final protected function getTeamId(): string
    {
        return "ffs";
    }
}
