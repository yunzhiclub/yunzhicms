<?php
namespace app\field\controller;

use app\Common;

class BodyController extends FieldController
{
    public function makeToken()
    {
        return Common::makeTokenByMCA('field', 'Body', 'upload');
    }
}