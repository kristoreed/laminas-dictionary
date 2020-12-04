<?php

namespace Kristoreed\Laminas\Dictionary\Repository;

use Kristoreed\Laminas\DbManager\Query\Executor\Interfaces\ExecutorInterface as QueryExecutorInterface;
use Kristoreed\Laminas\Dictionary\Repository\Interfaces\DictionaryInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Expression;

/**
 * Class Dictionary
 *
 * @package Kristoreed\Laminas\Dictionary\Repository
 * @author Krzysztof Trzcinka <krzysztof.trzcinka@gmail.com>
 */
abstract class Dictionary implements DictionaryInterface
{
    /**
     * @var string
     */
    protected $tableName = 'dictionary';

    /**
     * @var QueryExecutorInterface
     */
    protected $queryExecutor;

    /**
     * Contractor constructor
     *
     * @param QueryExecutorInterface $queryExecutor
     */
    public function __construct(
        QueryExecutorInterface $queryExecutor
    )
    {
        $this->queryExecutor = $queryExecutor;
    }

    /**
     * @inheritDoc
     */
    public function getElementById(int $elementId): array
    {
        $select = new Select();
        $select->from(['d' => $this->tableName])
            ->columns(['*'])
            ->where(['id' => $elementId]);

        return $this->queryExecutor->getRow($select);
    }

    /**
     * @inheritDoc
     */
    public function getElementsCount(): int
    {
        $select = new Select();
        $select->from(['d' => $this->tableName])
            ->columns(['total' => new Expression('count(*)')]);

        return $this->queryExecutor->getOne($select);
    }

    /**
     * @inheritDoc
     */
    public function getElements(): array
    {
        $select = new Select();
        $select->from(['d' => $this->tableName])
            ->columns(['*']);

        return $this->queryExecutor->getRows($select);
    }

    /**
     * @inheritDoc
     */
    public function addElement(array $element): array
    {
        $elementId = $this->queryExecutor->insert($this->tableName, $element);
        if (empty($elementId)) {
            return [];
        }

        return $this->getElementById($elementId);
    }

    /**
     * @inheritDoc
     */
    public function editElement(int $elementId, array $element): int
    {
        return $this->queryExecutor->update($this->tableName, $element, [
            'id' => $elementId
        ]);

    }

    /**
     * @inheritDoc
     */
    public function deleteElement(int $elementId): int
    {
        return $this->queryExecutor->delete($this->tableName, [
            'id' => $elementId
        ]);
    }
}