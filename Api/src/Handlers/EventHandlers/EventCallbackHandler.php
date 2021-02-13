<?php declare(strict_types=1);

namespace Api\Handlers\EventHandlers;

use Api\Handlers\AbstractHandler;
use JetBrains\PhpStorm\Pure;

class EventCallbackHandler extends AbstractHandler
{
    public const EVENT_CALLBACK = "event_callback";

    final public function __construct(protected Object $event) {}

    public function handle(): void
    {
        $this->reply($this->getCallbackHandler());
    }

    #[Pure] private function getCallbackHandler(): string
    {
        return match ($this->event->event->type) {
            EventCallbackType::APP_MENTION => $this->appMentionCallback(),
            EventCallbackType::MESSAGE => $this->messageCallback(),
            EventCallbackType::WORKFLOW_STEP_EXECUTE => $this->workflowStepExecuteCallback(),
            default => '{ "code": 400, "message": "Callback type not supported" }'
        };
    }

    /**
     * https://api.slack.com/events/message.channels
     */
    private function appMentionCallback(): string
    {
        return '{ "app_mention": true }';
    }

    /**
     * https://api.slack.com/events/message.channels
     */
    private function messageCallback(): string
    {
        return '{ "message": true }';
    }

    /**
     * https://api.slack.com/events/workflow_step_execute
     */
    private function workflowStepExecuteCallback(): string
    {
        return '{ "workflow": true }';
    }
}
