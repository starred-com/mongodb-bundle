<?php

declare(strict_types=1);

namespace Facile\MongoDbBundle\Services\Loggers\Model;

/**
 * Class LogEvent.
 */
class LogEvent
{
    /** @var float */
    private $start;

    /** @var string */
    private $method;

    /** @var string */
    private $collection;

    /** @var array */
    private $data;

    /** @var int */
    private $executionTime;

    /**
     * LogEvent constructor.
     */
    public function __construct()
    {
        $this->start = 0.0;
        $this->collection = 'undefined';
        $this->method = 'undefined';
        $this->data = [];
        $this->executionTime = 0;
    }

    /**
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * @param float $start
     */
    public function setStart(float $start)
    {
        $this->start = $start;
    }

    /**
     * @return string
     */
    public function getCollection(): string
    {
        return $this->collection;
    }

    /**
     * @param string $collection
     */
    public function setCollection(string $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getDataJson(): string
    {
        return json_encode($this->data);
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $this->prepareUnserializableData($data);
    }

    /**
     * @return float
     */
    public function getExecutionTime(): float
    {
        return $this->executionTime;
    }

    /**
     * @param float $executionTime
     */
    public function setExecutionTime(float $executionTime)
    {
        $this->executionTime = $executionTime;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function prepareUnserializableData(array $data): array
    {
        foreach ($data as $key => $item) {

            if (method_exists($item, 'getArrayCopy')) {
                $data[$key] = $this->prepareUnserializableData($item->getArrayCopy());
            }

            if (method_exists($item, '__toString')) {
                $data[$key] = $item->__toString();
            }

            if (is_array($item)) {
                $data[$key] = $this->prepareUnserializableData($item);
            }

            if ($item instanceof \Serializable) {
                continue;
            }

        }

        return $data;
    }
}

