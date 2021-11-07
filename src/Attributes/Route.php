<?php

namespace MayMeow\Routing\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    /**
     * @var string $uri url to your action, starts with slash
     */
    protected string $uri;

    /**
     * @var string $action Action Name
     */
    protected string $action;

    /** @var array<string> $options */
    protected array $options;

    public function __construct(string $uri, ?string $action = null, ?array $options = [])
    {
        $this->uri = $uri;
        $this->options = $options;

        if (!is_null($action)) {
            $this->action = $action;
        }
    }

    /**
     * @return string Uri to the action
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string Action name
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string Uri
     */
    public function __toString(): string
    {
        return $this->getUri();
    }

    /**
     * Allow setting action name in already initialized Route instance
     *
     * @param string $action Action Name
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string[]
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

}
