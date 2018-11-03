<?php
namespace Mt\Model;

use Fw\InstanceTrait;

abstract class Model
{
    use InstanceTrait {
        __construct as protected;
    }
}