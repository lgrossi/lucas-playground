<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

use JetBrains\PhpStorm\Pure;

class EventCallbackHandler extends AbstractHandler
{
    public const EVENT_CALLBACK = "event_callback";

    public function handle(): void
    {
        $this->reply($this->getCallbackHandler());
    }

    #[Pure] private function getCallbackHandler(): string
    {
        return match ($this->event->event->type) {
            EventCallbackType::MESSAGE => $this->messageCallback(),
            EventCallbackType::WORKFLOW_STEP_EXECUTE => $this->workflowStepExecuteCallback(),
            default => '{ "code": 400, "message": "Callback type not supported" }'
        };
    }

    private function messageCallback(): string
    {
        error_log("{$this->event->event->text}");
        error_log("{$this->event->event->user}");
        error_log("{$this->event->event->channel_type}");
        return '{ "message": true }';
    }

    private function workflowStepExecuteCallback(): string
    {
        error_log("{$this->event->event->callback_id}");
        return '{ "workflow": true }';
    }
}
