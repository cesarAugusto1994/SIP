<?php


namespace Inspector\Models;


abstract class AbstractModel implements \JsonSerializable
{
    /**
     * @var float
     */
    protected $timestamp;

    /**
     * Number of milliseconds until Span ends.
     *
     * @var float
     */
    protected $duration = 0.0;

    public abstract function getContext();

    /**
     * @return float
     */
    public function getTimestamp(): float
    {
        return $this->timestamp;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function start($time = null): AbstractModel
    {
        $this->timestamp = is_null($time) ? microtime(true) : $time;
        return $this;
    }

    public function end($duration = null): AbstractModel
    {
        $this->duration = $duration ?? round((microtime(true) - $this->timestamp)*1000, 2); // milliseconds
        return $this;
    }

    /**
     * Array representation.
     *
     * @return array
     */
    public abstract function toArray(): array;

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * String representation.
     *
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}