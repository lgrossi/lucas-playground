<?php declare(strict_types=1);

namespace Api\Handlers\EventHandlers;

use MyCLabs\Enum\Enum;

/**
 * @method static EventCallbackType APP_MENTION()
 * @method static EventCallbackType MESSAGE()
 * @method static EventCallbackType WORKFLOW_STEP_EXECUTE()
 */
class EventCallbackType extends Enum
{
    public const APP_MENTION = "app_mention";
    public const MESSAGE = "message";
    public const WORKFLOW_STEP_EXECUTE = "workflow_step_execute";
}
