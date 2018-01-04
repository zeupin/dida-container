<?php
/**
 * Dida Framework  -- A Rapid Development Framework
 * Copyright (c) Zeupin LLC. (http://zeupin.com)
 *
 * Licensed under The MIT License.
 * Redistributions of files must retain the above copyright notice.
 */

namespace Dida;

use \ArrayAccess;
use \Dida\ContainerException;

class Container implements ArrayAccess
{
    const VERSION = '20180104';

    const CLASSNAME_TYPE = 'classname';
    const CLOSURE_TYPE = 'closure';
    const INSTANCE_TYPE = 'instance';

    protected $_keys = [];

    protected $_classnames = [];
    protected $_closures = [];
    protected $_instances = [];
    protected $_singletons = [];


    public function __get($id)
    {
        if ($this->has($id)) {
            return $this->get($id);
        }

        throw new ContainerException(null, ContainerException::PROPERTY_NOT_FOUND);
    }


    public function offsetExists($id)
    {
        return $this->has($id);
    }


    public function offsetGet($id)
    {
        return $this->get($id);
    }


    public function offsetSet($id, $service)
    {
        return $this->set($id, $service);
    }


    public function offsetUnset($id)
    {
        return $this->remove($id);
    }


    public function has($id)
    {
        return array_key_exists($id, $this->_keys);
    }


    public function set($id, $service)
    {
        if ($this->has($id)) {
            $this->remove($id);
        }

        if (is_string($service)) {
            $this->_keys[$id] = self::CLASSNAME_TYPE;
            $this->_classnames[$id] = $service;
        } elseif (is_object($service)) {
            if ($service instanceof \Closure) {
                $this->_keys[$id] = self::CLOSURE_TYPE;
                $this->_closures[$id] = $service;
            } else {
                $this->_keys[$id] = self::INSTANCE_TYPE;
                $this->_instances[$id] = $service;
            }
        } else {
            throw new ContainerException(null, ContainerException::INVALID_SERVICE_TYPE);
        }

        return $this;
    }


    public function setSingleton($id, $service)
    {
        $this->set($id, $service);
        $this->_singletons[$id] = true;
        return $this;
    }


    public function get($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            throw new ContainerException(null, ContainerException::SERVICE_NOT_FOUND);
        }

        $obj = null;

        switch ($this->_keys[$id]) {
            case self::INSTANCE_TYPE:
                return $this->_instances[$id];

            case self::CLOSURE_TYPE:
                if (isset($this->_instances[$id])) {
                    return $this->_instances[$id];
                }

                $serviceInstance = call_user_func_array($this->_closures[$id], $parameters);
                $this->_instances[$id] = $serviceInstance;
                return $serviceInstance;

            case self::CLASSNAME_TYPE:
                if (isset($this->_instances[$id])) {
                    return $this->_instances[$id];
                }

                $class = new \ReflectionClass($this->_classnames[$id]);
                if (!$class->isInstantiable()) {
                    return null;
                }
                $serviceInstance = new $this->_classnames[$id];
                $this->_instances[$id] = $serviceInstance;
                return $serviceInstance;
        }
    }


    public function getNew($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            throw new ContainerException(null, ContainerException::SERVICE_NOT_FOUND);
        }

        if (isset($this->_singletons[$id])) {
            throw new ContainerException(null, ContainerException::SINGLETON_VIOLATE);
        }

        $obj = null;

        switch ($this->_keys[$id]) {
            case self::INSTANCE_TYPE:
                return $this->_instances[$id];

            case self::CLOSURE_TYPE:
                $serviceInstance = call_user_func_array($this->_closures[$id], $parameters);
                return $serviceInstance;

            case self::CLASSNAME_TYPE:
                $class = new \ReflectionClass($this->_classnames[$id]);
                if (!$class->isInstantiable()) {
                    return null;
                }
                $serviceInstance = new $this->_classnames[$id];
                return $serviceInstance;
        }
    }


    public function remove($id)
    {
        unset($this->_keys[$id]);
        unset($this->_classnames[$id], $this->_closures[$id], $this->_instances[$id], $this->_singletons[$id]);
    }


    public function keys()
    {
        return $this->_keys;
    }
}
