<?php
/**
 * Dida Framework  -- A Rapid Development Framework
 * Copyright (c) Zeupin LLC. (http://zeupin.com)
 *
 * Licensed under The MIT License.
 * Redistributions of files must retain the above copyright notice.
 */

namespace Dida;

class ContainerException extends \Exception
{
    const VERSION = '20180104';

    const PROPERTY_NOT_FOUND = 1001;

    const SERVICE_NOT_FOUND = 1002;

    const SINGLETON_VIOLATE = 1003;

    const INVALID_SERVICE_TYPE=1004;
}
