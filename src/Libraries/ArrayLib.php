<?php
/**
 * Author: Darcey Lloyd
 * Email: Darcey@aftc.io
 * Date: 17/01/2019
 * Time: 12:41
 */

namespace AFTC\Framework\Libraries;

use AFTC\Framework\Core\AFTC_Library;

Class ArrayLib extends AFTC_Library
{

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function clone($arr)
    {
        return array_map(function($element) {
            return ((is_array($element))
                ? $this->clone($element)
                : ((is_object($element))
                    ? clone $element
                    : $element
                )
            );
        }, $arr);
    }
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

}