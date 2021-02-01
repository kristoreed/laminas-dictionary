<?php

namespace Kristoreed\Laminas\Dictionary\Repository\Interfaces;

use Kristoreed\Laminas\DbManager\Query\Executor\Exceptions\ExecutorException;

/**
 * Interface DictionaryInterface
 *
 * @package Kristoreed\Laminas\Dictionary\Repository\Interfaces
 * @author Krzysztof Trzcinka <krzysztof.trzcinka@gmail.com>
 */
interface DictionaryInterface
{
    /**
     * @param string $tableName
     *
     * @return DictionaryInterface
     */
    public function setTableName(string $tableName): DictionaryInterface;

    /**
     * @param int $elementId
     *
     * @return array
     *
     * @throws ExecutorException
     */
    public function getElementById(int $elementId): array;

    /**
     * @return int
     *
     * @throws ExecutorException
     */
    public function getElementsCount(): int;

    /**
     * @return array
     *
     * @throws ExecutorException
     */
    public function getElements(): array;

    /**
     * @param array $element
     *
     * @return array
     *
     * @throws ExecutorException
     */
    public function addElement(array $element): array;

    /**
     * @param int $elementId
     * @param array $element
     *
     * @return int
     *
     * @throws ExecutorException
     */
    public function editElement(int $elementId, array $element): int;

    /**
     * @param int $elementId
     *
     * @return int
     *
     * @throws ExecutorException
     */
    public function deleteElement(int $elementId): int;
}