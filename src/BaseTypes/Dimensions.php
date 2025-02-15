<?php

declare(strict_types=1);

namespace CdekSDK2\BaseTypes;

use JMS\Serializer\Annotation\Type;

class Dimensions {

    /**
     * Ширина (см)
     * @Type("float")
     * @var float
     */
    public $width;

    /**
     * Высота (см)
     * @Type("float")
     * @var float
     */
    public $height;

    /**
     * Глубина (см)
     * @Type("float")
     * @var float
     */
    public $depth;
}
