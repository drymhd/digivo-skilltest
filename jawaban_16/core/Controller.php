<?php

namespace Core;

class Controller
{
    protected function view($view, $data = [])
    {
        return View::render($view, $data);
    }
}
