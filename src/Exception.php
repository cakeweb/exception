<?php

namespace CakeWeb;

class Exception extends \Exception
{
    public $extra;

    public function __construct($message, $code, Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->code = $code;
    }

    public static function new(string $messageOrConst, string $code, array $params = []): self
    {
        // HTTP Status Code
        if($params['http'] ?? null)
        {
            HttpStatusCode::set($params['http']);
        }

        // Exception message (support i18n)
        $message = $messageOrConst;
        if($params['i18n'] ?? null)
        {
            $vars = is_bool($params['i18n'])
                ? null
                : $params['i18n'];
            $message = \CakeWeb\I18n::_($messageOrConst, $vars);
        }

        // Creates exception instance
        $e = new self($message, $code);
        if($params['focus'] ?? null)
        {
            $focus = is_string($params['focus'])
                ? [$params['focus']]
                : $params['focus'];
            $e->extra = [
                'focus' => $focus
            ];
        }
        return $e;
    }
}
