<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * ATM Class
 * Contains account atm operation information
 */
class ATM
{
    // operation type
    protected $operationType = NULL;
    // operation result
    protected $operationResult = NULL;
    // input amount
    protected $input = 0.0;

    public function getOperationType()
    {
        return $this->operationType;
    }

    public function setOperationType($operationType)
    {
        $this->operationType = $operationType;
    }

    public function getOperationResult()
    {
        return $this->operationResult;
    }

    public function setOperationResult($operationResult)
    {
        $this->operationResult = $operationResult;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setInput($input)
    {
        $this->input = $input;
    }
}
