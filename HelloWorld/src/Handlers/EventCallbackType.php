<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

use MyCLabs\Enum\Enum;

/**
 * @method static Action APP_MENTION()
 * @method static Action MESSAGE()
 * @method static Action WORKFLOW_STEP_EXECUTE()
 */
class EventCallbackType extends Enum
{
    public const APP_MENTION = "app_mention";
    public const MESSAGE = "message";
    public const WORKFLOW_STEP_EXECUTE = "workflow_step_execute";
}
